<?php

namespace Tests\Feature;

use App\Models\DayCareWorker;
use App\Models\User;
use Database\Seeders\MabinayAddressSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DayCareWorkerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([UsersTableSeeder::class, SettingsSeeder::class, MabinayAddressSeeder::class]);
        $this->admin = User::where('username', UsersTableSeeder::USERNAME)->firstOrFail();
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'last_name' => 'Dela Cruz', 'first_name' => 'Juana', 'middle_name' => 'Santos', 'sex' => 'Female',
            'birthday' => '1988-03-14', 'religion' => 'Roman Catholic', 'ethnicity' => 'Cebuano',
            'civil_status' => 'Married', 'no_children' => 3,
            'address_no' => '12', 'address_street' => 'Rizal St.', 'address_barangay' => 'Poblacion',
            'address_city' => 'Mabinay', 'address_province' => 'Negros Oriental', 'address_region' => 'Region VII',
            'mobile_no' => '0917 123 4567', 'email' => 'juana@example.com',
            'education' => 'College Graduate', 'degree' => 'BEEd',
            'eligibility' => ['Licensure Examination for Teachers', 'Others'], 'eligibility_other' => 'TESDA NC II',
            'years_as_cdw' => 12, 'center_name' => 'Poblacion Child Development Center',
            'compensation_types' => ['Honoraria', 'Allowance'], 'total_compensation' => '8,500.00',
            'compensation_sources' => ['barangay', 'city'], 'amount_barangay' => '2,500', 'amount_city' => '6000',
            'employment_term' => 'Contract of Service',
            'trainings' => [
                ['title' => 'ECCD Basic Training, Batch 2', 'dates' => 'Jan 15-19, 2024', 'hours' => '40', 'sponsor' => 'DSWD'],
                ['title' => '', 'dates' => '', 'hours' => '', 'sponsor' => ''],
                ['title' => 'Child Protection Seminar', 'dates' => 'Jul 10, 2022', 'hours' => '8', 'sponsor' => 'MSWDO'],
                ['title' => '', 'dates' => '', 'hours' => '', 'sponsor' => ''],
            ],
            'other_courses' => [['course' => 'First Aid', 'year' => '2021'], ['course' => '', 'year' => '']],
            'accreditation_status' => 'Accredited', 'date_accredited' => '2022-06-30',
            'accreditation_no' => 'CDW-07-2022-0153', 'accreditation_level' => '2',
            'children_served' => 28, 'sessions_per_day' => '2', 'hours_per_session' => '2.5',
            'children_ages' => ['3', '4'], 'hours_in_center' => '6-7',
            'session_method' => 'With reference materials', 'date_conducted' => '2026-10-26',
        ], $overrides);
    }

    public function test_pages_and_blank_form_6_render(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('daycareRead'))->assertOk()->assertSee('Child development worker records');
        $this->get(route('daycareForm'))->assertOk()->assertSee('Add worker profile')
            ->assertSee('value="Mabinay"', false)->assertSee('value="Negros Oriental"', false)->assertSee('value="Region VII"', false);

        $blank = $this->get(route('daycareBlankPdf'))->assertOk();
        $this->assertSame('application/pdf', $blank->headers->get('Content-Type'));
        $this->assertStringStartsWith('%PDF', $blank->getContent());
    }

    public function test_profile_lifecycle(): void
    {
        $this->actingAs($this->admin);

        $this->post(route('daycareCreate'), $this->payload())
            ->assertRedirect(route('daycareRead'))->assertSessionHas('success');

        $worker = DayCareWorker::firstOrFail();
        $this->assertSame('Dela Cruz, Juana Santos', $worker->form_name);
        $this->assertSame(38, $worker->age);
        $this->assertEquals(8500, (float) $worker->total_compensation);
        $this->assertEquals(2500, (float) $worker->amount_barangay);
        $this->assertSame(['Licensure Examination for Teachers', 'Others'], $worker->eligibility);
        $this->assertTrue($worker->hasChoice('children_ages', 4));
        $this->assertFalse($worker->hasChoice('children_ages', 0));
        // Blank rows are dropped; a comma inside a title survives.
        $this->assertCount(2, $worker->trainings);
        $this->assertSame('ECCD Basic Training, Batch 2', $worker->trainings[0]['title']);
        $this->assertSame([['course' => 'First Aid', 'year' => '2021']], $worker->other_courses);

        $encrypted = Crypt::encryptString($worker->id);
        $this->get(route('daycareRead'))->assertOk()->assertSee('Poblacion Child Development Center');
        $this->get(route('daycareEdit', $encrypted))->assertOk()->assertSee('Edit worker profile')->assertSee('CDW-07-2022-0153');

        $pdf = $this->get(route('daycarePdf', $encrypted))->assertOk();
        $this->assertStringStartsWith('%PDF', $pdf->getContent());

        // Unticking "Others" clears its text.
        $this->post(route('daycareUpdate', $encrypted), $this->payload(['first_name' => 'Juanita', 'eligibility' => ['None']]))
            ->assertSessionHas('success');
        $worker->refresh();
        $this->assertSame('Juanita', $worker->first_name);
        $this->assertSame(['None'], $worker->eligibility);
        $this->assertNull($worker->eligibility_other);

        $this->deleteJson(route('daycareDelete', $worker->id))->assertOk();
        $this->assertDatabaseCount('day_care_workers', 0);
    }

    public function test_validation_rejects_values_outside_the_form_choices(): void
    {
        $this->actingAs($this->admin)
            ->post(route('daycareCreate'), $this->payload([
                'civil_status' => 'Divorced', 'hours_per_session' => '5', 'children_ages' => ['7'],
                'trainings' => array_fill(0, 5, ['title' => 'X']), 'center_name' => '',
            ]))
            ->assertSessionHasErrors(['civil_status', 'hours_per_session', 'children_ages.0', 'trainings', 'center_name']);

        $this->assertDatabaseCount('day_care_workers', 0);
        $this->get(route('daycareEdit', 'not-an-encrypted-id'))->assertNotFound();
    }

    public function test_module_requires_the_daycare_access_flag(): void
    {
        $withoutFlag = User::create([
            'fname' => 'Staff', 'mname' => 'S', 'lname' => 'User', 'gender' => 'Female', 'username' => 'nodaycare',
            'password' => bcrypt('secret'), 'role' => 'Office Staff', 'access' => '1,1,1,1,1,1,0,0',
        ]);
        $withFlag = User::create([
            'fname' => 'Staff', 'mname' => 'S', 'lname' => 'User', 'gender' => 'Female', 'username' => 'daycare',
            'password' => bcrypt('secret'), 'role' => 'Office Staff', 'access' => '0,0,0,0,0,0,0,1',
        ]);

        $this->actingAs($withoutFlag)->get(route('daycareRead'))->assertRedirect(route('dashboard'));
        $this->actingAs($withoutFlag)->get(route('daycareBlankPdf'))->assertRedirect(route('dashboard'));
        $this->actingAs($withFlag)->get(route('daycareRead'))->assertOk();
        $this->actingAs($withFlag)->get(route('citizenRead'))->assertRedirect(route('dashboard'));
    }

    public function test_access_flag_migration_grants_existing_administrators(): void
    {
        DB::table('users')->where('id', $this->admin->id)->update(['access' => '1,1,1,1,1,1,1']);
        $staff = User::create([
            'fname' => 'Old', 'mname' => 'S', 'lname' => 'Staff', 'gender' => 'Male', 'username' => 'oldstaff',
            'password' => bcrypt('secret'), 'role' => 'Office Staff', 'access' => '0,1,0,0,0,0,0',
        ]);

        $migration = require database_path('migrations/2026_10_26_000001_add_daycare_flag_to_user_access.php');
        $migration->up();

        $this->assertSame('1,1,1,1,1,1,1,1', $this->admin->fresh()->access);
        $this->assertSame('0,1,0,0,0,0,0,0', $staff->fresh()->access);

        $migration->down();
        $this->assertSame('1,1,1,1,1,1,1', $this->admin->fresh()->access);
    }
}
