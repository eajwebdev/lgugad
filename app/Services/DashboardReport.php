<?php

namespace App\Services;

use App\Models\Assistance;
use App\Models\Barangay;
use App\Models\Citizen;
use App\Models\Dafac;
use App\Models\MabinayBrgy;
use App\Models\Pwd;
use App\Models\SoloParent;
use App\Models\User;
use App\Models\Vawc;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardReport
{
    private const TABS = [
        'overview' => ['Overview', null], 'faced' => ['FACED', 'dafac'],
        'pwd' => ['PWD', 'pwd'], 'soloparents' => ['Solo parents', 'soloparent'],
        'seniors' => ['Senior citizens', 'senior'], 'vawc' => ['VAWC', 'vawc'],
        'users' => ['Users', 'admin'],
    ];

    public function tabsFor(User $user): array
    {
        return array_filter(self::TABS, fn ($item) => $item[1] === null || $user->canAccessModule($item[1]));
    }

    public function barangays(): Collection
    {
        return Barangay::whereHas('city', fn ($q) => $q->whereRaw('LOWER(cities.name) = ?', ['mabinay']))->orderBy('name')->get(['id', 'name']);
    }

    public function build(string $tab, User $user, ?int $barangayId, ?string $range): array
    {
        $barangay = $barangayId ? $this->barangays()->firstWhere('id', $barangayId) : null;
        abort_if($barangayId && ! $barangay, 422, 'Choose a Mabinay barangay.');
        [$start, $end] = $range ? explode(' - ', $range) : [null, null];
        try {
            $from = $start ? Carbon::createFromFormat('!Y-m-d', $start) : null;
            $to = $end ? Carbon::createFromFormat('!Y-m-d', $end)->endOfDay() : null;
        } catch (\Throwable) {
            abort(422, 'Choose a valid date range.');
        }
        abort_if($range && (! $from || ! $to), 422, 'Choose a valid date range.');

        $data = [];
        foreach (['faced', 'pwd', 'soloparents', 'seniors', 'vawc', 'users'] as $sector) {
            if ($tab !== 'overview' && $tab !== $sector) continue;
            if ($tab === 'overview' && $sector === 'users') continue;
            if (! isset($this->tabsFor($user)[$sector])) continue;
            $data[$sector] = $this->sector($sector, $barangay, $from, $to);
        }
        if ($tab !== 'overview') return $data[$tab];

        $rows = array_values($data);
        $trend = $this->combinedTrend($rows);
        $overviewCards = [[
            'key' => 'overview', 'label' => 'Total service records',
            'value' => array_sum(array_column($rows, 'total')),
            'icon' => 'fa-users', 'tone' => 'blue',
        ]];
        $sectorStyles = [
            'faced' => ['fa-house-user', 'rose'],
            'pwd' => ['fa-wheelchair', 'mint'],
            'soloparents' => ['fa-people-roof', 'violet'],
            'seniors' => ['fa-person-cane', 'amber'],
            'vawc' => ['fa-shield-heart', 'pink'],
        ];
        foreach ($sectorStyles as $key => [$icon, $tone]) {
            if (! isset($data[$key])) continue;
            $overviewCards[] = [
                'key' => $key, 'label' => $data[$key]['label'],
                'value' => $data[$key]['total'], 'icon' => $icon, 'tone' => $tone,
            ];
        }
        $recent = collect($data)->flatMap(fn ($sector) => $sector['recent'])
            ->sortByDesc('timestamp')->take(5)->values()->all();
        return [
            'title' => 'Community overview',
            'description' => 'Records by service area. A person may appear in more than one area.',
            'overviewCards' => $overviewCards,
            'recent' => $recent,
            'cards' => [
                $this->card('Sector records', array_sum(array_column($rows, 'total')), 'fa-layer-group'),
                $this->card('Female', array_sum(array_column($rows, 'female')), 'fa-venus'),
                $this->card('Male', array_sum(array_column($rows, 'male')), 'fa-mars'),
                $this->card('Sex not recorded', array_sum(array_column($rows, 'unknown')), 'fa-circle-question'),
            ],
            'charts' => [
                $this->chart('Records by service area', 'column', array_column($rows, 'label'), array_column($rows, 'total')),
                $this->chart('Registration trend · last 12 months', 'line', $trend[0], $trend[1]),
            ],
            'rows' => $rows,
            'note' => $barangay ? 'User accounts are excluded because they have no barangay.' : null,
        ];
    }

    private function sector(string $sector, $barangay, $from, $to): array
    {
        $base = match ($sector) {
            'faced' => Dafac::leftJoin('barangays', 'barangays.id', '=', 'dafacs.add_brgy')
                ->get(['dafacs.id', 'dafacs.gender', 'dafacs.created_at', 'dafacs.add_brgy as barangay_id', 'barangays.name as barangay']),
            'pwd' => Pwd::leftJoin('mabinay_brgys', 'mabinay_brgys.id', '=', 'pwds.brangay')
                ->get(['pwds.id', 'pwds.gender', 'pwds.date_app as event_date', 'pwds.created_at', 'pwds.brangay as barangay_id', 'mabinay_brgys.brgy_name as barangay', 'pwds.dob', 'pwds.type_dis']),
            'soloparents' => SoloParent::get(['id', 'gender', 'created_at', 'address as barangay', 'dob', 'monthly_income']),
            'seniors' => Citizen::leftJoin('citizen_i_s', 'citizen_i_s.cid', '=', 'citizens.id')
                ->leftJoin('barangays', 'barangays.id', '=', 'citizen_i_s.add_brgy')
                ->get(['citizens.id', 'citizen_i_s.gender', 'citizens.created_at', 'citizen_i_s.add_brgy as barangay_id', 'barangays.name as barangay', 'citizens.status', 'citizen_i_s.bday as dob']),
            'vawc' => Vawc::get(['id', 'gender', 'date_int as event_date', 'created_at', 'p_address as barangay', 'source', 'dob']),
            'users' => User::get(['id', 'gender', 'created_at', 'role']),
        };
        $pwdId = $sector === 'pwd' && $barangay
            ? MabinayBrgy::whereRaw('LOWER(brgy_name) = ?', [mb_strtolower($barangay->name)])->value('id') : null;
        $records = $base->filter(function ($row) use ($sector, $barangay, $pwdId, $from, $to) {
            if ($barangay) {
                if ($sector === 'pwd' && (int) $row->barangay_id !== (int) $pwdId) return false;
                if (in_array($sector, ['faced', 'seniors'], true) && (int) $row->barangay_id !== (int) $barangay->id) return false;
                if (in_array($sector, ['soloparents', 'vawc'], true)
                    && ! preg_match('/\b' . preg_quote($barangay->name, '/') . '\b/iu', (string) $row->barangay)) return false;
            }
            $date = $this->date($row->event_date ?? $row->created_at ?? null);
            if (($from || $to) && (! $date || $date < $from || $date > $to)) return false;
            return $sector !== 'seniors' || $row->status !== 'Deceased';
        })->values();

        $sex = $records->countBy(fn ($r) => $this->sex($r->gender));
        $trend = $this->trend($records);
        $groups = match ($sector) {
            'faced' => $this->counts($records->pluck('barangay'), 8),
            'pwd' => $this->codeCounts($records->pluck('type_dis'), Pwd::DISABILITY_TYPES),
            'soloparents' => $this->counts($records->map(fn ($r) => $this->incomeBand($r->monthly_income))),
            'seniors' => $this->counts($records->pluck('status')),
            'vawc' => $this->counts($records->pluck('source'), 8),
            'users' => $this->counts($records->pluck('role')),
        };
        $total = $records->count();
        $recent = $records->map(function ($row) use ($sector) {
            $date = $this->date($row->created_at ?? $row->event_date ?? null);
            return $date ? [
                'sector' => $sector,
                'label' => self::TABS[$sector][0] . ' record',
                'date' => $date->toDateString(),
                'timestamp' => $date->timestamp,
            ] : null;
        })->filter()->sortByDesc('timestamp')->take(3)->values()->all();
        $cards = [
            $this->card('Records', $total, 'fa-users'),
            $this->card('Female', $sex->get('female', 0), 'fa-venus'),
            $this->card('Male', $sex->get('male', 0), 'fa-mars'),
            $this->card('Sex not recorded', $sex->get('unknown', 0), 'fa-circle-question'),
        ];
        if ($sector === 'faced') {
            $familyIds = $base->filter(fn ($row) => ! $barangay || (int) $row->barangay_id === (int) $barangay->id)->pluck('id');
            $assistance = Assistance::whereIn('dafac_id', $familyIds)->get(['dafac_id', 'cost', 'created_at']);
            if ($from) $assistance = $assistance->filter(fn ($r) => ($d = $this->date($r->created_at)) && $d >= $from && $d <= $to);
            $cards[1] = $this->card('Assistance records', $assistance->count(), 'fa-hand-holding-heart');
            $cards[2] = $this->card('Families assisted', $assistance->pluck('dafac_id')->unique()->count(), 'fa-house');
            $cards[3] = $this->card('Assistance value', '₱' . number_format((float) $assistance->sum('cost'), 2), 'fa-peso-sign');
        }
        if ($sector === 'seniors') $cards[2] = $this->card('Age 80 and over', $records->filter(fn ($r) => ($a = $this->age($r->dob)) !== null && $a >= 80)->count(), 'fa-cake-candles');
        $groupTitle = ['faced' => 'Top barangays', 'pwd' => 'Disability types', 'soloparents' => 'Monthly income', 'seniors' => 'Registration status', 'vawc' => 'Referral sources', 'users' => 'Account roles'][$sector];
        $charts = [
            $this->chart('Records over time · last 12 months', 'line', $trend[0], $trend[1]),
            $this->chart($groupTitle, 'bar', array_column($groups, 0), array_column($groups, 1)),
        ];
        if (in_array($sector, ['pwd', 'soloparents', 'seniors', 'vawc'], true)) {
            $ages = $this->counts($records->map(fn ($r) => $this->ageBand($r->dob)));
            $charts[] = $this->chart('Age groups', 'doughnut', array_column($ages, 0), array_column($ages, 1));
        }
        $notes = ['faced' => 'Family heads use registration date; assistance uses its own record date.', 'pwd' => 'A PWD can have multiple disability types. Dates use application date.',
            'soloparents' => 'Barangay matching uses the free text address field.', 'seniors' => 'Living senior citizens only; ages use birth dates.',
            'vawc' => 'Barangay matching uses the free text address field. Dates use intake date.', 'users' => 'Accounts use creation date and have no barangay.'];
        return ['label' => self::TABS[$sector][0], 'title' => self::TABS[$sector][0] . ' analytics', 'description' => $notes[$sector],
            'total' => $total, 'female' => $sex->get('female', 0), 'male' => $sex->get('male', 0), 'unknown' => $sex->get('unknown', 0),
            'cards' => $cards, 'charts' => $charts, 'trend' => $trend, 'recent' => $recent, 'note' => $notes[$sector]];
    }

    private function card(string $label, $value, string $icon): array { return compact('label', 'value', 'icon'); }
    private function chart(string $title, string $type, array $labels, array $values): array { return compact('title', 'type', 'labels', 'values'); }
    private function sex($value): string { return match (strtoupper(substr(trim((string) $value), 0, 1))) {'F' => 'female', 'M' => 'male', default => 'unknown'}; }
    private function date($value): ?Carbon { try { return $value ? Carbon::parse($value) : null; } catch (\Throwable) { return null; } }
    private function age($value): ?int { $date = $this->date($value); return $date && $date <= today() ? $date->diffInYears(today()) : null; }
    private function ageBand($value): string { $age = $this->age($value); return $age === null ? 'Age unavailable' : ($age < 18 ? 'Under 18' : ($age < 60 ? '18–59' : ($age < 80 ? '60–79' : '80+'))); }
    private function incomeBand($value): string { $n = str_replace(',', '', (string) $value); if (! is_numeric($n)) return 'Not stated'; return (float) $n < 5000 ? 'Under ₱5,000' : ((float) $n < 10000 ? '₱5,000–9,999' : ((float) $n < 20000 ? '₱10,000–19,999' : '₱20,000+')); }
    private function counts(Collection $values, int $limit = 12): array { return $values->map(fn ($v) => trim((string) $v) ?: 'Not recorded')->countBy()->sortDesc()->take($limit)->map(fn ($n, $name) => [$name, $n])->values()->all(); }
    private function codeCounts(Collection $values, array $labels): array { $codes = $values->flatMap(fn ($v) => array_unique(array_filter(array_map('trim', explode(',', (string) $v))))); return $this->counts($codes->map(fn ($c) => $labels[$c] ?? 'Other / invalid code')); }
    private function trend(Collection $records): array { $months = []; for ($i = 11; $i >= 0; $i--) { $d = today()->startOfMonth()->subMonths($i); $months[$d->format('Y-m')] = 0; } foreach ($records as $row) { $key = $this->date($row->event_date ?? $row->created_at ?? null)?->format('Y-m'); if (isset($months[$key])) $months[$key]++; } return [array_map(fn ($k) => Carbon::parse($k . '-01')->format('M Y'), array_keys($months)), array_values($months)]; }
    private function combinedTrend(array $rows): array { $labels = $rows[0]['trend'][0] ?? []; $values = array_fill(0, count($labels), 0); foreach ($rows as $row) foreach ($row['trend'][1] as $i => $n) $values[$i] += $n; return [$labels, $values]; }
}
