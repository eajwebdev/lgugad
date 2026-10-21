<?php

namespace Database\Seeders;

use App\Console\Commands\ImportAddressData;
use App\Models\Barangay;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            SettingsSeeder::class,
        ]);

        $this->seedAddresses();
    }

    /**
     * Full Philippine address data from public/uploads/sqldata when available (MySQL dumps),
     * otherwise just Mabinay. Skipped if the full dataset is already loaded.
     */
    private function seedAddresses(): void
    {
        $hasDataFiles = is_file(ImportAddressData::defaultPath() . '/barangays.sql');
        $isMysql = $this->container['db']->connection()->getDriverName() === 'mysql';

        if ($hasDataFiles && $isMysql) {
            if (Barangay::count() > 1000) {
                $this->command?->info('Address data already loaded; skipping. Use php artisan address:import to reload it.');

                return;
            }

            $this->command?->call('address:import');

            return;
        }

        $this->call(MabinayAddressSeeder::class);
    }
}
