<?php

namespace App\Services;

use App\Models\Assistance;
use App\Models\Citizen;
use App\Models\Dafac;
use App\Models\Pwd;
use App\Models\SoloParent;
use App\Models\User;
use App\Models\Vawc;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Figures for the dashboard tabs.
 *
 * Reliability rules applied everywhere:
 * - Sex is normalised from any spelling (F/M, Female/Male, any case); anything else counts as "not recorded".
 * - Ages are computed from birth dates on the day of viewing, never read from stored `age` columns.
 * - Deceased senior citizens are excluded from client counts.
 * - Counts are records per sector; one person can appear in more than one sector.
 *
 * Aggregation happens in PHP over plucked columns, so the same code runs on MySQL and SQLite.
 */
class DashboardAnalytics
{
    /** view => [tab label, module flag required (null = everyone)] */
    public const VIEWS = [
        'overview' => ['Overview', null],
        'seniors' => ['Senior citizens', 'senior'],
        'pwd' => ['PWD', 'pwd'],
        'soloparents' => ['Solo parents', 'soloparent'],
        'vawc' => ['VAWC', 'vawc'],
        'faced' => ['FACED', 'dafac'],
        'quality' => ['Data quality', null],
    ];

    /** Birthdays that qualify for the milestone cash gift under RA 11982 (Expanded Centenarians Act). */
    public const MILESTONE_AGES = [80, 85, 90, 95, 100];

    private const SENIOR_BRACKETS = ['60–69' => [60, 69], '70–79' => [70, 79], '80–89' => [80, 89], '90–99' => [90, 99], '100 and over' => [100, 200]];
    private const LIFE_STAGES = ['Children (0–17)' => [0, 17], 'Adults (18–59)' => [18, 59], 'Seniors (60+)' => [60, 200]];

    private CarbonInterface $today;

    public function __construct()
    {
        $this->today = Carbon::today();
    }

    public function tabsFor(User $user): array
    {
        return array_filter(self::VIEWS, fn ($tab) => $tab[1] === null || $user->canAccessModule($tab[1]));
    }

    public function forView(string $view, User $user): array
    {
        return match ($view) {
            'overview' => $this->overview(),
            'seniors' => $this->seniors(),
            'pwd' => $this->pwd(),
            'soloparents' => $this->soloParents(),
            'vawc' => $this->vawc(),
            'faced' => $this->faced(),
            'quality' => $this->quality($user),
        };
    }

    // ------------------------------------------------------------------ tabs

    public function overview(): array
    {
        $seniors = $this->seniorRows();
        $living = $seniors->where('status', '!=', 'Deceased');

        $sectors = [
            ['Senior citizens (living)', 'citizenRead', 'senior', $living->pluck('gender')],
            ['Persons with disability', 'pwdRead', 'pwd', Pwd::pluck('gender')],
            ['Solo parents', 'soloparentRead', 'soloparent', SoloParent::pluck('gender')],
            ['VAWC clients', 'vawcRead', 'vawc', Vawc::pluck('gender')],
            ['FACED family heads', 'dafacRead', 'dafac', Dafac::pluck('gender')],
        ];

        $rows = array_map(fn ($s) => ['label' => $s[0], 'route' => $s[1], 'module' => $s[2]] + $this->sexCounts($s[3]), $sectors);
        $totals = $this->sumRows($rows);

        $created = collect([Citizen::pluck('created_at'), Pwd::pluck('created_at'), SoloParent::pluck('created_at'), Vawc::pluck('created_at'), Dafac::pluck('created_at')])->flatten();
        $monthly = $this->monthly($created);
        $thisMonth = end($monthly)['value'];
        $lastMonth = $monthly[count($monthly) - 2]['value'];

        return [
            'stats' => [
                'total' => $totals['total'],
                'female' => $totals['F'],
                'femaleShare' => $this->share($totals['F'], $totals['F'] + $totals['M']),
                'newThisMonth' => $thisMonth,
                'newLastMonth' => $lastMonth,
                'livingSeniors' => $living->count(),
                'deceasedSeniors' => $seniors->count() - $living->count(),
            ],
            'sectors' => $rows,
            'totals' => $totals,
            'monthly' => $monthly,
        ];
    }

