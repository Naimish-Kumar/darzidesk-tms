@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Super Admin Dashboard') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Dashboard') }}</li>
@endsection

@push('css-page')
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dd-teal: #00796B;
            --dd-teal-light: #E0F2F1;
            --dd-teal-dark: #004D40;
            --dd-navy: #002366;
            --dd-card: #FFFFFF;
            --dd-border: #EDEEEF;
            --dd-text: #333333;
            --dd-text-muted: #757682;
            --dd-green: #2E7D32;
            --dd-green-bg: #E8F5E9;
            --dd-orange: #E65100;
            --dd-orange-bg: #FFF3E0;
            --dd-blue: #1976D2;
            --dd-blue-bg: #E3F2FD;
            --dd-red: #C62828;
            --dd-red-bg: #FFEBEE;
        }

        .dd-dashboard {
            font-family: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .dd-welcome-banner {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            margin-bottom: 28px;
        }
        .dd-welcome-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            color: var(--dd-teal);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 4px;
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
        }
        .dd-welcome-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--dd-teal-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dd-welcome-avatar i {
            font-size: 24px;
            color: var(--dd-teal);
        }

        .dd-quick-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        .dd-btn-primary {
            background: var(--dd-teal);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dd-btn-primary:hover {
            background: var(--dd-teal-dark);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,121,107,0.25);
        }
        .dd-btn-outline {
            background: transparent;
            color: var(--dd-teal);
            border: 1.5px solid var(--dd-teal);
            border-radius: 10px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dd-btn-outline:hover {
            background: var(--dd-teal-light);
            color: var(--dd-teal-dark);
        }

        .dd-section-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--dd-text-muted);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .dd-stat-card {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 140px;
        }
        .dd-stat-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.08);
            transform: translateY(-3px);
        }
        .dd-stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dd-stat-icon i {
            font-size: 20px;
        }
        .dd-stat-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--dd-text);
            line-height: 1.2;
            margin-bottom: 2px;
        }
        .dd-stat-label {
            font-size: 12.5px;
            color: var(--dd-text-muted);
            font-weight: 500;
            margin-bottom: 4px;
        }
        .dd-stat-subtext {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
        }

        .dd-chart-card {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            margin-bottom: 28px;
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
            background: #F0F2F4;
            color: var(--dd-teal);
            padding: 4px 10px;
            border-radius: 8px;
        }

        @keyframes dd-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .dd-live-dot {
            width: 6px;
            height: 6px;
            background: var(--dd-green);
            border-radius: 50%;
            display: inline-block;
            animation: dd-pulse 2s ease-in-out infinite;
        }

        /* Dark Mode Overrides */
        [data-pc-theme="dark"] .dd-welcome-banner,
        [data-pc-theme="dark"] .dd-stat-card,
        [data-pc-theme="dark"] .dd-chart-card {
            background: #1a2332;
            border-color: rgba(255,255,255,0.08);
        }
        [data-pc-theme="dark"] .dd-welcome-title,
        [data-pc-theme="dark"] .dd-stat-value,
        [data-pc-theme="dark"] .dd-chart-title {
            color: #fff;
        }
    </style>
@endpush

