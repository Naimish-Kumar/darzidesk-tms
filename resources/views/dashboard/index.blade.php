@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Dashboard') }}</li>
@endsection

@push('css-page')
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dd-teal: #D9A441;
            --dd-teal-light: #102B45;
            --dd-teal-dark: #F4C861;
            --dd-bg: #03111F;
            --dd-card: #0B2239;
            --dd-border: #29435D;
            --dd-text: #FFFFFF;
            --dd-text-muted: #8FA1B5;
            --dd-secondary-text: #D8E0E8;
        }

        .dd-dashboard {
            font-family: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--dd-text);
        }

        .dd-dashboard .dd-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Clean Modern Header Banner */
        .dd-welcome-banner {
            background: linear-gradient(135deg, #0B2239 0%, #102B45 100%);
            border: 1px solid var(--dd-border);
            border-left: 5px solid var(--dd-teal);
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
            margin-bottom: 24px;
        }
        .dd-welcome-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--dd-teal);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .dd-welcome-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--dd-text);
            margin-bottom: 0;
            letter-spacing: -0.3px;
        }
        .dd-welcome-subtitle {
            font-size: 13.5px;
            color: var(--dd-text-muted);
            margin-top: 4px;
            margin-bottom: 0;
        }
        .dd-welcome-avatar {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--dd-teal-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--dd-border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .dd-welcome-avatar i {
            font-size: 24px;
            color: var(--dd-teal);
        }

        /* Action Buttons */
        .dd-quick-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        .dd-btn-primary {
            background: linear-gradient(135deg, #D9A441 0%, #C38E45 100%);
            color: #03111F;
            border: none;
            border-radius: 10px;
            padding: 9px 20px;
            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(217, 164, 65, 0.3);
        }
        .dd-btn-primary:hover {
            background: linear-gradient(135deg, #F4C861 0%, #D9A441 100%);
            color: #03111F;
            text-decoration: none;
            box-shadow: 0 6px 18px rgba(244, 200, 97, 0.4);
        }
        .dd-btn-outline {
            background: #102B45;
            color: #D8E0E8;
            border: 1px solid var(--dd-border);
            border-radius: 10px;
            padding: 9px 20px;
            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }
        .dd-btn-outline:hover {
            background: #D9A441;
            color: #03111F;
            border-color: #D9A441;
            text-decoration: none;
        }

        /* Section Label */
        .dd-section-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--dd-text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        /* 5-Column Metrics Grid */
        .dd-metrics-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }
        @media (max-width: 1400px) {
            .dd-metrics-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 992px) {
            .dd-metrics-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .dd-metrics-grid { grid-template-columns: 1fr; }
        }

        /* Clean Stat Cards */
        .dd-stat-card {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
            transition: all 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 135px;
        }
        .dd-stat-card:hover {
            border-color: var(--dd-teal);
            box-shadow: 0 6px 20px rgba(217, 164, 65, 0.25);
        }

        .dd-stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--dd-teal-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--dd-border);
        }
        .dd-stat-icon i {
            font-size: 20px;
            color: var(--dd-teal);
        }
        .dd-stat-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--dd-text);
            line-height: 1.2;
            margin-bottom: 2px;
        }
        .dd-stat-label {
            font-size: 13px;
            color: var(--dd-text-muted);
            font-weight: 500;
            margin-bottom: 4px;
        }
        .dd-stat-subtext {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            font-weight: 600;
            color: var(--dd-teal);
        }

        /* Subscription Card */
        .dd-sub-card {
            background: linear-gradient(135deg, #0B2239 0%, #102B45 100%);
            border: 1px solid var(--dd-teal);
            border-radius: 14px;
            padding: 18px 20px;
            color: #FFFFFF;
            height: 100%;
            min-height: 135px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s ease;
        }
        .dd-sub-card:hover {
            border-color: var(--dd-teal-dark);
            box-shadow: 0 6px 20px rgba(217, 164, 65, 0.3);
        }
        .dd-sub-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--dd-teal);
        }
        .dd-sub-title {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
            margin: 4px 0;
        }
        .dd-btn-upgrade {
            background: rgba(217, 164, 65, 0.2);
            color: #D9A441;
            border: 1px solid rgba(217, 164, 65, 0.4);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }
        .dd-btn-upgrade:hover {
            background: #D9A441;
            color: #03111F;
            text-decoration: none;
        }

        /* Clean Chart Card */
        .dd-chart-card {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
            margin-bottom: 24px;
        }
        .dd-chart-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--dd-text);
            margin-bottom: 0;
        }
        .dd-chart-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            background: var(--dd-teal-light);
            color: var(--dd-teal);
            padding: 4px 10px;
            border-radius: 8px;
        }

        /* Table */
        .dd-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .dd-table thead th {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            color: #F4C861;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid var(--dd-border);
            padding: 12px 18px;
            background: #102B45;
        }
        .dd-table tbody td {
            font-size: 13.5px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--dd-border);
            vertical-align: middle;
            color: #D8E0E8;
        }
        .dd-table tbody tr:hover {
            background: var(--dd-teal-light);
        }
        .dd-table tbody tr:last-child td {
            border-bottom: none;
        }

        .dd-order-id {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            color: var(--dd-teal);
        }
        .dd-order-customer {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--dd-text);
        }
        .dd-order-meta {
            font-size: 12.5px;
            color: var(--dd-text-muted);
        }

        .dd-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .dd-badge-pending { background: rgba(217, 164, 65, 0.2); color: #F4C861; border: 1px solid #D9A441; }
        .dd-badge-in-progress { background: rgba(59, 130, 246, 0.2); color: #60A5FA; border: 1px solid #3B82F6; }
        .dd-badge-completed { background: rgba(34, 197, 94, 0.2); color: #4ADE80; border: 1px solid #22C55E; }
        .dd-badge-delivered { background: rgba(168, 85, 247, 0.2); color: #C084FC; border: 1px solid #A855F7; }

        .dd-view-btn {
            background: var(--dd-teal-light);
            color: var(--dd-teal);
            border: 1px solid var(--dd-border);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .dd-view-btn:hover {
            background: var(--dd-teal);
            color: #03111F;
            text-decoration: none;
        }

        .dd-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .dd-view-all {
            font-size: 13px;
            font-weight: 700;
            color: var(--dd-teal);
            text-decoration: none;
        }

        /* Dark Mode Overrides */
        [data-pc-theme="dark"] .dd-welcome-banner,
        [data-pc-theme="dark"] .dd-stat-card,
        [data-pc-theme="dark"] .dd-chart-card,
        [data-pc-theme="dark"] .dd-table thead th {
            background: #1A2332;
            border-color: rgba(255, 255, 255, 0.08);
            color: #E2E8F0;
        }
        [data-pc-theme="dark"] .dd-stat-value,
        [data-pc-theme="dark"] .dd-chart-title,
        [data-pc-theme="dark"] .dd-order-customer {
            color: #FFFFFF;
        }
    </style>
@endpush

@push('script-page')
    @if (\Auth::user()->type == 'owner')
        <script>
            var options = {
                chart: {
                    type: 'area',
                    height: 320,
                    fontFamily: 'Hanken Grotesk, sans-serif',
                    toolbar: { show: false }
                },
                responsive: [{
                    breakpoint: 576,
                    options: {
                        chart: { height: 240 },
                        legend: { position: 'bottom' }
                    }
                }],
                colors: ['#D9A441', '#8FA1B5'],
                dataLabels: { enabled: false },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    fontFamily: 'JetBrains Mono',
                    fontSize: '10px',
                    fontWeight: 700,
                    labels: { colors: '#8FA1B5' },
                    markers: { radius: 3 }
                },
                stroke: {
                    width: 2.5,
                    curve: 'smooth'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        type: 'vertical',
                        inverseColors: false,
                        opacityFrom: 0.35,
                        opacityTo: 0.02
                    }
                },
                grid: {
                    show: true,
                    borderColor: '#29435D',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } }
                },
                series: [{
                    name: "Income",
                    data: {!! json_encode($result['incomeExpenseByMonth']['income']) !!}
                }, {
                    name: "Expense",
                    data: {!! json_encode($result['incomeExpenseByMonth']['expense']) !!}
                }],
                xaxis: {
                    categories: {!! json_encode(@$result['incomeExpenseByMonth']['label']) !!},
                    tooltip: { enabled: false },
                    labels: {
                        style: {
                            fontFamily: 'JetBrains Mono',
                            fontSize: '10px',
                            fontWeight: 600,
                            colors: '#8FA1B5'
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontFamily: 'JetBrains Mono',
                            fontSize: '10px',
                            colors: '#8FA1B5'
                        }
                    }
                },
                tooltip: {
                    theme: 'dark',
                    style: { fontFamily: 'Hanken Grotesk', fontSize: '12px' }
                }
            };
            var chart = new ApexCharts(document.querySelector('#incomeExpenseByMonth'), options);
            chart.render();

            var rawCounts = {!! json_encode($result['orderStatusDistribution']['counts'] ?? []) !!};
            var rawLabels = {!! json_encode($result['orderStatusDistribution']['labels'] ?? []) !!};
            var totalOrders = rawCounts.reduce(function(a, b) { return a + Number(b); }, 0);

            var donutOptions;
            if (totalOrders > 0) {
                donutOptions = {
                    chart: {
                        type: 'donut',
                        height: 250,
                        fontFamily: 'Inter, sans-serif'
                    },
                    colors: ['#D9A441', '#F4C861', '#3B82F6', '#10B981', '#A855F7', '#EC4899', '#EF4444'],
                    series: rawCounts,
                    labels: rawLabels,
                    stroke: { width: 2, colors: ['#0B2239'] },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '74%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '12px',
                                        fontFamily: 'Inter, sans-serif',
                                        color: '#8FA1B5',
                                        offsetY: -4
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '22px',
                                        fontFamily: 'Inter, sans-serif',
                                        fontWeight: '800',
                                        color: '#FFFFFF',
                                        offsetY: 6
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total Orders',
                                        fontSize: '11px',
                                        fontFamily: 'Inter, sans-serif',
                                        color: '#8FA1B5',
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce(function(a, b) { return a + b; }, 0);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    legend: { show: false },
                    dataLabels: { enabled: false },
                    tooltip: {
                        theme: 'dark',
                        y: { formatter: function(val) { return val + ' Orders'; } }
                    }
                };
            } else {
                donutOptions = {
                    chart: {
                        type: 'donut',
                        height: 250,
                        fontFamily: 'Inter, sans-serif'
                    },
                    colors: ['#29435D'],
                    series: [1],
                    labels: ['No Orders Yet'],
                    stroke: { width: 2, colors: ['#0B2239'] },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '74%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '11px',
                                        fontFamily: 'Inter, sans-serif',
                                        color: '#8FA1B5',
                                        offsetY: -4
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '22px',
                                        fontFamily: 'Inter, sans-serif',
                                        fontWeight: '800',
                                        color: '#8FA1B5',
                                        offsetY: 6,
                                        formatter: function() { return '0'; }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total Orders',
                                        fontSize: '11px',
                                        fontFamily: 'Inter, sans-serif',
                                        color: '#8FA1B5',
                                        formatter: function() { return '0'; }
                                    }
                                }
                            }
                        }
                    },
                    legend: { show: false },
                    dataLabels: { enabled: false },
                    tooltip: { enabled: false }
                };
            }

            if (document.querySelector('#orderStatusDonut')) {
                var donutChart = new ApexCharts(document.querySelector('#orderStatusDonut'), donutOptions);
                donutChart.render();
            }
        </script>
    @elseif (\Auth::user()->type == 'employee')
        <script>
            var options = {
                chart: {
                    type: 'bar',
                    height: 320,
                    fontFamily: 'Hanken Grotesk, sans-serif',
                    toolbar: { show: false }
                },
                colors: ['#D9A441', '#8FA1B5'],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '45%',
                    }
                },
                dataLabels: { enabled: false },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    fontFamily: 'JetBrains Mono',
                    fontSize: '10px',
                    fontWeight: 700,
                    labels: { colors: '#8FA1B5' }
                },
                grid: {
                    show: true,
                    borderColor: '#29435D',
                    strokeDashArray: 4
                },
                series: [{
                    name: "Completed",
                    data: {!! json_encode($result['totalOrderStatus']['completed']) !!}
                }, {
                    name: "Pending",
                    data: {!! json_encode($result['totalOrderStatus']['pending']) !!}
                }],
                xaxis: {
                    categories: {!! json_encode(@$result['totalOrderStatus']['label']) !!},
                    labels: {
                        style: { fontFamily: 'JetBrains Mono', fontSize: '10px', colors: '#8FA1B5' }
                    }
                },
                yaxis: {
                    labels: {
                        style: { fontFamily: 'JetBrains Mono', fontSize: '10px', colors: '#8FA1B5' }
                    }
                },
                tooltip: { theme: 'dark' }
            };
            var chart = new ApexCharts(document.querySelector('#totalOrderStatus'), options);
            chart.render();
        </script>
    @endif