    public function seniors(): array
    {
        $rows = $this->seniorRows();
        $living = $rows->where('status', '!=', 'Deceased');
        $yearEnd = $this->today->copy()->endOfYear();

        $milestones = $living
            ->map(function ($r) use ($yearEnd) {
                $bday = $this->date($r->bday);
                $turning = $bday ? $bday->diffInYears($yearEnd) : null;

                return $turning !== null && in_array($turning, self::MILESTONE_AGES, true)
                    ? ['name' => trim("{$r->fname} {$r->lname}"), 'birthday' => $bday->copy()->year($this->today->year), 'turning' => $turning, 'barangay' => $r->barangay]
                    : null;
            })
            ->filter()
            ->sortBy('birthday')
            ->values();

        return [
            'stats' => [
                'registered' => $rows->count(),
                'active' => $rows->where('status', 'Active / Pensioner')->count(),
                'waiting' => $rows->where('status', 'Waiting')->count(),
                'deceased' => $rows->where('status', 'Deceased')->count(),
                'centenarians' => $living->filter(fn ($r) => ($this->age($r->bday) ?? 0) >= 100)->count(),
            ],
            'brackets' => $this->bracketsBySex($living, 'bday', self::SENIOR_BRACKETS),
            'milestones' => $milestones,
            'milestoneCounts' => collect(self::MILESTONE_AGES)->map(fn ($age) => [$age . ' years', $milestones->where('turning', $age)->count()])->all(),
            'barangays' => $this->topCounts($living->pluck('barangay'), 10),
        ];
    }

    public function pwd(): array
    {
        $rows = Pwd::leftJoin('mabinay_brgys', 'mabinay_brgys.id', '=', 'pwds.brangay')
            ->get(['pwds.gender', 'pwds.dob', 'pwds.date_app', 'pwds.type_dis', 'pwds.cause_dis', 'mabinay_brgys.brgy_name as barangay']);

        return [
            'stats' => $this->sexCounts($rows->pluck('gender')) + [
                'thisYear' => $rows->filter(fn ($r) => $this->date($r->date_app)?->year === $this->today->year)->count(),
            ],
            'types' => $this->codedCounts($rows->pluck('type_dis'), Pwd::DISABILITY_TYPES),
            'causes' => $this->codedCounts($rows->pluck('cause_dis'), Pwd::DISABILITY_CAUSES),
            'stages' => $this->bracketsBySex($rows, 'dob', self::LIFE_STAGES),
            'barangays' => $this->topCounts($rows->pluck('barangay'), 10),
        ];
    }

    public function soloParents(): array
    {
        $rows = SoloParent::get(['gender', 'dob', 'monthly_income', 'mem_fname']);

        $bands = ['Under ₱5,000' => [0, 4999.99], '₱5,000–9,999' => [5000, 9999.99], '₱10,000–19,999' => [10000, 19999.99], '₱20,000 and over' => [20000, PHP_INT_MAX]];
        $income = array_fill_keys(array_keys($bands), 0) + ['Not stated' => 0];
        foreach ($rows as $r) {
            $amount = is_numeric(str_replace(',', '', (string) $r->monthly_income)) ? (float) str_replace(',', '', $r->monthly_income) : null;
            $band = $amount === null ? 'Not stated' : collect($bands)->search(fn ($b) => $amount >= $b[0] && $amount <= $b[1]);
            $income[$band ?: 'Not stated']++;
        }

        $members = $rows->sum(fn ($r) => count(array_filter(explode(',', (string) $r->mem_fname), fn ($n) => trim($n) !== '')));

        return [
            'stats' => $this->sexCounts($rows->pluck('gender')) + [
                'members' => $members,
                'avgMembers' => $rows->count() ? round($members / $rows->count(), 1) : 0,
            ],
            'income' => $this->pairs($income),
            'stages' => $this->bracketsBySex($rows, 'dob', self::LIFE_STAGES),
        ];
    }

