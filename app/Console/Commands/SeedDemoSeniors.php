<?php

namespace App\Console\Commands;

use App\Models\Barangay;
use App\Models\Citizen;
use App\Services\CitizenService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Dummy senior citizens for trying out the senior pages and ID cards. Every dummy record has an
 * @example.com email, which is how --remove finds them; real records are never touched.
 */
class SeedDemoSeniors extends Command
{
    protected $signature = 'senior:demo {count=35 : How many dummy seniors to add} {--remove : Delete the dummy seniors instead}';
    protected $description = 'Add (or remove) dummy senior citizen records for testing';

    private const MARKER_DOMAIN = '@example.com';
    private const HOME_CITY_ID = '074614';
    private const PROVINCE_ID = '0746';
    private const REGION_ID = '07';

    private const FEMALE_NAMES = ['Enriqueta', 'Nellie', 'Rosine', 'Pacita', 'Blandie', 'Nemia', 'Merlinda', 'Leonita', 'Basilisa', 'Angelina', 'Ma. Concepcion Esperanza', 'Teresita', 'Lourdes', 'Corazon', 'Felicidad', 'Remedios', 'Milagros', 'Erlinda'];
    private const MALE_NAMES = ['Jimmy', 'Aniceto', 'Eddie Berto', 'Edgardo', 'Miguel', 'Ernesto', 'Teodolo', 'Rogelio', 'Danilo', 'Florencio', 'Gregorio', 'Isidro', 'Leopoldo', 'Restituto', 'Wilfredo', 'Bienvenido'];
    private const SURNAMES = ['Deguit', 'Estonanto', 'Mission', 'Abuso', 'Ybañez', 'Depalas', 'Temblor', 'Sapos', 'Aniñon', 'Iñosa', 'Cara', 'Amahit', 'Quiñones', 'Vicada', 'Malalay', 'Abestano', 'Gutang', 'Villanueva Dela Cruz', 'Candol', 'Tijano', 'Heramis', 'Lacorte', 'Cadivida', 'Baldomar', 'Talledo', 'Habedo', 'Amper', 'Onal', 'Libaton', 'Estacion'];
    private const RELIGIONS = ['Roman Catholic', 'Roman Catholic', 'Roman Catholic', 'Iglesia ni Cristo', 'Seventh-day Adventist', 'Baptist'];
    private const CIVIL_STATUSES = ['Married', 'Married', 'Widowed', 'Widowed', 'Single', 'Separated'];

    public function handle(CitizenService $citizens): int
    {
        return $this->option('remove') ? $this->remove($citizens) : $this->add($citizens);
    }

    private function add(CitizenService $citizens): int
    {
        $count = (int) $this->argument('count');
        if ($count < 1 || $count > 500) {
            $this->error('Count must be between 1 and 500.');
            return self::FAILURE;
        }

        $barangays = Barangay::where('city_id', self::HOME_CITY_ID)->orderBy('name')->get(['id', 'name']);
        if ($barangays->isEmpty()) {
            $this->error('Mabinay barangays are missing. Run php artisan db:seed first.');
            return self::FAILURE;
        }

        // Same names and dates on every run, so a fresh demo set looks the same each time.
        mt_srand(2026);
        $added = 0;
        $skipped = 0;
        for ($i = 0; $i < $count; $i++) {
            $female = $i % 2 === 0;
            $fname = $this->pick($female ? self::FEMALE_NAMES : self::MALE_NAMES, $i);
            $mname = $this->pick(self::SURNAMES, $i * 7 + 3);
            $lname = $this->pick(self::SURNAMES, $i * 3 + 1);
            if ($mname === $lname) {
                $mname = $this->pick(self::SURNAMES, $i * 7 + 4);
            }
            if ($citizens->exists($lname, $fname, $mname)) {
                $skipped++;
                continue;
            }

            // Ages 60 to 95.
            $birthday = Carbon::today()->subYears(mt_rand(60, 95))->subDays(mt_rand(0, 364));
            $barangay = $barangays[mt_rand(0, $barangays->count() - 1)];

            $citizen = $citizens->register([
                'lname' => $lname,
                'fname' => $fname,
                'mname' => $mname,
                'ext' => ! $female && $i % 9 === 1 ? 'Jr.' : null,
                'gender' => $female ? 'Female' : 'Male',
                'bday' => $birthday->format('Y-m-d'),
                'age' => $birthday->age,
            ]);

            $citizen->personal->update([
                'add_region' => self::REGION_ID,
                'add_prov' => self::PROVINCE_ID,
                'add_city' => self::HOME_CITY_ID,
                'add_brgy' => $barangay->id,
                'house_purok' => 'Purok ' . mt_rand(1, 7),
                'p_birth' => 'Mabinay, Negros Oriental',
                'm_status' => self::CIVIL_STATUSES[mt_rand(0, count(self::CIVIL_STATUSES) - 1)],
                'religion' => self::RELIGIONS[mt_rand(0, count(self::RELIGIONS) - 1)],
                'contact' => '09' . mt_rand(10, 99) . ' ' . mt_rand(100, 999) . ' ' . mt_rand(1000, 9999),
                'email' => 'senior.demo' . ($i + 1) . self::MARKER_DOMAIN,
            ]);

            $citizen->update([
                'status' => $i % 11 === 10 ? 'Deceased' : ($i % 4 === 3 ? 'Waiting' : 'Active / Pensioner'),
                // Every third senior gets a placeholder photo; each has its own copy so deleting one is safe.
                'profile' => $i % 3 === 0 ? $this->photoCopy($citizen, $female) : null,
            ]);
            $added++;
        }

        $this->info("Added {$added} dummy senior citizens" . ($skipped ? " ({$skipped} already existed)" : '') . '.');
        $this->line('Remove them later with: php artisan senior:demo --remove');

        return self::SUCCESS;
    }

    private function remove(CitizenService $citizens): int
    {
        $demo = Citizen::whereHas('personal', fn ($q) => $q->where('email', 'like', '%' . self::MARKER_DOMAIN))->get();
        foreach ($demo as $citizen) {
            $citizens->delete($citizen);
        }

        $this->info("Removed {$demo->count()} dummy senior citizens.");

        return self::SUCCESS;
    }

    private function pick(array $list, int $i): string
    {
        return $list[$i % count($list)];
    }

    private function photoCopy(Citizen $citizen, bool $female): ?string
    {
        $source = public_path('uploads/' . ($female ? 'female' : 'male') . '-profile.png');
        if (! is_file($source)) {
            return null;
        }

        $relative = 'uploads/senior-profile/demo_' . Str::random(16) . '.png';
        File::ensureDirectoryExists(public_path('uploads/senior-profile'));
        File::copy($source, public_path($relative));

        return $relative;
    }
}
