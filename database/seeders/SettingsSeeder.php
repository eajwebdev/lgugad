<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'system_name' => 'GAD Management System',
                'photo_filename' => '1693925463_gad-logo.png',
            ]
        );
    }
}