@endpush

@section('content')
    <div class="dd-dashboard">
        @if (\Auth::user()->type == 'owner')
            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- OWNER DASHBOARD --}}
            {{-- ═══════════════════════════════════════════════════════ --}}

            {{-- Welcome Banner --}}
            <div class="dd-welcome-banner">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1">
                        <div class="dd-welcome-label">{{ __('OVERVIEW DASHBOARD') }}</div>
                        <h3 class="dd-welcome-title">
                            @php
                                $hour = now()->format('H');
                                if ($hour >= 5 && $hour < 12) {
                                    $greeting = __('Good morning') . ' 👋';
                                } elseif ($hour >= 12 && $hour < 17) {
                                    $greeting = __('Good afternoon') . ' 👋';
                                } elseif ($hour >= 17 && $hour < 21) {
                                    $greeting = __('Good evening') . ' 👋';
                                } else {
                                    $greeting = __('Good night') . ' 👋';
                                }
                            @endphp
                            {{ $greeting }}, {{ Auth::user()->name }}!
                        </h3>
                        <p class="dd-welcome-subtitle">{{ __('Here\'s your tailoring business overview for today') }}</p>
                    </div>
                    <div class="dd-welcome-avatar d-none d-sm-flex">
                        <i class="ti ti-building-store"></i>
                    </div>
                </div>
                <div class="dd-quick-actions">
                    <a href="{{ route('orders.create.step1') }}" class="dd-btn-primary">
                        <i class="ti ti-plus"></i> {{ __('New Custom Order') }}
                    </a>
                    <a href="{{ route('pos.index') }}" class="dd-btn-outline">
                        <i class="ti ti-calculator"></i> {{ __('POS Billing') }}
                    </a>
                    <a href="{{ route('production.index') }}" class="dd-btn-outline">
                        <i class="ti ti-timeline"></i> {{ __('Production Pipeline') }}
                    </a>
                    <a href="{{ route('customer.index') }}" class="dd-btn-outline">
                        <i class="ti ti-users"></i> {{ __('Clients Directory') }}
                    </a>
                </div>
            </div>

            {{-- Stats Section Label --}}
            <div class="dd-section-label">{{ __('BUSINESS METRICS') }}</div>

            {{-- Clean 5-Column Metrics Grid --}}
            <div class="dd-metrics-grid">
                {{-- Subscription Plan Card --}}
                <div class="dd-sub-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="dd-sub-label">
                            <i class="ti ti-crown me-1"></i> {{ __('Subscription Plan') }}
                        </div>
                        <span class="dd-live-dot" style="background: #4CAF50;"></span>
                    </div>
                    <div>
                        <div class="dd-sub-title">
                            {{ !empty($result['subscription']) ? $result['subscription']->title : __('No Plan') }}
                        </div>
                        <a href="{{ route('subscriptions.index') }}" class="dd-btn-upgrade">
                            <i class="ti ti-arrow-up-right" style="font-size: 11px;"></i> {{ __('Upgrade') }}
                        </a>
                    </div>
                </div>

                {{-- Total Customer --}}
                <a href="{{ route('customer.index') }}" class="text-decoration-none">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-users"></i>
                            </div>
                            <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ $result['totalCustomer'] }}</div>
                            <div class="dd-stat-label">{{ __('Total Clients') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-trending-up" style="font-size: 11px;"></i> {{ __('Active clients') }}
                            </div>
                        </div>
                    </div>
                </a>

                {{-- Total Cloth Type --}}
                <a href="{{ route('cloth-type.index') }}" class="text-decoration-none">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-hanger"></i>
                            </div>
                            <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ $result['totalClothType'] }}</div>
                            <div class="dd-stat-label">{{ __('Cloth Types') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-category" style="font-size: 11px;"></i> {{ __('Categories') }}
                            </div>
                        </div>
                    </div>
                </a>

                {{-- Total Income --}}
                <a href="{{ route('income.data') }}" class="text-decoration-none">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-wallet"></i>
                            </div>
                            <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ getSettingsValByName('CURRENCY_SYMBOL') . number_format($result['totalIncome'], 2) }}</div>
                            <div class="dd-stat-label">{{ __('Total Income') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-trending-up" style="font-size: 11px;"></i> {{ __('Revenue earned') }}
                            </div>
                        </div>
                    </div>
                </a>

                {{-- Total Expense --}}
                <a href="{{ route('expense.data') }}" class="text-decoration-none">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-credit-card"></i>
                            </div>
                            <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ getSettingsValByName('CURRENCY_SYMBOL') . number_format($result['totalExpense'], 2) }}</div>
                            <div class="dd-stat-label">{{ __('Total Expense') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-arrow-down-right" style="font-size: 11px;"></i> {{ __('Costs incurred') }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Analytics Charts Section --}}
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="dd-chart-card h-100 mb-0">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="dd-chart-title">{{ __('Income vs Expense') }}</h5>
                                <p class="dd-stat-label mb-0 mt-1">{{ __('Monthly overview of your financial performance') }}</p>
                            </div>
                            <span class="dd-chart-badge">
                                <span class="dd-live-dot me-1"></span> {{ __('This Year') }}
                            </span>
                        </div>
                        <div id="incomeExpenseByMonth"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="dd-chart-card h-100 mb-0">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <h5 class="dd-chart-title">{{ __('Order Status Breakdown') }}</h5>
                                <p class="dd-stat-label mb-0 mt-1">{{ __('Real-time status distribution') }}</p>
                            </div>
                        </div>
                        <div id="orderStatusDonut" style="min-height: 240px;"></div>

                        {{-- Breakdown Status Grid --}}
                        <div class="dd-status-breakdown-grid mt-2 pt-2 border-top">
                            @php
                                $statusColors = [
                                    'pending' => ['bg' => 'rgba(244, 200, 97, 0.15)', 'text' => '#F4C861', 'dot' => '#F4C861'],
                                    'in_progress' => ['bg' => 'rgba(59, 130, 246, 0.15)', 'text' => '#60A5FA', 'dot' => '#3B82F6'],
                                    'completed' => ['bg' => 'rgba(34, 197, 94, 0.15)', 'text' => '#4ADE80', 'dot' => '#22C55E'],
                                    'ready_for_delivery' => ['bg' => 'rgba(6, 182, 212, 0.15)', 'text' => '#22D3EE', 'dot' => '#06B6D4'],
                                    'delivered' => ['bg' => 'rgba(217, 164, 65, 0.15)', 'text' => '#D9A441', 'dot' => '#D9A441'],
                                    'on_hold' => ['bg' => 'rgba(168, 85, 247, 0.15)', 'text' => '#C084FC', 'dot' => '#A855F7'],
                                    'cancelled' => ['bg' => 'rgba(239, 68, 68, 0.15)', 'text' => '#F87171', 'dot' => '#EF4444'],
                                ];
                                $labels = $result['orderStatusDistribution']['labels'] ?? [];
                                $counts = $result['orderStatusDistribution']['counts'] ?? [];
                                $statusKeys = array_keys(\App\Models\Order::$status);
                            @endphp

                            <div class="row g-2">
                                @foreach ($statusKeys as $idx => $sKey)
                                    @php
                                        $sLabel = $labels[$idx] ?? ucwords(str_replace('_', ' ', $sKey));
                                        $sCount = $counts[$idx] ?? 0;
                                        $sStyle = $statusColors[$sKey] ?? ['bg' => '#F8FAFC', 'text' => '#475569', 'dot' => '#94A3B8'];
                                    @endphp
                                    <div class="col-6">
                                        <div class="d-flex align-items-center justify-content-between p-2 rounded-3" style="background: {{ $sStyle['bg'] }}; border: 1px solid rgba(0,0,0,0.03);">
                                            <div class="d-flex align-items-center gap-2 overflow-hidden me-1">
                                                <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $sStyle['dot'] }}; display: inline-block; flex-shrink: 0;"></span>
                                                <span class="text-truncate" style="font-size: 11px; font-weight: 600; color: {{ $sStyle['text'] }};">{{ $sLabel }}</span>
                                            </div>
                                            <span class="badge rounded-pill fw-bold flex-shrink-0" style="background: rgba(0,0,0,0.06); color: {{ $sStyle['text'] }}; font-size: 11px;">{{ $sCount }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Orders Table Section for Owner --}}
            @if (isset($result['recentOrders']) && count($result['recentOrders']) > 0)
                <div class="dd-section-header">
                    <span class="dd-section-label mb-0">{{ __('RECENT ORDERS') }}</span>
                    <a href="{{ route('order.index') }}" class="dd-view-all">
                        {{ __('View All') }} <i class="ti ti-arrow-right" style="font-size: 14px;"></i>
                    </a>
                </div>

                <div class="dd-chart-card mb-4" style="padding: 0; overflow: hidden;">
                    <div class="table-responsive">
                        <table class="table dd-table mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('Order ID') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th class="d-none d-md-table-cell">{{ __('Order Date') }}</th>
                                    <th>{{ __('Deadline') }}</th>
                                    <th class="d-none d-lg-table-cell">{{ __('Cloth Type') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result['recentOrders'] as $order)
                                    <tr>
                                        <td>
                                            <span class="dd-order-id">{{ orderPrefix() . $order->order_id }}</span>
                                        </td>
                                        <td>
                                            <span class="dd-order-customer">{{ !empty($order->customers) ? $order->customers->name : '-' }}</span>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="dd-order-meta">{{ dateFormat($order->order_date) }}</span>
                                        </td>
                                        <td>
                                            <span class="dd-order-meta">{{ dateFormat($order->deadline_date) }}</span>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <span class="dd-order-meta">{{ !empty($order->clothTypes) ? $order->clothTypes->title : '-' }}</span>
                                        </td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="dd-badge dd-badge-pending">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                            @elseif($order->status == 'in_progress')
                                                <span class="dd-badge dd-badge-in-progress">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                            @elseif($order->status == 'completed')
                                                <span class="dd-badge dd-badge-completed">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                            @elseif($order->status == 'delivered')
                                                <span class="dd-badge dd-badge-delivered">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                            @else
                                                <span class="dd-badge dd-badge-in-progress">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @can('show order')
                                                <a class="dd-view-btn"
                                                    href="{{ route('order.show', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}">
                                                    <i class="ti ti-eye" style="font-size: 14px;"></i> {{ __('View') }}
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        @elseif (\Auth::user()->type == 'employee')
            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- EMPLOYEE DASHBOARD --}}
            {{-- ═══════════════════════════════════════════════════════ --}}

            {{-- Welcome Banner --}}
            <div class="dd-welcome-banner">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1">
                        <div class="dd-welcome-label">{{ __('STAFF DASHBOARD') }}</div>
                        <h3 class="dd-welcome-title">
                            @php
                                $hour = now()->format('H');
                                if ($hour >= 5 && $hour < 12) {
                                    $greeting = __('Good morning') . ' 👋';
                                } elseif ($hour >= 12 && $hour < 17) {
                                    $greeting = __('Good afternoon') . ' 👋';
                                } elseif ($hour >= 17 && $hour < 21) {
                                    $greeting = __('Good evening') . ' 👋';
                                } else {
                                    $greeting = __('Good night') . ' 👋';
                                }
                            @endphp
                            {{ $greeting }}, {{ Auth::user()->name }}!
                        </h3>
                        <p class="dd-welcome-subtitle">{{ __('Your work overview and assigned tasks') }}</p>
                    </div>
                    <div class="dd-welcome-avatar d-none d-sm-flex">
                        <i class="ti ti-user-check"></i>
                    </div>
                </div>
            </div>

            {{-- Stats Section Label --}}
            <div class="dd-section-label">{{ __('MY WORK METRICS') }}</div>

            {{-- Stats Grid --}}
            <div class="row g-3 mb-4">
                {{-- Total Customer --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-users"></i>
                            </div>
                            <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ $result['totalCustomer'] }}</div>
                            <div class="dd-stat-label">{{ __('Total Customers') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-users-group" style="font-size: 11px;"></i> {{ __('Assigned clients') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Measurement --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-ruler-2"></i>
                            </div>
                            <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ $result['totalMeasurement'] }}</div>
                            <div class="dd-stat-label">{{ __('Total Measurements') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-ruler" style="font-size: 11px;"></i> {{ __('Recorded') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Orders --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-shopping-cart"></i>
                            </div>
                            <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ $result['totalOrder'] }}</div>
                            <div class="dd-stat-label">{{ __('Total Orders') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-package" style="font-size: 11px;"></i> {{ __('All assigned') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Today Orders --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                            <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ $result['totalTodayOrder'] }}</div>
                            <div class="dd-stat-label">{{ __('Today\'s Orders') }}</div>
                            <div class="dd-stat-subtext">
                                <span class="dd-live-dot me-1"></span> {{ __('Live') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart Section --}}
            <div class="dd-chart-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="dd-chart-title">{{ __('Order Status Overview') }}</h5>
                        <p class="dd-stat-label mb-0 mt-1">{{ __('Completed vs Pending orders this week') }}</p>
                    </div>
                    <span class="dd-chart-badge">
                        <span class="dd-live-dot me-1"></span> {{ __('This Week') }}
                    </span>
                </div>
                <div id="totalOrderStatus"></div>
            </div>

            {{-- Order List Section --}}
            <div class="dd-section-header">
                <span class="dd-section-label mb-0">{{ __('ORDER LIST') }}</span>
                <a href="{{ route('order.index') }}" class="dd-view-all">
                    {{ __('View All') }} <i class="ti ti-arrow-right" style="font-size: 14px;"></i>
                </a>
            </div>

            <div class="dd-chart-card" style="padding: 0; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table dd-table mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Order Date') }}</th>
                                <th>{{ __('Deadline') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('Cloth Type') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('Gender') }}</th>
                                <th class="d-none d-lg-table-cell">{{ __('Responsible') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result['notifyOrder'] as $order)
                                <tr>
                                    <td>
                                        <span class="dd-order-id">{{ orderPrefix() . $order->order_id }}</span>
                                    </td>
                                    <td>
                                        <span class="dd-order-customer">{{ !empty($order->customers) ? $order->customers->name : '-' }}</span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="dd-order-meta">{{ dateFormat($order->order_date) }}</span>
                                    </td>
                                    <td>
                                        <span class="dd-order-meta">{{ dateFormat($order->deadline_date) }}</span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="dd-order-meta">{{ !empty($order->clothTypes) ? $order->clothTypes->title : '-' }}</span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="dd-order-meta">{{ $order->gender }}</span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="dd-order-meta">{{ !empty($order->users) ? $order->users->name : '-' }}</span>
                                    </td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="dd-badge dd-badge-pending">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                        @elseif($order->status == 'in_progress')
                                            <span class="dd-badge dd-badge-in-progress">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                        @elseif($order->status == 'completed')
                                            <span class="dd-badge dd-badge-completed">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="dd-badge dd-badge-delivered">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                        @else
                                            <span class="dd-badge dd-badge-in-progress">{{ \App\Models\Order::$status[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('show order')
                                            <a class="dd-view-btn"
                                                href="{{ route('order.show', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}">
                                                <i class="ti ti-eye" style="font-size: 14px;"></i> {{ __('View') }}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @elseif (Auth::user()->type == 'customer')
            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- CUSTOMER DASHBOARD --}}
            {{-- ═══════════════════════════════════════════════════════ --}}

            {{-- Welcome Banner --}}
            <div class="dd-welcome-banner">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="flex-grow-1">
                        <div class="dd-welcome-label">{{ __('MY PORTAL') }}</div>
                        <h3 class="dd-welcome-title">
                            @php
                                $hour = now()->format('H');
                                if ($hour >= 5 && $hour < 12) {
                                    $greeting = __('Good morning') . ' 👋';
                                } elseif ($hour >= 12 && $hour < 17) {
                                    $greeting = __('Good afternoon') . ' 👋';
                                } elseif ($hour >= 17 && $hour < 21) {
                                    $greeting = __('Good evening') . ' 👋';
                                } else {
                                    $greeting = __('Good night') . ' 👋';
                                }
                            @endphp
                            {{ $greeting }}, {{ Auth::user()->name }}!
                        </h3>
                        <p class="dd-welcome-subtitle">{{ __('Track your orders, measurements and invoices') }}</p>
                        
                        {{-- Quick Actions Bar --}}
                        <div class="dd-quick-actions">
                            <a href="{{ route('customer.orders') }}" class="dd-btn-primary">
                                <i class="ti ti-shopping-cart"></i> {{ __('View My Orders') }}
                            </a>
                            <a href="{{ route('customer.measurements') }}" class="dd-btn-outline">
                                <i class="ti ti-ruler"></i> {{ __('My Measurements') }}
                            </a>
                            <a href="{{ route('customer.invoices') }}" class="dd-btn-outline">
                                <i class="ti ti-receipt"></i> {{ __('My Invoices') }}
                            </a>
                            <a href="{{ route('track.order') }}" class="dd-btn-outline">
                                <i class="ti ti-search"></i> {{ __('Track Order') }}
                            </a>
                        </div>
                    </div>
                    <div class="dd-welcome-avatar d-none d-sm-flex">
                        <i class="ti ti-user"></i>
                    </div>
                </div>
            </div>

            {{-- Stats Section Label --}}
            <div class="dd-section-label">{{ __('YOUR OVERVIEW') }}</div>

            {{-- Stats Grid --}}
            <div class="row g-3 mb-4">
                {{-- Total Measurement --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <a href="{{ route('customer.measurements') }}" class="text-decoration-none">
                        <div class="dd-stat-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="dd-stat-icon">
                                    <i class="ti ti-ruler"></i>
                                </div>
                                <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                            </div>
                            <div>
                                <div class="dd-stat-value">{{ $result['totalMeasurement'] }}</div>
                                <div class="dd-stat-label">{{ __('Total Measurements') }}</div>
                                <div class="dd-stat-subtext">
                                    <i class="ti ti-ruler-2" style="font-size: 11px;"></i> {{ __('Saved profiles') }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Total Order --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <a href="{{ route('customer.orders') }}" class="text-decoration-none">
                        <div class="dd-stat-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="dd-stat-icon">
                                    <i class="ti ti-shopping-cart"></i>
                                </div>
                                <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                            </div>
                            <div>
                                <div class="dd-stat-value">{{ $result['totalOrder'] }}</div>
                                <div class="dd-stat-label">{{ __('Total Orders') }}</div>
                                <div class="dd-stat-subtext">
                                    <i class="ti ti-shopping-bag" style="font-size: 11px;"></i> {{ __('All orders') }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Total Paid --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <a href="{{ route('customer.invoices') }}" class="text-decoration-none">
                        <div class="dd-stat-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="dd-stat-icon">
                                    <i class="ti ti-cash"></i>
                                </div>
                                <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                            </div>
                            <div>
                                <div class="dd-stat-value">{{ priceFormat($result['totalPaidAmount'] ?? 0) }}</div>
                                <div class="dd-stat-label">{{ __('Total Paid') }}</div>
                                <div class="dd-stat-subtext">
                                    <i class="ti ti-check" style="font-size: 11px;"></i> {{ __('Settled') }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Total Unpaid --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <a href="{{ route('customer.invoices') }}" class="text-decoration-none">
                        <div class="dd-stat-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="dd-stat-icon">
                                    <i class="ti ti-alert-circle"></i>
                                </div>
                                <i class="ti ti-arrow-up-right" style="color: var(--dd-teal); font-size: 18px;"></i>
                            </div>
                            <div>
                                <div class="dd-stat-value">{{ priceFormat($result['totalUnpaidAmount'] ?? 0) }}</div>
                                <div class="dd-stat-label">{{ __('Unpaid Amount') }}</div>
                                <div class="dd-stat-subtext">
                                    <i class="ti ti-clock" style="font-size: 11px;"></i> {{ __('Outstanding') }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Recent Orders Table Section --}}
            @if(isset($result['recentOrders']) && count($result['recentOrders']) > 0)
                <div class="dd-section-label mt-4">{{ __('RECENT TAILORING ORDERS') }}</div>
                <div class="dd-chart-card mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="dd-chart-title">{{ __('My Recent Orders') }}</h5>
                        <a href="{{ route('customer.orders') }}" class="dd-btn-outline py-1 px-3" style="font-size: 12px;">
                            {{ __('View All') }} <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dd-table w-100">
                            <thead>
                                <tr>
                                    <th>{{ __('Order #') }}</th>
                                    <th>{{ __('Cloth Type') }}</th>
                                    <th>{{ __('Order Date') }}</th>
                                    <th>{{ __('Delivery Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['recentOrders'] as $rOrder)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ orderPrefix() . $rOrder->id }}</td>
                                        <td>{{ $rOrder->clothTypes->title ?? $rOrder->clothTypes->name ?? '-' }}</td>
                                        <td>{{ $rOrder->order_date ? \Carbon\Carbon::parse($rOrder->order_date)->format('d M Y') : '-' }}</td>
                                        <td>{{ $rOrder->deadline_date ? \Carbon\Carbon::parse($rOrder->deadline_date)->format('d M Y') : '-' }}</td>
                                        <td>
                                            @php
                                                $bColors = [
                                                    'pending' => 'dd-badge-pending',
                                                    'in_progress' => 'dd-badge-in-progress',
                                                    'completed' => 'dd-badge-completed',
                                                    'ready_for_delivery' => 'dd-badge-completed',
                                                    'delivered' => 'dd-badge-completed',
                                                ];
                                            @endphp
                                            <span class="dd-badge {{ $bColors[$rOrder->status] ?? 'dd-badge-in-progress' }}">
                                                {{ ucwords(str_replace('_', ' ', $rOrder->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('customer.orders.show', $rOrder->id) }}" class="btn btn-sm btn-light-primary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Order Notifications --}}
            @if (count($result['notifyOrder']) > 0)
                <div class="dd-section-header mt-4">
                    <span class="dd-section-label mb-0">{{ __('ORDER NOTIFICATIONS') }}</span>
                </div>

                @foreach ($result['notifyOrder'] as $order)
                    @php
                        $allowedStatuses = ['pending', 'in_progress', 'completed'];
                        if (!in_array($order->status, $allowedStatuses)) {
                            continue;
                        }
                        $statusColors = [
                            'pending' => 'pending',
                            'in_progress' => 'in-progress',
                            'completed' => 'completed',
                        ];
                        $badgeClass = 'dd-badge-' . ($statusColors[$order->status] ?? 'in-progress');
                    @endphp

                    <div class="dd-order-card" style="border-left: 3px solid var(--dd-teal);">
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="dd-stat-icon" style="background: var(--dd-teal-light); width: 36px; height: 36px; border-radius: 10px;">
                                    <i class="ti ti-shopping-cart" style="color: var(--dd-teal); font-size: 16px;"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="dd-order-id">{{ orderPrefix() . $order->id }}</span>
                                        <span class="dd-badge {{ $badgeClass }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                    <div class="dd-order-meta mt-1">
                                        <span><i class="ti ti-calendar me-1"></i>{{ __('Order') }}: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</span>
                                        <span class="ms-3"><i class="ti ti-clock me-1"></i>{{ __('Deadline') }}: {{ \Carbon\Carbon::parse($order->deadline_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('customer.orders.show', $order->id) }}" class="dd-view-btn">
                                <i class="ti ti-eye" style="font-size: 14px;"></i> {{ __('View Order') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
@endsection

@push('script-page')
<script>
    window.fetchDashboardStats = function() {
        $.get("{{ route('dashboard') }}", function(html) {
            var $newContent = $(html).find('.dd-dashboard');
            if ($newContent.length) {
                $('.dd-dashboard').html($newContent.html());
            }
        });
    };
</script>
@endpush
