<?php

namespace App\Services;

use App\Models\Barangay;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Province;
use Carbon\Carbon;
use Dompdf\FontMetrics;
use Illuminate\Support\Collection;

/**
 * Senior Citizen's Identification Cards in the OSCA 2026 layout: ten cards per 8.5" x 13" sheet
 * (2 columns x 5 rows), optionally followed by a sheet of backs for duplex printing.
 *
 * Positions are in points, measured from the OSCA-ID-2026 Word template. Card values use Calibri Bold
 * in the template; Carlito Bold (metric-compatible) is used here.
 */
class SeniorIdCards
{
    public const PAPER = [0, 0, 612, 936];
    public const CARDS_PER_SHEET = 10;

    /** Card origins (top-left) on the sheet, row by row. */
    public const COLUMNS = [46.5, 313.5];
    public const ROWS = [8.5, 189.6, 370.6, 551.7, 732.8];
    public const CARD_WIDTH = 252;
    public const CARD_HEIGHT = 180;

    /** Inside of the 1x1 photo box, relative to the card. */
    public const PHOTO_BOX = ['x' => 7.6, 'y' => 56.1, 'width' => 68.2, 'height' => 68.4];

    /**
     * Card fields relative to the card: centre x, baseline y, font size and the widest the value may be
     * before it is shrunk to fit its line. Positions are the medians of the 30 filled cards in the template.
     */
    public const FIELDS = [
        'id_no' => ['x' => 217.3, 'baseline' => 63.73, 'size' => 11.04, 'max' => 60],
        'name' => ['x' => 165.5, 'baseline' => 84.97, 'size' => 11.04, 'max' => 163],
        'birth_date' => ['x' => 128.7, 'baseline' => 109.28, 'size' => 9.96, 'max' => 93],
        'age' => ['x' => 194.6, 'baseline' => 109.28, 'size' => 9.96, 'max' => 22],
        'sex' => ['x' => 229.3, 'baseline' => 109.28, 'size' => 9.96, 'max' => 37],
        'address' => ['x' => 163.7, 'baseline' => 134.32, 'size' => 9.96, 'max' => 160],
        'date_issued' => ['x' => 221.3, 'baseline' => 165.64, 'size' => 9.0, 'max' => 60],
    ];

    /** Smallest font size a long value is shrunk to. */
    private const MIN_SIZE = 6.0;

    /** Carlito Bold sits its baseline this many font sizes below the top of a line-height:1 box in DomPDF. */
    public const BASELINE_RATIO = 1.0748;

    private const MONTHS = [
        1 => 'Jan.', 2 => 'Feb.', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
        7 => 'July', 8 => 'Aug.', 9 => 'Sept.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.',
    ];

    /**
     * Groups the citizens into sheets of positioned cards.
     *
     * @param  Collection<int, Citizen>  $citizens  citizens merged with their personal info (citizen_i_s)
     * @return array<int, array<int, array>> sheets, each a list of cards
     */
    public function sheets(Collection $citizens, Carbon $dateIssued, bool $withPhotos, FontMetrics $metrics, string $fontFile): array
    {
        $addresses = $this->addressNames($citizens);
        $issued = self::issuedLabel($dateIssued);

        return $citizens->values()
            ->map(fn (Citizen $citizen, int $i) => $this->card($citizen, $i % self::CARDS_PER_SHEET, $issued, $withPhotos, $addresses, $metrics, $fontFile))
            ->chunk(self::CARDS_PER_SHEET)
            ->map(fn (Collection $cards) => $cards->values()->all())
            ->all();
    }

    /** "Sept. 14, 2026": month abbreviations as printed on the OSCA template. */
    public static function issuedLabel(Carbon $date): string
    {
        return self::MONTHS[$date->month] . ' ' . $date->day . ', ' . $date->year;
    }

    /**
     * Card origin for slot $slot (0-9). Backs are mirrored left/right so they line up when the sheet is
     * flipped on its long edge.
     */
    public static function origin(int $slot, bool $back = false): array
    {
        $column = $slot % 2;

        return [
            'x' => self::COLUMNS[$back ? 1 - $column : $column],
            'y' => self::ROWS[intdiv($slot, 2)],
        ];
    }