    public function vawc(): array
    {
        $rows = Vawc::get(['gender', 'dob', 'date_int', 'source']);

        return [
            'stats' => $this->sexCounts($rows->pluck('gender')) + [
                'thisYear' => $rows->filter(fn ($r) => $this->date($r->date_int)?->year === $this->today->year)->count(),
                'children' => $rows->filter(fn ($r) => ($a = $this->age($r->dob)) !== null && $a < 18)->count(),
            ],
            'monthly' => $this->monthly($rows->pluck('date_int')),
            'sources' => $this->topCounts($rows->pluck('source'), 8),
            'stages' => $this->bracketsBySex($rows, 'dob', self::LIFE_STAGES),
        ];
    }

    public function faced(): array
    {
        $families = Dafac::withAddressNames()->get(['dafacs.gender', 'dafacs.ps_benef', 'dafacs.ip', 'dafacs.brgy_evac_site']);
        $assistance = Assistance::get(['dafac_id', 'assistance', 'cost', 'created_at']);

        $top = Dafac::select('dafacs.id', 'dafacs.surname', 'dafacs.fname', DB::raw('COUNT(assistances.id) as records'), DB::raw('COALESCE(SUM(assistances.cost), 0) as value'))
            ->join('assistances', 'dafacs.id', '=', 'assistances.dafac_id')
            ->groupBy('dafacs.id', 'dafacs.surname', 'dafacs.fname')
            ->orderByDesc('value')
            ->take(10)
            ->get()
            ->map(fn ($f) => [trim(ucwords(strtolower("{$f->fname} {$f->surname}"))), (float) $f->value, (int) $f->records])
            ->all();

        return [
            'stats' => $this->sexCounts($families->pluck('gender')) + [
                'assistanceRecords' => $assistance->count(),
                'assistanceValue' => (float) $assistance->sum('cost'),
                'familiesAssisted' => $assistance->pluck('dafac_id')->unique()->count(),
                'fourPs' => $families->where('ps_benef', true)->count(),
                'indigenous' => $families->where('ip', true)->count(),
            ],
            'monthlyValue' => $this->monthly($assistance->pluck('created_at'), $assistance->pluck('cost')),
            'top' => $top,
            'types' => $this->topCounts($assistance->pluck('assistance')->map(fn ($a) => ucfirst(strtolower(trim((string) $a)))), 8),
            'barangays' => $this->topCounts($families->pluck('brgyname')->map(fn ($b) => $b ? ucwords(strtolower($b)) : null), 10),
            'sites' => $this->topCounts($families->pluck('brgy_evac_site')->map(fn ($s) => $s ? ucwords(strtolower(trim($s))) : null), 8),
        ];
    }

