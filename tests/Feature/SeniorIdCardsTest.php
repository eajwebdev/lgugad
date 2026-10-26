<?php

namespace Tests\Feature;

use App\Models\Barangay;
use App\Models\Citizen;
use App\Models\User;
use App\Services\SeniorIdCards;
use Carbon\Carbon;
use Database\Seeders\MabinayAddressSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeniorIdCardsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([UsersTableSeeder::class, SettingsSeeder::class, MabinayAddressSeeder::class]);
        $this->admin = User::where('username', UsersTableSeeder::USERNAME)->firstOrFail();
        $this->actingAs($this->admin);
    }

    private function senior(string $fname, string $lname = 'Deguit', string $barangay = 'Bulwang'): Citizen
    {
        $this->post(route('citizenCreate'), [
            'lname' => $lname, 'fname' => $fname, 'mname' => 'Amper', 'gender' => 'Female', 'bday' => '1952-09-09', 'age' => 74,
        ])->assertSessionHas('success');

        $citizen = Citizen::where('fname', $fname)->where('lname', $lname)->firstOrFail();
        $citizen->personal->update(['add_brgy' => Barangay::where('name', $barangay)->value('id'), 'add_city' => '074614', 'add_prov' => '0746']);

        return $citizen;
    }

    private function pageCount(string $pdf): int
    {
        return preg_match_all('#/Type\s*/Page[^s]#', $pdf);
    }

    public function test_selected_seniors_are_laid_out_ten_per_sheet_with_optional_backs(): void
    {
        $ids = collect(range(1, 12))->map(fn ($i) => $this->senior('Senior' . $i)->id)->all();

        $withBacks = $this->post(route('citizenIdCards'), ['ids' => $ids, 'date_issued' => '2026-09-14', 'back' => '1'])->assertOk();
        $this->assertSame('application/pdf', $withBacks->headers->get('Content-Type'));
        $this->assertSame(4, $this->pageCount($withBacks->getContent()), '2 front sheets + 2 back sheets');

        $frontsOnly = $this->post(route('citizenIdCards'), ['ids' => array_slice($ids, 0, 3), 'date_issued' => '2026-09-14', 'back' => '0'])->assertOk();
        $this->assertSame(1, $this->pageCount($frontsOnly->getContent()));
    }

    public function test_selection_is_required_and_bounded(): void
    {
        $this->from(route('citizenRead'))->post(route('citizenIdCards'), ['date_issued' => '2026-09-14'])
            ->assertRedirect(route('citizenRead'))->assertSessionHasErrors('ids');
        $this->post(route('citizenIdCards'), ['ids' => [1], 'date_issued' => 'not a date'])->assertSessionHasErrors('date_issued');
        $this->post(route('citizenIdCards'), ['ids' => [999], 'date_issued' => '2026-09-14'])
            ->assertRedirect(route('citizenRead'))->assertSessionHas('error');
    }

    public function test_card_values_follow_the_template_format(): void
    {
        $citizen = $this->senior('Enriqueta');
        $citizen->personal->update(['osca_idnum' => '05781']);

        $pdf = app('dompdf.wrapper');
        $metrics = $pdf->getDomPDF()->getFontMetrics();
        $metrics->registerFont(['family' => 'Carlito', 'weight' => 'bold', 'style' => 'normal'], resource_path('fonts/Carlito-Bold.ttf'));

        $sheets = app(SeniorIdCards::class)->sheets(
            Citizen::withPersonalInfo()->get(), Carbon::parse('2026-09-14'), false, $metrics, $metrics->getFont('Carlito', 'bold')
        );
        $fields = collect($sheets[0][0]['fields'])->map(fn ($f) => $f['text']);

        $this->assertSame('05781', $fields['id_no']);
        $this->assertSame('ENRIQUETA AMPER DEGUIT', $fields['name']);
        $this->assertSame('SEPTEMBER 09, 1952', $fields['birth_date']);
        $this->assertSame('FEMALE', $fields['sex']);
        $this->assertSame('BULWANG, Mabinay, Negros Oriental', $fields['address']);
        $this->assertSame('Sept. 14, 2026', $fields['date_issued']);
        $this->assertNull($sheets[0][0]['photo']);

        // A name too long for its line is shrunk to fit instead of overflowing.
        $long = (new Citizen)->forceFill(['fname' => 'Ma. Concepcion Esperanza', 'mname' => 'Villanueva', 'lname' => 'Dela Cruz']);
        $card = app(SeniorIdCards::class)->sheets(collect([$long]), Carbon::parse('2026-09-14'), false, $metrics, $metrics->getFont('Carlito', 'bold'))[0][0];
        $this->assertLessThan(SeniorIdCards::FIELDS['name']['size'], $card['fields']['name']['fitted']);
        $this->assertLessThanOrEqual(
            SeniorIdCards::FIELDS['name']['max'],
            $metrics->getTextWidth($card['fields']['name']['text'], $metrics->getFont('Carlito', 'bold'), $card['fields']['name']['fitted'])
        );
    }

    public function test_layout_helpers(): void
    {
        $this->assertSame('Sept. 14, 2026', SeniorIdCards::issuedLabel(Carbon::parse('2026-09-14')));
        $this->assertSame('May 5, 2026', SeniorIdCards::issuedLabel(Carbon::parse('2026-05-05')));
        // Backs swap columns so they sit behind their fronts after a long-edge flip.
        $this->assertSame(['x' => 46.5, 'y' => 8.5], SeniorIdCards::origin(0));
        $this->assertSame(['x' => 313.5, 'y' => 8.5], SeniorIdCards::origin(0, true));
        $this->assertSame(['x' => 46.5, 'y' => 732.8], SeniorIdCards::origin(9, true));
    }

    public function test_demo_seniors_can_be_added_and_removed_without_touching_real_records(): void
    {
        $real = $this->senior('Juana');

        $this->artisan('senior:demo', ['count' => 12])->assertSuccessful();
        $this->assertSame(13, Citizen::count());
        $this->assertSame(12, Citizen::whereHas('personal', fn ($q) => $q->whereNotNull('add_brgy')->where('email', 'like', '%@example.com'))->count());

        $this->artisan('senior:demo', ['--remove' => true])->assertSuccessful();
        $this->assertSame([$real->id], Citizen::pluck('id')->all());
        $this->assertFileExists(public_path('uploads/female-profile.png'));
    }

    public function test_list_offers_selection(): void
    {
        $citizen = $this->senior('Juana');

        $this->get(route('citizenRead'))->assertOk()
            ->assertSee('Generate ID cards')
            ->assertSee('value="' . $citizen->id . '"', false)
            ->assertSee(route('citizenIdCards'), false);
    }
}
