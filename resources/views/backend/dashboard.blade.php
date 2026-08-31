@extends('layouts.backend')
@section('title', 'Dashboard')
@section('customStyles')
<style>
    .stat-card {
        border-radius: 14px;
        padding: 20px 22px;
        color: #fff;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        position: relative;
        overflow: hidden;
        min-height: 130px;
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255,255,255,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-card .stat-label {
        font-size: 13px;
        opacity: .85;
        margin-bottom: 2px;
    }
    .stat-card .stat-value {
        font-size: 30px;
        font-weight: 700;
        line-height: 1.2;
    }
    .stat-card .stat-change {
        font-size: 12px;
        margin-top: 8px;
        opacity: .95;
    }
    .stat-change.up { color: #baffc9; }
    .stat-change.down { color: #ffc9c9; }
    .stat-change.flat { color: rgba(255,255,255,.75); }
    .stat-card.card-listings { background: linear-gradient(135deg, #2563eb, #1d4ed8) !important; }
    .stat-card.card-pending { background: linear-gradient(135deg, #16a34a, #15803d) !important; }
    .stat-card.card-sellers { background: linear-gradient(135deg, #7c3aed, #6d28d9) !important; }
    .stat-card.card-new-sellers { background: linear-gradient(135deg, #f59e0b, #d97706) !important; }

    .chart-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
    .chart-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 16px;
    }
    .chart-panel-title .icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(37,99,235,.12);
        color: #2563eb;
    }
    .chart-panel-title.purple .icon-badge {
        background: rgba(124,58,237,.12);
        color: #7c3aed;
    }
    .period-toggle .btn {
        padding: 4px 14px;
        font-size: 13px;
    }
    .chart-canvas-wrap {
        position: relative;
        height: 280px;
        margin-top: 15px;
    }
    .chart-loading {
        position: absolute;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.6);
        border-radius: 8px;
        z-index: 2;
    }
    .chart-loading.show { display: flex; }
    html.dark .chart-loading {
        background: rgba(20,22,26,.55);
    }

    /* Dark mode: OneUI toggles a `dark` class on <html>. The gradient stat
       cards are already high-contrast in both themes, but the icon badges
       and chart panels need brighter tints so they don't wash out against
       a dark background. The chart axis/grid colors are handled in JS
       below, since Chart.js needs those set at render time. */
    html.dark .stat-card {
        box-shadow: 0 4px 14px rgba(0,0,0,.35);
    }
    html.dark .chart-panel-title .icon-badge {
        background: rgba(96,165,250,.2);
        color: #93c5fd;
    }
    html.dark .chart-panel-title.purple .icon-badge {
        background: rgba(167,139,250,.2);
        color: #c4b5fd;
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
        <div class="flex-grow-1 mb-1 mb-md-0">
            <h1 class="h3 fw-bold mb-2">
              Dashboard
            </h1>
            <h2 class="h6 fw-medium fw-medium text-muted mb-0">
              Welcome <a class="fw-semibold" href="#">{{auth()->user()->name}}</a>,
            </h2>
          </div>
    </div>
</div>
<div class="content">
    {{-- Stat cards --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 items-push">
        @php
            $cards = [
                [
                    'class' => 'card-listings',
                    'icon' => 'fa-bag-shopping',
                    'label' => 'Total Ads',
                    'stat' => $stats['total_ads'],
                    'href' => route('advertises.index'),
                ],
                [
                    'class' => 'card-pending',
                    'icon' => 'fa-clock',
                    'label' => 'Pending Ads',
                    'stat' => $stats['pending_ads'],
                    'href' => route('advertises.index', ['status' => 'pending']),
                ],
                [
                    'class' => 'card-sellers',
                    'icon' => 'fa-users',
                    'label' => 'Total Sellers',
                    'stat' => $stats['total_sellers'],
                    'href' => route('customers.index'),
                ],
                [
                    'class' => 'card-new-sellers',
                    'icon' => 'fa-user-plus',
                    'label' => 'New Sellers (This Week)',
                    'stat' => $stats['new_sellers'],
                    'href' => route('customers.index'),
                ],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="col">
                <a href="{{ $card['href'] }}" class="stat-card {{ $card['class'] }} d-block text-decoration-none h-100">
                    <div class="stat-icon"><i class="fa {{ $card['icon'] }}"></i></div>
                    <div>
                        <div class="stat-label">{{ $card['label'] }}</div>
                        <div class="stat-value">{{ number_format($card['stat']['value']) }}</div>
                        @php $change = $card['stat']['change']; @endphp
                        <div class="stat-change {{ $change === null ? 'up' : ($change > 0 ? 'up' : ($change < 0 ? 'down' : 'flat')) }}">
                            @if ($change === null)
                                <i class="fa fa-arrow-up"></i> New this week
                            @else
                                <i class="fa {{ $change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                {{ number_format(abs($change), 1) }}% vs last 7 days
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="row items-push">
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="chart-panel-header">
                        <div class="chart-panel-title">
                            <span class="icon-badge"><i class="fa fa-chart-line"></i></span>
                            Ads Posted
                        </div>
                        <div class="btn-group period-toggle" data-chart="listings">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-period="day">Day</button>
                            <button type="button" class="btn btn-sm btn-primary active" data-period="week">Week</button>
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-period="month">Month</button>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="listingsChart"></canvas>
                        <div class="chart-loading"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="chart-panel-header">
                        <div class="chart-panel-title purple">
                            <span class="icon-badge"><i class="fa fa-users"></i></span>
                            Sellers / Customers Registered
                        </div>
                        <div class="btn-group period-toggle" data-chart="customers">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-period="day">Day</button>
                            <button type="button" class="btn btn-sm btn-primary active" data-period="week">Week</button>
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-period="month">Month</button>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="customersChart"></canvas>
                        <div class="chart-loading"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('customScripts')
<script src="{{ asset('assets_backend') }}/js/plugins/chart.js/chart.umd.js"></script>
<script>
    (function () {
        var chartDataUrl = '{{ route('dashboard.chartData') }}';

        // OneUI toggles dark mode by adding/removing a `dark` class on
        // <html>, client-side, without a page reload. Chart.js's default
        // axis/grid/legend colors are dark gray, which disappears against
        // a dark background, so those colors have to be set explicitly
        // and re-applied whenever the theme is toggled.
        function isDarkMode() {
            return document.documentElement.classList.contains('dark');
        }

        function chartTheme() {
            return isDarkMode()
                ? { text: '#adb5bd', grid: 'rgba(255,255,255,.08)' }
                : { text: '#6c757d', grid: 'rgba(0,0,0,.06)' };
        }

        function makeChart(canvasId, color) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            var theme = chartTheme();
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        borderColor: color,
                        backgroundColor: color + '33',
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: color,
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: theme.text }, grid: { color: theme.grid } },
                        y: { beginAtZero: true, ticks: { color: theme.text, precision: 0 }, grid: { color: theme.grid } }
                    }
                }
            });
        }

        var charts = [];
        var listingsChart = makeChart('listingsChart', '#2563eb');
        var customersChart = makeChart('customersChart', '#7c3aed');
        charts.push(listingsChart, customersChart);

        function applyChartTheme() {
            var theme = chartTheme();
            charts.forEach(function (chart) {
                chart.options.scales.x.ticks.color = theme.text;
                chart.options.scales.x.grid.color = theme.grid;
                chart.options.scales.y.ticks.color = theme.text;
                chart.options.scales.y.grid.color = theme.grid;
                chart.update();
            });
        }

        // Re-theme instantly when the sidebar dark mode toggle is used.
        new MutationObserver(applyChartTheme).observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // `chartKey` is the DOM-facing name (used for data-chart/canvas id).
        // `apiType` is what the chart-data endpoint actually expects
        // (type=ads|customers). Kept separate so the visible markup never
        // needs a class/id containing "ads" - some ad-blocker cosmetic
        // filters hide elements based on that pattern alone, which is why
        // the first stat card and this chart were invisible before.
        var chartMeta = {
            listings: { chart: listingsChart, apiType: 'ads', canvasId: 'listingsChart' },
            customers: { chart: customersChart, apiType: 'customers', canvasId: 'customersChart' }
        };

        function loadingEl(canvasId) {
            return $('#' + canvasId).siblings('.chart-loading');
        }

        function loadChart(chartKey, period) {
            var meta = chartMeta[chartKey];
            var $loading = loadingEl(meta.canvasId);

            $loading.addClass('show');
            $.ajax({
                url: chartDataUrl,
                type: 'GET',
                data: { type: meta.apiType, period: period },
                success: function (res) {
                    meta.chart.data.labels = res.labels;
                    meta.chart.data.datasets[0].data = res.data;
                    meta.chart.update();
                },
                complete: function () {
                    $loading.removeClass('show');
                }
            });
        }

        $('.period-toggle').on('click', 'button', function () {
            var $group = $(this).closest('.period-toggle');
            var chartKey = $group.data('chart');
            var period = $(this).data('period');

            $group.find('button').removeClass('btn-primary active').addClass('btn-alt-secondary');
            $(this).removeClass('btn-alt-secondary').addClass('btn-primary active');

            loadChart(chartKey, period);
        });

        loadChart('listings', 'week');
        loadChart('customers', 'week');
    })();
</script>
@endsection