    /**
     * Missing or implausible values per sector, so staff know which counts to trust and what to fix.
     */
    public function quality(User $user): array
    {
        $sectors = [];

        if ($user->canAccessModule('senior')) {
            $sectors[] = $this->audit('Senior citizens', 'citizenRead', $this->seniorRows(), [
                'Sex not recorded' => fn ($r) => $this->sex($r->gender) === null,
                'No birth date' => fn ($r) => ! $this->date($r->bday),
                'Birth date makes them under 60 or in the future' => fn ($r) => $this->date($r->bday) && (($a = $this->age($r->bday)) === null || $a < 60),
                'No barangay' => fn ($r) => ! $r->barangay,
            ]);
        }
        if ($user->canAccessModule('pwd')) {
            $sectors[] = $this->audit('Persons with disability', 'pwdRead', Pwd::get(['gender', 'dob', 'brangay', 'type_dis']), [
                'Sex not recorded' => fn ($r) => $this->sex($r->gender) === null,
                'No birth date' => fn ($r) => ! $this->date($r->dob),
                'Birth date in the future' => fn ($r) => $this->date($r->dob) && $this->age($r->dob) === null,
                'No barangay' => fn ($r) => ! $r->brangay,
                'No disability type' => fn ($r) => trim(str_replace(',', '', (string) $r->type_dis)) === '',
            ]);
        }
        if ($user->canAccessModule('soloparent')) {
            $sectors[] = $this->audit('Solo parents', 'soloparentRead', SoloParent::get(['gender', 'dob', 'age', 'monthly_income']), [
                'Sex not recorded' => fn ($r) => $this->sex($r->gender) === null,
                'No birth date' => fn ($r) => ! $this->date($r->dob),
                'Saved age no longer matches birth date' => fn ($r) => ($a = $this->age($r->dob)) !== null && $r->age !== null && abs($a - (int) $r->age) > 1,
                'Monthly income not a number' => fn ($r) => ! is_numeric(str_replace(',', '', (string) $r->monthly_income)),
            ]);
        }
        if ($user->canAccessModule('vawc')) {
            $sectors[] = $this->audit('VAWC clients', 'vawcRead', Vawc::get(['gender', 'dob', 'date_int']), [
                'Sex not recorded' => fn ($r) => $this->sex($r->gender) === null,
                'No birth date' => fn ($r) => ! $this->date($r->dob),
                'No intake date' => fn ($r) => ! $this->date($r->date_int),
                'Intake date in the future' => fn ($r) => ($d = $this->date($r->date_int)) && $d->isAfter($this->today),
            ]);
        }
        if ($user->canAccessModule('dafac')) {
            $sectors[] = $this->audit('FACED family heads', 'dafacRead', Dafac::get(['gender', 'd_birth', 'add_brgy', 'mincome']), [
                'Sex not recorded' => fn ($r) => $this->sex($r->gender) === null,
                'No birth date' => fn ($r) => ! $this->date($r->d_birth),
                'No barangay' => fn ($r) => ! $r->add_brgy,
                'No monthly income' => fn ($r) => $r->mincome === null,
            ]);
        }

        $records = array_sum(array_column($sectors, 'total'));
        $clean = array_sum(array_column($sectors, 'clean'));

        return [
            'sectors' => $sectors,
            'stats' => [
                'records' => $records,
                'clean' => $clean,
                'completeness' => $this->share($clean, $records),
                'issues' => array_sum(array_map(fn ($s) => array_sum(array_column($s['checks'], 'count')), $sectors)),
            ],
        ];
    }

    // --------------------------------------------------------------- helpers

    public function sex($value): ?string
    {
        $letter = strtoupper(substr(trim((string) $value), 0, 1));

        return in_array($letter, ['F', 'M'], true) ? $letter : null;
    }

    private function seniorRows(): Collection
    {
        return Citizen::leftJoin('citizen_i_s', 'citizen_i_s.cid', '=', 'citizens.id')
            ->leftJoin('barangays', 'barangays.id', '=', 'citizen_i_s.add_brgy')
            ->get(['citizens.id', 'citizens.fname', 'citizens.lname', 'citizens.status', 'citizen_i_s.gender', 'citizen_i_s.bday', 'barangays.name as barangay']);
    }

    private function sexCounts(Collection $values): array
    {
        $counts = ['total' => $values->count(), 'F' => 0, 'M' => 0, 'unknown' => 0];
        foreach ($values as $value) {
            $counts[$this->sex($value) ?? 'unknown']++;
        }

        return $counts;
    }

    private function sumRows(array $rows): array
    {
        $sum = ['total' => 0, 'F' => 0, 'M' => 0, 'unknown' => 0];
        foreach ($rows as $row) {
            foreach ($sum as $key => $_) {
                $sum[$key] += $row[$key];
            }
        }

        return $sum;
    }