@push('script-page')
    <script>
        var options = {
            chart: {
                type: 'area',
                height: 360,
                fontFamily: 'Hanken Grotesk, sans-serif',
                toolbar: { show: false }
            },
            responsive: [{
                breakpoint: 576,
                options: {
                    chart: { height: 260 },
                    legend: { position: 'bottom' }
                }
            }],
            colors: ['#00796B', '#002366'],
            dataLabels: { enabled: false },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'right',
                fontFamily: 'JetBrains Mono',
                fontSize: '10px',
                fontWeight: 700,
                labels: { colors: '#757682' },
                markers: { radius: 3 }
            },
            markers: {
                size: 3,
                colors: ['#fff'],
                strokeColors: ['#00796B', '#002366'],
                strokeWidth: 2,
                shape: 'circle',
                hover: { size: 5 }
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
                borderColor: '#EDEEEF',
                strokeDashArray: 4,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } },
                padding: { left: 10, right: 10 }
            },
            series: [{
                name: "{{ __('Total Users') }}",
                data: {!! json_encode($result['organizationByMonth']['data']) !!}
            }, {
                name: "{{ __('Total Payment') }}",
                data: {!! json_encode($result['paymentByMonth']['data']) !!}
            }],
            xaxis: {
                categories: {!! json_encode($result['organizationByMonth']['label']) !!},
                tooltip: { enabled: false },
                labels: {
                    hideOverlappingLabels: true,
                    style: {
                        fontFamily: 'JetBrains Mono',
                        fontSize: '10px',
                        fontWeight: 600,
                        colors: '#757682'
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
                        colors: '#757682'
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                style: { fontFamily: 'Hanken Grotesk', fontSize: '12px' }
            }
        };
        var chart = new ApexCharts(document.querySelector('#users_and_payments_overview'), options);
        chart.render();
    </script>
@endpush

@section('content')
    <div class="dd-dashboard">
        {{-- Welcome Banner --}}
        <div class="dd-welcome-banner">
            <div class="d-flex align-items-center justify-content-between">
                <div class="flex-grow-1">
                    <div class="dd-welcome-label">{{ __('SUPER ADMIN CONTROL PANEL') }}</div>
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
                    <p class="dd-welcome-subtitle">{{ __('System-wide overview of tenants, subscription packages, and revenue performance') }}</p>
                </div>
                <div class="dd-welcome-avatar d-none d-sm-flex">
                    <i class="ti ti-shield-check"></i>
                </div>
            </div>
            <div class="dd-quick-actions">
                <a href="{{ route('users.index') }}" class="dd-btn-primary">
                    <i class="ti ti-users"></i> {{ __('Manage Tenants') }}
                </a>
                <a href="{{ route('subscriptions.index') }}" class="dd-btn-outline">
                    <i class="ti ti-package"></i> {{ __('Pricing Packages') }}
                </a>
                <a href="{{ route('subscription.transaction') }}" class="dd-btn-outline">
                    <i class="ti ti-receipt"></i> {{ __('Transactions') }}
                </a>
                <a href="{{ route('setting.index') }}" class="dd-btn-outline">
                    <i class="ti ti-settings"></i> {{ __('System Settings') }}
                </a>
            </div>
        </div>

        {{-- Metrics Label --}}
        <div class="dd-section-label">{{ __('PLATFORM METRICS') }}</div>

        {{-- Stat Cards Grid --}}
        <div class="row g-3 mb-4">
            {{-- Total Users --}}
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="dd-stat-icon" style="background: var(--dd-teal-light);">
                            <i class="ti ti-users" style="color: var(--dd-teal);"></i>
                        </div>
                        <span class="dd-live-dot"></span>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ $result['totalOrganization'] }}</div>
                        <div class="dd-stat-label">{{ __('Registered Owners') }}</div>
                        <div class="dd-stat-subtext" style="color: var(--dd-teal);">
                            <i class="ti ti-building-store" style="font-size: 11px;"></i> {{ __('Active boutiques') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Packages --}}
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="dd-stat-icon" style="background: var(--dd-orange-bg);">
                            <i class="ti ti-package" style="color: var(--dd-orange);"></i>
                        </div>
                        <i class="ti ti-dots" style="color: #C5C6D2; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ $result['totalSubscription'] }}</div>
                        <div class="dd-stat-label">{{ __('Active Packages') }}</div>
                        <div class="dd-stat-subtext" style="color: var(--dd-orange);">
                            <i class="ti ti-crown" style="font-size: 11px;"></i> {{ __('Plans available') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Transactions --}}
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="dd-stat-icon" style="background: var(--dd-blue-bg);">
                            <i class="ti ti-receipt" style="color: var(--dd-blue);"></i>
                        </div>
                        <i class="ti ti-dots" style="color: #C5C6D2; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ $result['totalTransaction'] }}</div>
                        <div class="dd-stat-label">{{ __('Total Transactions') }}</div>
                        <div class="dd-stat-subtext" style="color: var(--dd-blue);">
                            <i class="ti ti-history" style="font-size: 11px;"></i> {{ __('Completed billing') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Revenue --}}
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="dd-stat-icon" style="background: var(--dd-green-bg);">
                            <i class="ti ti-wallet" style="color: var(--dd-green);"></i>
                        </div>
                        <i class="ti ti-dots" style="color: #C5C6D2; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div class="dd-stat-value">{{ getSettingsValByName('CURRENCY_SYMBOL') . number_format($result['totalIncome'], 2) }}</div>
                        <div class="dd-stat-label">{{ __('Platform Revenue') }}</div>
                        <div class="dd-stat-subtext" style="color: var(--dd-green);">
                            <i class="ti ti-trending-up" style="font-size: 11px;"></i> {{ __('Total subscription earnings') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Analytics Chart Card --}}
        <div class="dd-chart-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="dd-chart-title">{{ __('Analysis Report') }}</h5>
                    <p class="dd-stat-label mb-0 mt-1">{{ __('Monthly overview of user registrations and subscription payments') }}</p>
                </div>
                <span class="dd-chart-badge">
                    <span class="dd-live-dot me-1"></span> {{ __('This Year') }}
                </span>
            </div>
            <div id="users_and_payments_overview"></div>
        </div>
    </div>
@endsection
