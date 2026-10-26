<?php

namespace Tests\Feature;

use App\Models\Assistance;
use App\Models\Citizen;
use App\Models\CitizenBck;
use App\Models\CitizenI;
use App\Models\Dafac;
use App\Models\MabinayBrgy;
use App\Models\Pwd;
use App\Models\SoloParent;
use App\Models\User;
use App\Models\Vawc;
use Database\Seeders\MabinayAddressSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class SingleDatabaseModulesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Mabinay-only address data: the full PSGC import is MySQL-specific and too large for each test.
        $this->seed([UsersTableSeeder::class, SettingsSeeder::class, MabinayAddressSeeder::class]);
        $this->admin = User::where('username', UsersTableSeeder::USERNAME)->firstOrFail();
    }

    private function staffWithAccess(string $access): User
    {
        return User::create([
            'fname' => 'Staff', 'mname' => 'S', 'lname' => 'User', 'gender' => 'Female',
            'username' => 'staff' . uniqid(), 'password' => bcrypt('secret'),
            'role' => 'Office Staff', 'access' => $access,
        ]);
    }

    private function registerCitizen(string $fname = 'Juan'): Citizen
    {
        $this->actingAs($this->admin)->post(route('citizenCreate'), [
            'lname' => 'Dela Cruz', 'fname' => $fname, 'mname' => 'Santos',
            'gender' => 'Male', 'bday' => '1950-05-01', 'age' => 75,
        ])->assertSessionHas('success');

        return Citizen::where('fname', $fname)->firstOrFail();
    }

    public function test_every_model_uses_the_default_connection(): void
    {
        foreach ([Citizen::class, CitizenI::class, Dafac::class, Assistance::class, Pwd::class, SoloParent::class, Vawc::class] as $model) {
            $this->assertSame(config('database.default'), (new $model)->getConnection()->getName(), $model);
        }
    }

    public function test_admin_seeder_sets_requested_account_and_updates_existing_login(): void
    {
        $this->assertSame('Jophed', $this->admin->fname);
        $this->assertSame('Abril', $this->admin->lname);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password123', $this->admin->password));
        $this->assertSame('1,1,1,1,1,1,1,1', $this->admin->access);

        $this->admin->update(['username' => 'Administrator', 'password' => bcrypt('old-password')]);
        $this->seed(\Database\Seeders\UsersTableSeeder::class);

        $this->assertSame(1, User::count());
        $this->assertSame('administrator', $this->admin->fresh()->username);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password123', $this->admin->fresh()->password));
    }

    public function test_login_and_module_pages_render(): void
    {
        $this->post(route('postLogin'), ['username' => 'administrator', 'password' => 'password123'])
            ->assertRedirect(route('dashboard'));

        foreach (['dashboard', 'citizenRead', 'dafacRead', 'dafacForm', 'assRead', 'pwdRead', 'pwdForm',
                  'soloparentRead', 'soloparentForm', 'vawcRead', 'vawcForm', 'userRead', 'setting_list'] as $route) {
            $this->get(route($route))->assertOk();
        }
        foreach (['pwdRead' => 'PWD records', 'pwdForm' => 'Add PWD record',
                  'soloparentRead' => 'Solo parent records', 'soloparentForm' => 'Add solo parent',
                  'vawcRead' => 'VAWC records', 'vawcForm' => 'Add VAWC record',
                  'citizenRead' => 'Senior citizen records', 'userRead' => 'User accounts'] as $route => $heading) {
            $this->get(route($route))->assertSee($heading);
        }
        $this->get(route('dashboardFaced', 1))->assertRedirect(route('dashboard', ['tab' => 'faced']));
        $this->get(route('generateReports', ['gender' => 'Female', 'agebracket' => '70-79']))->assertOk();
        $this->get(route('generateReports', ['agebracket' => '1-200']))->assertSessionHasErrors('agebracket');
    }

    public function test_module_access_flags_are_enforced(): void
    {
        // Only the VAWC flag (index 5) set.
        $staff = $this->staffWithAccess('0,0,0,0,0,1,0');

        $this->actingAs($staff)->get(route('vawcRead'))->assertOk();
        $this->actingAs($staff)->get(route('citizenRead'))->assertRedirect(route('dashboard'));
        $this->actingAs($staff)->get(route('assRead'))->assertRedirect(route('dashboard'));
        $this->actingAs($staff)->get(route('userRead'))->assertRedirect(route('dashboard'));
    }

    public function test_registering_a_citizen_creates_all_detail_rows_with_sequential_osca_ids(): void
    {
        $first = $this->registerCitizen('Juan');
        $second = $this->registerCitizen('Pedro');

        $this->assertSame('00001', $first->personal->osca_idnum);
        $this->assertSame('00002', $second->personal->osca_idnum);
        $this->assertNotNull($first->family);
        $this->assertNotNull($first->education);
        $this->assertSame(',,,,,,,,,', $first->background->living_reside);

        $this->post(route('citizenCreate'), [
            'lname' => 'Dela Cruz', 'fname' => 'Juan', 'mname' => 'Santos',
            'gender' => 'Male', 'bday' => '1950-05-01', 'age' => 75,
        ])->assertSessionHas('error', 'Citizen already exists.');
    }

    public function test_more_info_inline_update_is_allow_listed(): void
    {
        $citizen = $this->registerCitizen();

        $this->postJson(route('MoreInfoUpdate'), ['cid' => $citizen->id, 'model' => 'CitizenI', 'data' => 'religion', 'value' => 'Catholic'])
            ->assertOk();
        $this->assertSame('Catholic', $citizen->personal()->first()->religion);

        // Toggle slot 2 of a CSV checkbox column on, then off again.
        $this->postJson(route('MoreInfoUpdate'), ['cid' => $citizen->id, 'model' => 'CitizenBck', 'data' => 'living_reside', 'value' => 'Alone', 'array' => 2])->assertOk();
        $this->assertSame(',,Alone,,,,,,,', CitizenBck::where('cid', $citizen->id)->value('living_reside'));
        $this->postJson(route('MoreInfoUpdate'), ['cid' => $citizen->id, 'model' => 'CitizenBck', 'data' => 'living_reside', 'value' => 'Alone', 'array' => 2])->assertOk();
        $this->assertSame(',,,,,,,,,', CitizenBck::where('cid', $citizen->id)->value('living_reside'));

        $this->postJson(route('MoreInfoUpdate'), ['cid' => $citizen->id, 'model' => 'User', 'data' => 'role', 'value' => 'x'])->assertStatus(422);
        $this->postJson(route('MoreInfoUpdate'), ['cid' => $citizen->id, 'model' => 'Citizen', 'data' => 'status', 'value' => 'x'])->assertStatus(422);

        $this->postJson(route('addressUpdate'), ['id' => $citizen->id, 'column' => 'add_city', 'value' => '074614'])->assertOk();
        $this->postJson(route('addressUpdate'), ['id' => $citizen->id, 'column' => 'osca_idnum', 'value' => '1'])->assertStatus(422);

        $this->postJson(route('updateCitizenStatus', $citizen->id), ['status' => 'Deceased'])->assertOk();
        $this->postJson(route('updateCitizenStatus', $citizen->id), ['status' => 'Hacked'])->assertStatus(422);
    }

    public function test_citizen_pdf_id_card_and_delete(): void
    {
        $citizen = $this->registerCitizen();

        $this->get(route('citizenMoreInfo', encrypt($citizen->id)))->assertOk();
        $this->get(route('citizenMoreInfo', 'tampered'))->assertNotFound();
        $this->post(route('citizenIdCards'), ['ids' => [$citizen->id], 'date_issued' => '2026-09-14'])->assertOk();
        $this->get(route('citizenReadPdf', encrypt($citizen->id)))->assertOk();

        $this->get(route('citizenDelete', $citizen->id))->assertStatus(405);
        $this->deleteJson(route('citizenDelete', $citizen->id))->assertOk();
        $this->assertDatabaseCount('citizens', 0);
        $this->assertDatabaseCount('citizen_i_s', 0);
        $this->assertDatabaseCount('citizen_bcks', 0);
    }

    public function test_dafac_lifecycle_with_assistance(): void
    {
        $this->actingAs($this->admin);
        $brgyId = \App\Models\Barangay::where('name', 'Poblacion')->value('id');

        $payload = [
            'add_region' => '07', 'add_prov' => '0746', 'add_city' => '074614', 'add_brgy' => $brgyId,
            'district' => '2nd', 'brgy_evac_site' => 'School', 'count' => '0001', 'serial' => 'S-1',
            'surname' => 'Reyes', 'fname' => 'Ana', 'mname' => 'Lopez', 'gender' => 'F',
            'd_birth' => '1980-01-01', 'age' => 44, 'b_place' => 'Mabinay', 'civil_status' => 'Married',
            'm_maid_name' => 'Cruz', 'religion' => 'Catholic', 'occupation' => 'Farmer', 'mincome' => '5,500.50',
            'id_present' => 'Voter ID', 'id_cardnum' => '123', 'per_address' => 'Poblacion',
            'ps_benef' => '1', 'checklist1' => 2, 'checklist3' => 1,
            'mem_fname' => ['Ben', 'Cara'], 'mem_relation' => ['Son', 'Daughter'], 'mem_bdate' => ['2010-01-01', '2012-01-01'],
            'mem_age' => ['14', '12'], 'mem_gender' => ['M', 'F'], 'mem_educ' => ['HS', 'Elem'],
            'mem_occup' => ['', ''], 'mem_remarks' => ['', ''],
        ];

        $this->post(route('dafacCreate'), $payload)->assertSessionHas('success');
        $dafac = Dafac::firstOrFail();
        $this->assertEquals(5500.50, (float) $dafac->mincome);
        $this->assertTrue($dafac->ps_benef);
        $this->assertFalse($dafac->ip);
        $this->assertSame('2,0,1,0,0,0', $dafac->checklist);
        $this->assertSame('Ben,Cara', $dafac->mem_fname);
        $this->assertSame('0002', Dafac::nextCount());

        $encrypted = Crypt::encryptString($dafac->id);
        $this->post(route('dafacUpdate'), array_merge($payload, ['id' => $encrypted, 'fname' => 'Anna']))->assertSessionHas('success');
        $this->assertSame('Anna', $dafac->fresh()->fname);

        $this->get(route('dafacRead'))->assertOk()->assertSee('Poblacion');
        $this->get(route('dafacEdit', $encrypted))->assertOk();
        $this->get(route('dafacPdf', [$encrypted, 1]))->assertOk();
        $this->get(route('dafacPdf', [$encrypted, 2]))->assertOk();

        $this->post(route('assCreate'), [
            'did' => $encrypted, 'fam_mem' => 'Ben', 'em_dis' => 'Typhoon', 'assistance' => 'Rice',
            'unit' => 'sack', 'quantity' => 2, 'cost' => '1,250', 'provider' => 'DSWD', 'created_at' => '2024-11-02',
        ])->assertSessionHas('success');
        $assistance = Assistance::firstOrFail();
        $this->assertSame('2024-11-02', $assistance->created_at->toDateString());
        $this->get(route('assRead', ['did' => $encrypted]))->assertOk();

        $this->deleteJson(route('dafacDelete', $dafac->id))->assertOk();
        $this->assertDatabaseCount('assistances', 0);
    }

    public function test_pwd_solo_parent_and_vawc_records_are_saved(): void
    {
        $this->actingAs($this->admin);
        $brgy = MabinayBrgy::firstOrFail();

        $this->post(route('pwdCreate'), [
            'applicant' => 'New', 'person_with' => 'Disability', 'date_app' => '2024-10-01',
            'lname' => 'Lim', 'fname' => 'Rey', 'mname' => 'Tan', 'dob' => '1990-02-02', 'gender' => 'M',
            'c_status' => 'Single', 'type_dis' => ['Visual', 'Hearing'], 'r_address' => 'Purok 1', 'street' => 'Main',
            'brangay' => $brgy->id, 'municipality' => 'Mabinay', 'province' => 'Negros Oriental', 'region' => 'VII',
            'l_no' => '123', 'm_no' => '0917', 'educ_attain' => 'College',
        ])->assertSessionHas('success');
        $this->assertSame('Visual,Hearing', Pwd::firstOrFail()->type_dis);
        $this->get(route('pwdRead'))->assertOk()->assertSee($brgy->brgy_name);

        $this->post(route('soloparentCreate'), [
            'cname' => 'Maria', 'gender' => 'Female', 'dob' => '1985-03-03', 'age' => 39, 'address' => 'Tara',
            'h_education' => 'HS', 'occupation' => 'Vendor', 'monthly_income' => '3000', 'class_circum' => 'Widowed',
            'needs_prob' => 'Financial', 'mem_fname' => ['Kid'], 'mem_relation' => ['Son'], 'mem_age' => [5],
            'mem_status' => ['Single'], 'mem_educ' => ['None'], 'mem_bdate' => ['2019-01-01'],
        ])->assertSessionHas('success');
        $this->assertSame('Kid', SoloParent::firstOrFail()->mem_fname);

        $this->post(route('vawcCreate'), [
            'source' => 'Barangay', 'cname' => 'Lia', 'nname' => 'Li', 'dob' => '2010-04-04', 'age' => 14, 'gender' => 'F',
            'religion' => 'Catholic', 'pb' => 'Mabinay', 'n_viewer' => 'Officer', 'problem' => 'p', 'findings' => 'f',
            'remarks' => 'r', 'p_address' => 'Tara', 'h_address' => 'Tara', 'educ_attain' => 'Elem', 'school' => 'MES',
            'date_int' => '2024-10-10', 'mem_fname' => ['Mom'], 'mem_relation' => ['Mother'], 'mem_age' => [40],
            'mem_gender' => ['F'], 'mem_educ' => ['HS'], 'mem_occup' => ['None'], 'mem_monthly' => ['0'], 'mem_address' => ['Tara'],
        ])->assertSessionHas('success');
        $this->assertSame('Mom', Vawc::firstOrFail()->mem_fname);

        $this->get(route('dashboard'))->assertOk();
    }

    public function test_dashboard_filters_the_same_records_used_by_cards_and_charts(): void
    {
        $this->actingAs($this->admin);
        $citizen = $this->registerCitizen('Dashboard Client');
        $barangays = \App\Models\Barangay::orderBy('id')->take(2)->get();
        $citizen->personal->update(['add_brgy' => $barangays[0]->id]);

        $this->get(route('dashboard', ['tab' => 'seniors', 'barangay' => $barangays[0]->id]))
            ->assertOk()
            ->assertViewHas('report', fn ($report) => $report['total'] === 1 && $report['charts'][0]['values'][11] === 1);
        $this->get(route('dashboard', ['tab' => 'seniors', 'barangay' => $barangays[1]->id]))
            ->assertOk()
            ->assertViewHas('report', fn ($report) => $report['total'] === 0);
        $this->get(route('dashboard', ['tab' => 'seniors', 'range' => now()->subDays(10)->toDateString() . ' - ' . now()->subDay()->toDateString()]))
            ->assertOk()
            ->assertViewHas('report', fn ($report) => $report['total'] === 0);
        $this->get(route('dashboard', ['tab' => 'users', 'barangay' => $barangays[0]->id]))
            ->assertOk()
            ->assertViewHas('report', fn ($report) => $report['total'] >= 1);
        $this->get(route('dashboard', ['tab' => 'seniors', 'range' => '2026-99-99 - 2026-99-99']))
            ->assertStatus(422);
    }

    public function test_user_management_builds_access_flags(): void
    {
        $this->actingAs($this->admin);

        $this->post(route('userCreate'), [
            'fname' => 'Kim', 'mname' => 'L', 'lname' => 'Go', 'gender' => 'Female', 'username' => 'kim',
            'password' => 'secret1', 'Role' => 'Office Staff', 'access' => [1 => '1', 4 => '1'],
        ])->assertSessionHas('success');
        $kim = User::where('username', 'kim')->firstOrFail();
        $this->assertSame('0,1,0,0,1,0,0,0', $kim->access);
        $this->assertTrue($kim->canAccessModule('senior'));
        $this->assertFalse($kim->canAccessModule('vawc'));

        $this->post(route('userUpdate'), [
            'uid' => $kim->id, 'fname' => 'Kim', 'mname' => 'L', 'lname' => 'Go', 'gender' => 'Female',
            'username' => 'kim', 'Role' => 'Administrator', 'access' => [0 => '1'],
        ])->assertSessionHas('success');
        $this->assertSame('1,0,0,0,0,0,1,0', $kim->fresh()->access);

        $this->deleteJson(route('userDelete', $this->admin->id))->assertStatus(422);
        $this->deleteJson(route('userDelete', $kim->id))->assertOk();
    }
}