    private function date($value): ?CarbonInterface
    {
        if (! $value) {
            return null;
        }

        try {
            return Carbon::parse($value)->startOfDay();
        } catch (\Throwable) {
            return null;
        }
    }

    /** Age today, or null when the date is missing or in the future. */
    private function age($birthDate): ?int
    {
        $date = $this->date($birthDate);

        return $date && ! $date->isAfter($this->today) ? $date->diffInYears($this->today) : null;
    }

    /** [label, female, male] per bracket, by age computed from $dateField. */
    private function bracketsBySex(Collection $rows, string $dateField, array $brackets): array
    {
        $out = [];
        foreach ($brackets as $label => [$min, $max]) {
            $out[$label] = [$label, 0, 0];
        }
        foreach ($rows as $row) {
            $age = $this->age($row->{$dateField});
            $sex = $this->sex($row->gender);
            if ($age === null || $sex === null) {
                continue;
            }
            foreach ($brackets as $label => [$min, $max]) {
                if ($age >= $min && $age <= $max) {
                    $out[$label][$sex === 'F' ? 1 : 2]++;
                    break;
                }
            }
        }

        return array_values($out);
    }

    /**
     * Last $months calendar months ending this month. Sums $weights when given, otherwise counts.
     *
     * @return array<int, array{label: string, short: string, value: float|int}>
     */
    private function monthly(Collection $dates, ?Collection $weights = null, int $months = 12): array
    {
        $buckets = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = $this->today->copy()->startOfMonth()->subMonths($i);
            $buckets[$month->format('Y-m')] = ['label' => $month->format('F Y'), 'short' => $month->format('M'), 'value' => 0];
        }

        foreach ($dates->values() as $i => $value) {
            $key = $this->date($value)?->format('Y-m');
            if ($key && isset($buckets[$key])) {
                $buckets[$key]['value'] += $weights ? (float) $weights->values()[$i] : 1;
            }
        }

        return array_values($buckets);
    }

    /** Counts of each distinct non-empty value, largest first. */
    private function topCounts(Collection $values, int $limit): array
    {
        return $values
            ->map(fn ($v) => is_string($v) ? trim($v) : $v)
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->countBy()
            ->sortDesc()
            ->take($limit)
            ->map(fn ($count, $label) => [$label, $count])
            ->values()
            ->all();
    }

    /** Counts per code for CSV code columns (one record can carry several codes). */
    private function codedCounts(Collection $values, array $labels): array
    {
        $counts = array_fill_keys(array_keys($labels), 0);
        foreach ($values as $csv) {
            foreach (array_unique(array_filter(array_map('trim', explode(',', (string) $csv)))) as $code) {
                if (isset($counts[$code])) {
                    $counts[$code]++;
                }
            }
        }
        arsort($counts);

        return collect($counts)->map(fn ($count, $code) => [$labels[$code], $count])->values()->all();
    }

    private function audit(string $label, string $route, Collection $rows, array $checks): array
    {
        $flagged = [];
        $results = [];
        foreach ($checks as $name => $test) {
            $count = 0;
            foreach ($rows as $i => $row) {
                if ($test($row)) {
                    $count++;
                    $flagged[$i] = true;
                }
            }
            $results[] = ['label' => $name, 'count' => $count];
        }

        $clean = $rows->count() - count($flagged);

        return [
            'label' => $label,
            'route' => $route,
            'total' => $rows->count(),
            'clean' => $clean,
            'completeness' => $this->share($clean, $rows->count()),
            'checks' => $results,
        ];
    }

    private function pairs(array $map): array
    {
        return collect($map)->map(fn ($v, $k) => [$k, $v])->values()->all();
    }

    private function share(int|float $part, int|float $whole): ?int
    {
        return $whole > 0 ? (int) round($part / $whole * 100) : null;
    }
}
