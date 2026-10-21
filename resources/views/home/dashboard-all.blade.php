@extends('layouts.master')

@section('body')
<div class="dash-shell {{ $tab === 'overview' ? 'dash-shell--overview' : 'dash-shell--sector' }}">
    @if ($tab === 'overview')
        <section class="dash-welcome" aria-labelledby="welcome-title">
            <div class="dash-welcome__content">
                <span class="dash-welcome__eyebrow">Welcome to the</span>
                <h1 id="welcome-title">Municipal Social Welfare and Development Office</h1>
                <p class="dash-welcome__system">GAD Management System, Mabinay</p>
                <p class="dash-welcome__copy">Supporting individuals, strengthening families, and building a more inclusive Mabinay.</p>
            </div>
            <img src="{{ asset('images/community-welcome.png') }}" alt="" width="2048" height="768">
        </section>
    @else
        <div class="dash-heading">
            <div>
                <span class="dash-eyebrow">{{ $tabs[$tab][0] }} dashboard</span>
                <h1>{{ $report['title'] }}</h1>
                <p>{{ $report['description'] }}</p>
            </div>
            <div class="dash-asof"><i class="far fa-clock" aria-hidden="true"></i> As of {{ now()->format('M j, Y') }}</div>
        </div>
    @endif

    <nav class="dash-tabs" aria-label="Dashboard views">
        <span class="dash-tabs__label">Dashboard views</span>
        @foreach ($tabs as $key => [$label])
            <a href="{{ route('dashboard', array_filter(['tab' => $key, 'barangay' => $filters['barangay'], 'range' => $filters['range']])) }}"
               @if ($tab === $key) aria-current="page" @endif>{{ $label }}</a>
        @endforeach
    </nav>

    @if ($tab === 'overview')
        <details class="dash-filter-disclosure" @if($filters['barangay'] || $filters['range']) open @endif>
            <summary><i class="fas fa-sliders" aria-hidden="true"></i> Filter overview <span>{{ $filters['barangay'] || $filters['range'] ? 'Filters applied' : 'All barangays · All dates' }}</span></summary>
    @endif
    <form class="dash-filters" method="get" action="{{ route('dashboard') }}" aria-label="Dashboard filters">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <div class="dash-filter">
            <label for="dashboard-barangay">Barangay</label>
            <select id="dashboard-barangay" name="barangay" class="form-control select2bs4" data-placeholder="All barangays" style="width:100%" @if($tab === 'users') disabled @endif>
                <option value="">All barangays</option>
                @foreach ($barangays as $barangay)
                    <option value="{{ $barangay->id }}" @selected((string) $filters['barangay'] === (string) $barangay->id)>{{ $barangay->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="dash-filter dash-filter--range">
            <label for="dashboard-range">Date range</label>
            <div class="dash-range-wrap">
                <i class="far fa-calendar" aria-hidden="true"></i>
                <input id="dashboard-range" name="range" type="text" class="form-control" value="{{ $filters['range'] }}" placeholder="All dates" autocomplete="off" readonly>
            </div>
        </div>
        <button type="submit" class="dash-apply"><i class="fas fa-filter" aria-hidden="true"></i> Apply filters</button>
        <a class="dash-reset" href="{{ route('dashboard', ['tab' => $tab]) }}">Reset</a>
    </form>

    <p class="dash-scope">
        <i class="fas fa-circle-info" aria-hidden="true"></i>
        {{ $filters['range'] ? 'Selected dates: ' . $filters['range'] : 'Showing all dates' }}
        @if ($filters['barangay'] && $tab !== 'users') · {{ $barangays->firstWhere('id', $filters['barangay'])?->name }} @else · All barangays @endif
        @if (!empty($report['note'])) · {{ $report['note'] }} @endif
    </p>
    @if ($tab === 'overview')
        </details>
    @endif

    @if ($tab === 'overview')
        <div class="dash-overview-cards" aria-label="Service area totals">
            @foreach ($report['overviewCards'] as $card)
                <a class="dash-overview-card dash-overview-card--{{ $card['tone'] }}" href="{{ route('dashboard', array_filter(['tab' => $card['key'], 'barangay' => $filters['barangay'], 'range' => $filters['range']])) }}">
                    <span class="dash-overview-card__icon"><i class="fas {{ $card['icon'] }}" aria-hidden="true"></i></span>
                    <span class="dash-overview-card__body"><span class="dash-overview-card__label">{{ $card['label'] }}</span><strong>{{ number_format($card['value']) }}</strong><span class="dash-overview-card__hint">{{ $card['key'] === 'overview' ? 'Across service areas' : 'View dashboard' }}</span></span>
                </a>
            @endforeach
        </div>

        @php
            $quickActions = [
                ['faced', 'dafacForm', 'New FACED record', 'fa-house-user', 'rose'],
                ['pwd', 'pwdForm', 'New PWD record', 'fa-wheelchair', 'mint'],
                ['soloparents', 'soloparentForm', 'New solo parent record', 'fa-people-roof', 'violet'],
                ['vawc', 'vawcForm', 'New VAWC record', 'fa-shield-heart', 'pink'],
                ['seniors', 'citizenRead', 'Senior citizen records', 'fa-person-cane', 'amber'],
                ['seniors', 'reportsRead', 'View reports', 'fa-chart-column', 'blue'],
            ];
        @endphp
        <div class="dash-overview-grid">
            <section class="dash-panel dash-quick" aria-labelledby="quick-title">
                <div class="dash-panel__heading"><h2 id="quick-title"><i class="fas fa-bolt" aria-hidden="true"></i> Quick actions</h2></div>
                <div class="dash-quick__grid">
                    @foreach ($quickActions as [$module, $routeName, $label, $icon, $tone])
                        @if (isset($tabs[$module]))
                            <a class="dash-quick__item dash-quick__item--{{ $tone }}" href="{{ route($routeName) }}">
                                <span><i class="fas {{ $icon }}" aria-hidden="true"></i></span>
                                <strong>{{ $label }}</strong>
                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>

            <section class="dash-panel dash-overview-chart" aria-labelledby="overview-chart-title">
                <div class="dash-panel__heading"><h2 id="overview-chart-title"><i class="fas fa-chart-column" aria-hidden="true"></i> Records by service area</h2></div>
                @if (array_sum($report['charts'][0]['values']) > 0)
                    <div class="dash-chart"><canvas id="dash-chart-0" role="img" aria-label="Records by service area"></canvas></div>
                @else
                    <div class="dash-empty"><i class="fas fa-chart-simple" aria-hidden="true"></i><p>No service records for these filters.</p></div>
                @endif
            </section>

            <section class="dash-panel dash-activity" aria-labelledby="activity-title">
                <div class="dash-panel__heading"><h2 id="activity-title"><i class="far fa-clock" aria-hidden="true"></i> Recent records</h2></div>
                @if (count($report['recent']))
                    <ul class="dash-activity__list">
                        @foreach ($report['recent'] as $item)
                            <li>
                                <span class="dash-activity__marker" aria-hidden="true"></span>
                                <span><strong>{{ $item['label'] }}</strong><time datetime="{{ $item['date'] }}">{{ \Carbon\Carbon::parse($item['date'])->format('M j, Y') }}</time></span>
                                <a href="{{ route('dashboard', array_filter(['tab' => $item['sector'], 'barangay' => $filters['barangay'], 'range' => $filters['range']])) }}" aria-label="View {{ $item['label'] }} dashboard"><i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="dash-empty dash-empty--activity"><i class="fas fa-clock-rotate-left" aria-hidden="true"></i><p>No recent records for these filters.</p></div>
                @endif
            </section>
        </div>

        <div class="dash-overview-secondary">
            <section class="dash-panel" aria-labelledby="trend-title">
                <div class="dash-panel__heading"><h2 id="trend-title">Registration trend</h2><span class="dash-panel__badge">Last 12 months</span></div>
                @if (array_sum($report['charts'][1]['values']) > 0)
                    <div class="dash-chart"><canvas id="dash-chart-1" role="img" aria-label="Registration trend over the last 12 months"></canvas></div>
                @else
                    <div class="dash-empty"><i class="fas fa-chart-line" aria-hidden="true"></i><p>No registrations for these filters.</p></div>
                @endif
            </section>
            <section class="dash-panel dash-table-panel">
                <div class="dash-panel__heading"><h2>Service area detail</h2></div>
                <div class="table-responsive">
                    <table class="table dash-table">
                        <thead><tr><th scope="col">Service area</th><th scope="col">Records</th><th scope="col">Female</th><th scope="col">Male</th><th scope="col">Not recorded</th></tr></thead>
                        <tbody>
                            @forelse ($report['rows'] as $row)
                                <tr><th scope="row">{{ $row['label'] }}</th><td>{{ number_format($row['total']) }}</td><td>{{ number_format($row['female']) }}</td><td>{{ number_format($row['male']) }}</td><td>{{ number_format($row['unknown']) }}</td></tr>
                            @empty
                                <tr><td colspan="5">No service areas are available to this account.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    @else
        <div class="dash-cards">
            @foreach ($report['cards'] as $card)
                <article class="dash-card">
                    <span class="dash-card__icon"><i class="fas {{ $card['icon'] }}" aria-hidden="true"></i></span>
                    <span class="dash-card__label">{{ $card['label'] }}</span>
                    <strong>{{ is_numeric($card['value']) ? number_format($card['value']) : $card['value'] }}</strong>
                </article>
            @endforeach
        </div>

        <div class="dash-grid">
            @foreach ($report['charts'] as $index => $chart)
                <section class="dash-panel @if($chart['type'] === 'doughnut') dash-panel--small @endif">
                    <div class="dash-panel__heading">
                        <div><span class="dash-panel__kicker">ANALYTICS</span><h2>{{ $chart['title'] }}</h2></div>
                        <span class="dash-panel__badge">{{ $chart['type'] === 'line' ? 'Trend' : 'Distribution' }}</span>
                    </div>
                    @if (array_sum($chart['values']) > 0)
                        <div class="dash-chart"><canvas id="dash-chart-{{ $index }}" role="img" aria-label="{{ $chart['title'] }}"></canvas></div>
                    @else
                        <div class="dash-empty"><i class="fas fa-chart-simple" aria-hidden="true"></i><p>No records for these filters.</p></div>
                    @endif
                </section>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(function () {
    const input = $('#dashboard-range');
    const options = {
        autoUpdateInput: false,
        opens: 'left',
        locale: { format: 'YYYY-MM-DD', cancelLabel: 'Clear' },
        ranges: {
            'Last 30 days': [moment().subtract(29, 'days'), moment()],
            'Last 90 days': [moment().subtract(89, 'days'), moment()],
            'This year': [moment().startOf('year'), moment()]
        }
    };
    @if ($filters['range'])
        options.startDate = moment('{{ substr($filters['range'], 0, 10) }}');
        options.endDate = moment('{{ substr($filters['range'], -10) }}');
    @endif
    input.daterangepicker(options);
    input.on('apply.daterangepicker', function (event, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    }).on('cancel.daterangepicker', function () { $(this).val(''); });

    const charts = @json($report['charts']);
    const ink = getComputedStyle(document.body).getPropertyValue('--gad-ink').trim();
    const rule = getComputedStyle(document.body).getPropertyValue('--gad-rule').trim();
    const colors = ['#bf4d65', '#0c8468', '#7754bb', '#d49431', '#b53960', '#4c89c5', '#7eaa67', '#bd81a4'];
    charts.forEach((chart, index) => {
        const canvas = document.getElementById('dash-chart-' + index);
        if (!canvas) return;
        const horizontal = chart.type === 'bar';
        new Chart(canvas, {
            type: horizontal ? 'horizontalBar' : (chart.type === 'column' ? 'bar' : chart.type),
            data: { labels: chart.labels, datasets: [{ data: chart.values,
                backgroundColor: chart.type === 'line' ? 'rgba(36,99,166,.13)' : colors,
                borderColor: chart.type === 'line' ? '#2463a6' : colors,
                borderWidth: chart.type === 'line' ? 3 : 0,
                pointRadius: 3, lineTension: .25, fill: chart.type === 'line' }] },
            options: { responsive: true, maintainAspectRatio: false,
                legend: { display: chart.type === 'doughnut', position: 'bottom', labels: { fontColor: ink, boxWidth: 12 } },
                tooltips: { callbacks: { label: function (item, data) { const value = chart.type === 'doughnut' ? data.datasets[0].data[item.index] : item.value; return chart.labels[item.index] + ': ' + Number(value).toLocaleString(); } } },
                scales: chart.type === 'doughnut' ? {} : { xAxes: [{ ticks: { beginAtZero: horizontal, precision: 0, fontColor: ink }, gridLines: { color: rule } }], yAxes: [{ ticks: { beginAtZero: !horizontal, precision: 0, fontColor: ink }, gridLines: { color: rule } }] } }
        });
    });
});
</script>
@endpush
