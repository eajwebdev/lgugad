@if(request()->routeIs('dashboardFaced') && isset($assistance) && $assistance->sum('count') > 0)
<script>
    $(function () {
        const rows = @json($assistance->map(fn ($row) => [
            'name' => trim(ucwords(strtolower($row->fname . ' ' . $row->surname))),
            'count' => (int) $row->count,
        ])->values());

        new Chart(document.getElementById('barChart'), {
            type: 'horizontalBar',
            data: {
                labels: rows.map(r => r.name),
                datasets: [{
                    data: rows.map(r => r.count),
                    backgroundColor: '#1D2F8F',
                    hoverBackgroundColor: '#15226B',
                    barThickness: 18,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                tooltips: {
                    callbacks: {
                        label: item => item.xLabel + (item.xLabel === 1 ? ' assistance record' : ' assistance records'),
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: { beginAtZero: true, precision: 0, fontColor: '#5B6478', fontFamily: 'Atkinson Hyperlegible' },
                        gridLines: { color: '#E3E7F0', zeroLineColor: '#B9C0D2' },
                    }],
                    yAxes: [{
                        ticks: { fontColor: '#1B2233', fontFamily: 'Atkinson Hyperlegible' },
                        gridLines: { display: false },
                    }],
                },
            }
        });
    });
</script>
@endif