    private function card(Citizen $citizen, int $slot, string $issued, bool $withPhotos, array $addresses, FontMetrics $metrics, string $fontFile): array
    {
        $values = [
            'id_no' => (string) $citizen->osca_idnum,
            'name' => $this->upper(implode(' ', [$citizen->fname, $citizen->mname, $citizen->lname, $citizen->ext])),
            'birth_date' => $this->upper((string) $citizen->birthDate()?->format('F d, Y')),
            'age' => (string) ($citizen->current_age ?? ''),
            'sex' => $this->upper((string) $citizen->gender),
            'address' => $this->address($citizen, $addresses),
            'date_issued' => $issued,
        ];

        $fields = [];
        foreach (self::FIELDS as $key => $field) {
            $fields[$key] = $field + [
                'text' => $values[$key],
                'fitted' => $this->fittedSize($values[$key], $field['size'], $field['max'], $metrics, $fontFile),
            ];
        }

        return [
            'slot' => $slot,
            'origin' => self::origin($slot),
            'fields' => $fields,
            'photo' => $withPhotos ? $this->photo($citizen) : null,
        ];
    }

    /** "BULWANG, Mabinay, Negros Oriental" as on the template. */
    private function address(Citizen $citizen, array $names): string
    {
        $barangay = $names['barangays'][$citizen->add_brgy] ?? null;
        $city = $names['cities'][$citizen->add_city] ?? null;
        $province = $names['provinces'][$citizen->add_prov] ?? null;

        return implode(', ', array_filter([
            $barangay ? $this->upper($barangay) : null,
            $city ? $this->title($city) : null,
            $province ? $this->title($province) : null,
        ]));
    }

    /** Barangay, city and province names for every citizen in one query each. */
    private function addressNames(Collection $citizens): array
    {
        return [
            'barangays' => Barangay::whereIn('id', $citizens->pluck('add_brgy')->filter()->unique())->pluck('name', 'id')->all(),
            'cities' => City::whereIn('city_id', $citizens->pluck('add_city')->filter()->unique())->pluck('name', 'city_id')->all(),
            'provinces' => Province::whereIn('province_id', $citizens->pluck('add_prov')->filter()->unique())->pluck('name', 'province_id')->all(),
        ];
    }

    /**
     * The profile photo scaled to fit inside the photo box, centred, keeping its proportions.
     */
    private function photo(Citizen $citizen): ?array
    {
        $root = realpath(public_path());
        $file = $citizen->profile ? realpath(public_path(ltrim($citizen->profile, '/\\'))) : false;
        if (! $root || ! $file || ! str_starts_with($file, $root . DIRECTORY_SEPARATOR) || ! is_file($file)) {
            return null;
        }

        $size = @getimagesize($file);
        if (! $size || ! in_array($size[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF], true) || ! $size[0] || ! $size[1]) {
            return null;
        }

        $box = self::PHOTO_BOX;
        $scale = min($box['width'] / $size[0], $box['height'] / $size[1]);
        $width = $size[0] * $scale;
        $height = $size[1] * $scale;

        return [
            'file' => str_replace('\\', '/', $file),
            'x' => $box['x'] + ($box['width'] - $width) / 2,
            'y' => $box['y'] + ($box['height'] - $height) / 2,
            'width' => $width,
            'height' => $height,
        ];
    }

    private function fittedSize(string $text, float $size, float $maxWidth, FontMetrics $metrics, string $fontFile): float
    {
        if ($text === '') {
            return $size;
        }

        $width = $metrics->getTextWidth($text, $fontFile, $size);

        return $width > $maxWidth ? max(self::MIN_SIZE, floor($size * $maxWidth / $width * 100) / 100) : $size;
    }

    private function upper(string $value): string
    {
        return mb_strtoupper(trim(preg_replace('/\s+/', ' ', $value)));
    }

    private function title(string $value): string
    {
        return mb_convert_case(mb_strtolower(trim($value)), MB_CASE_TITLE);
    }
}
