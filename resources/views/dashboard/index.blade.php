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
            --dd-teal: #00796B;
            --dd-teal-light: #E6F4F1;
            --dd-teal-dark: #004D40;
            --dd-bg: #F8FAFC;
            --dd-card: #FFFFFF;
            --dd-border: #E2E8F0;
            --dd-text: #0F172A;
            --dd-text-muted: #64748B;
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
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .dd-welcome-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--dd-teal);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .dd-welcome-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--dd-text);
            margin-bottom: 0;
        }
        .dd-welcome-subtitle {
            font-size: 13px;
            color: var(--dd-text-muted);
            margin-top: 4px;
            margin-bottom: 0;
        }
        .dd-welcome-avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--dd-teal-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dd-welcome-avatar i {
            font-size: 22px;
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
            background: var(--dd-teal);
            color: #FFFFFF;
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
        }
        .dd-btn-primary:hover {
            background: var(--dd-teal-dark);
            color: #FFFFFF;
            text-decoration: none;
        }
        .dd-btn-outline {
            background: #FFFFFF;
            color: var(--dd-text);
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
            background: #F1F5F9;
            color: var(--dd-text);
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
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 135px;
        }
        .dd-stat-card:hover {
            border-color: var(--dd-teal);
            box-shadow: 0 4px 14px rgba(0, 121, 107, 0.08);
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
            background: var(--dd-teal);
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
            background: var(--dd-teal-dark);
        }
        .dd-sub-label {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
        }
        .dd-sub-title {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
            margin: 4px 0;
        }
        .dd-btn-upgrade {
            background: rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.3);
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
            background: rgba(255, 255, 255, 0.35);
            color: #FFFFFF;
            text-decoration: none;
        }

        /* Clean Chart Card */
        .dd-chart-card {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
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
            color: var(--dd-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid var(--dd-border);
            padding: 12px 18px;
            background: #F8FAFC;
        }
        .dd-table tbody td {
            font-size: 13.5px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--dd-border);
            vertical-align: middle;
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
        .dd-badge-pending { background: #FEF3C7; color: #92400E; }
        .dd-badge-in-progress { background: #E0F2FE; color: #0369A1; }
        .dd-badge-completed { background: #DCFCE7; color: #166534; }
        .dd-badge-delivered { background: #F3E8FF; color: #6B21A8; }

        .dd-view-btn {
            background: var(--dd-teal-light);
            color: var(--dd-teal);
            border: none;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }
        .dd-view-btn:hover {
            background: var(--dd-teal);
            color: #FFFFFF;
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
                colors: ['#00796B', '#64748B'],
                dataLabels: { enabled: false },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    fontFamily: 'JetBrains Mono',
                    fontSize: '10px',
                    fontWeight: 700,
                    labels: { colors: '#64748B' },
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
                    borderColor: '#E2E8F0',
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
                            colors: '#64748B'
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
                            colors: '#64748B'
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

            var donutOptions = {
                chart: {
                    type: 'donut',
                    height: 290,
                    fontFamily: 'Hanken Grotesk, sans-serif'
                },
                colors: ['#00796B', '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
                series: {!! json_encode($result['orderStatusDistribution']['counts'] ?? [0]) !!},
                labels: {!! json_encode($result['orderStatusDistribution']['labels'] ?? ['No Orders']) !!},
                legend: {
                    position: 'bottom',
                    fontFamily: 'JetBrains Mono',
                    fontSize: '11px'
                },
                dataLabels: { enabled: true },
                tooltip: { theme: 'dark' }
            };
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
                colors: ['#00796B', '#64748B'],
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
                    labels: { colors: '#64748B' }
                },
                grid: {
                    show: true,
                    borderColor: '#E2E8F0',
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
                        style: { fontFamily: 'JetBrains Mono', fontSize: '10px', colors: '#64748B' }
                    }
                },
                yaxis: {
                    labels: {
                        style: { fontFamily: 'JetBrains Mono', fontSize: '10px', colors: '#64748B' }
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
                    <a href="{{ route('order.index') }}" class="dd-btn-primary">
                        <i class="ti ti-plus"></i> {{ __('New Order') }}
                    </a>
                    <a href="{{ route('measurement.index') }}" class="dd-btn-outline">
                        <i class="ti ti-ruler-2"></i> {{ __('Take Measurements') }}
                    </a>
                    <a href="{{ route('customer.index') }}" class="dd-btn-outline">
                        <i class="ti ti-users"></i> {{ __('View Clients') }}
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
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="dd-stat-icon">
                            <i class="ti ti-users"></i>
                        </div>
                        <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ $result['totalCustomer'] }}</div>
                        <div class="dd-stat-label">{{ __('Total Clients') }}</div>
                        <div class="dd-stat-subtext">
                            <i class="ti ti-trending-up" style="font-size: 11px;"></i> {{ __('Active clients') }}
                        </div>
                    </div>
                </div>

                {{-- Total Cloth Type --}}
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="dd-stat-icon">
                            <i class="ti ti-hanger"></i>
                        </div>
                        <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ $result['totalClothType'] }}</div>
                        <div class="dd-stat-label">{{ __('Cloth Types') }}</div>
                        <div class="dd-stat-subtext">
                            <i class="ti ti-category" style="font-size: 11px;"></i> {{ __('Categories') }}
                        </div>
                    </div>
                </div>

                {{-- Total Income --}}
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="dd-stat-icon">
                            <i class="ti ti-wallet"></i>
                        </div>
                        <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ getSettingsValByName('CURRENCY_SYMBOL') . number_format($result['totalIncome'], 2) }}</div>
                        <div class="dd-stat-label">{{ __('Total Income') }}</div>
                        <div class="dd-stat-subtext">
                            <i class="ti ti-trending-up" style="font-size: 11px;"></i> {{ __('Revenue earned') }}
                        </div>
                    </div>
                </div>

                {{-- Total Expense --}}
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="dd-stat-icon">
                            <i class="ti ti-credit-card"></i>
                        </div>
                        <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ getSettingsValByName('CURRENCY_SYMBOL') . number_format($result['totalExpense'], 2) }}</div>
                        <div class="dd-stat-label">{{ __('Total Expense') }}</div>
                        <div class="dd-stat-subtext">
                            <i class="ti ti-arrow-down-right" style="font-size: 11px;"></i> {{ __('Costs incurred') }}
                        </div>
                    </div>
                </div>
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
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="dd-chart-title">{{ __('Order Status Breakdown') }}</h5>
                                <p class="dd-stat-label mb-0 mt-1">{{ __('Real-time status distribution') }}</p>
                            </div>
                        </div>
                        <div id="orderStatusDonut" style="min-height: 280px;"></div>
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
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-ruler"></i>
                            </div>
                            <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ $result['totalMeasurement'] }}</div>
                            <div class="dd-stat-label">{{ __('Total Measurements') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-ruler-2" style="font-size: 11px;"></i> {{ __('Saved profiles') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Order --}}
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
                                <i class="ti ti-shopping-bag" style="font-size: 11px;"></i> {{ __('All orders') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Paid --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-cash"></i>
                            </div>
                            <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ priceFormat($result['totalPaidAmount'] ?? 0) }}</div>
                            <div class="dd-stat-label">{{ __('Total Paid') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-check" style="font-size: 11px;"></i> {{ __('Settled') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Unpaid --}}
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="dd-stat-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="dd-stat-icon">
                                <i class="ti ti-alert-circle"></i>
                            </div>
                            <i class="ti ti-dots-vertical" style="color: #CBD5E1; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div class="dd-stat-value">{{ priceFormat($result['totalUnpaidAmount'] ?? 0) }}</div>
                            <div class="dd-stat-label">{{ __('Unpaid Amount') }}</div>
                            <div class="dd-stat-subtext">
                                <i class="ti ti-clock" style="font-size: 11px;"></i> {{ __('Outstanding') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Notifications --}}
            @if (count($result['notifyOrder']) > 0)
                <div class="dd-section-header">
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
                            <a href="{{ route('order.show', encrypt($order->id)) }}" class="dd-view-btn">
                                <i class="ti ti-eye" style="font-size: 14px;"></i> {{ __('View Order') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
@endsection
