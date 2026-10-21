<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\City;
use App\Models\MabinayBrgy;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Database\Seeder;

/**
 * Address data for Mabinay, Negros Oriental: the `mabinay_brgys` list (PWD, Solo Parent, VAWC forms)
 * and the Region VII > Negros Oriental > Mabinay chain used by the DAFAC and senior forms.
 *
 * For addresses outside Mabinay, import a full PSGC dataset into regions/provinces/cities/barangays.
 */
class MabinayAddressSeeder extends Seeder
{
    private const REGION_ID = '07';
    private const PROVINCE_ID = '0746';
    private const CITY_ID = '074614';

    private const BARANGAYS = [
        'Abis', 'Arebasore', 'Bagtic', 'Banban', 'Barras', 'Bato', 'Bugnay', 'Bulibulihan',
        'Bulwang', 'Campanun-An', 'Canggohob', 'Cansal-ing', 'Dagbasan', 'Dahile', 'Hagtu',
        'Himocdongon', 'Inapoy', 'Lamdas', 'Lumbangan', 'Luyang', 'Manlingay', 'Mayaposi',
        'Napasu-An', 'New Namangka', 'Old Namangka', 'Pandanon', 'Paniabonan', 'Pantao',
        'Poblacion', 'Samac', 'Tadlong', 'Tara',
    ];

    public function run()
    {
        Region::firstOrCreate(
            ['region_id' => self::REGION_ID],
            ['code' => self::REGION_ID, 'name' => 'REGION VII (CENTRAL VISAYAS)']
        );

        Province::firstOrCreate(
            ['province_id' => self::PROVINCE_ID],
            ['region_id' => self::REGION_ID, 'name' => 'NEGROS ORIENTAL']
        );

        City::firstOrCreate(
            ['city_id' => self::CITY_ID],
            ['code' => self::CITY_ID, 'region_id' => self::REGION_ID, 'province_id' => self::PROVINCE_ID, 'name' => 'MABINAY']
        );

        foreach (self::BARANGAYS as $i => $name) {
            $number = $i + 1;

            MabinayBrgy::firstOrCreate(['brgy_name' => $name], ['brgy_code' => (string) $number]);

            Barangay::firstOrCreate(
                ['city_id' => self::CITY_ID, 'name' => $name],
                [
                    'code' => self::CITY_ID . str_pad($number, 3, '0', STR_PAD_LEFT),
                    'region_id' => self::REGION_ID,
                    'province_id' => self::PROVINCE_ID,
                ]
            );
        }
    }
}
