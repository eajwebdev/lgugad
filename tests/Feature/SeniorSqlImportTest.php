<?php

namespace Tests\Feature;

use App\Models\Citizen;
use App\Services\SeniorSqlImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SeniorSqlImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_imports_senior_rows_only_and_skips_orphan_details(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'senior-sql-');
        file_put_contents($path, <<<'SQL'
INSERT INTO `accesses` (`id`, `password`) VALUES (1, 'should-not-be-imported');
INSERT INTO `citizens` (`id`, `lname`, `fname`, `mname`, `status`) VALUES (16, 'Dela Cruz', 'Sample', 'A', 'Waiting');
INSERT INTO `citizen_i_s` (`id`, `cid`, `bday`, `age`, `gender`, `osca_idnum`) VALUES (16, '16', '1964-04-03', '60', 'Female', '00002');
INSERT INTO `citizen_bcks` (`id`, `cid`, `living_reside`) VALUES (1, '1', ',,,,,,,,,'), (15, '16', ',,,,,,,,,');
SQL);

        try {
            $counts = app(SeniorSqlImporter::class)->import($path);
            $this->assertSame(1, Citizen::count());
            $citizen = Citizen::with(['personal', 'family', 'education', 'background'])->findOrFail(16);
            $this->assertSame('00002', $citizen->personal->osca_idnum);
            $this->assertSame(now()->year - 1964 - (now()->format('md') < '0403' ? 1 : 0), $citizen->current_age);
            $this->assertNotNull($citizen->family);
            $this->assertNotNull($citizen->education);
            $this->assertSame(1, $citizen->background()->count());
            $this->assertSame(1, $counts['orphan_details_skipped']);

            $this->assertSame(1, Artisan::call('senior:import-sql', ['file' => $path]));
            $this->assertSame(1, Citizen::count());
        } finally {
            unlink($path);
        }
    }
}
