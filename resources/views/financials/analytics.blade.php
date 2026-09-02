@extends('layouts.app')

@section('page-title')
    {{ __('Financial & Profit Analytics') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Financial Analytics') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --fin-bg-card: #FFFFFF;
            --fin-border: #E2E8F0;
            --fin-inner-bg: #F8FAFC;
            --fin-text-title: #0F172A;
            --fin-text-sub: #64748B;
            --dd-gold: #D9A441;
            --dd-gold-light: rgba(217, 164, 65, 0.15);
            --font-code: 'JetBrains Mono', monospace;
        }

        [data-pc-theme="dark"] {
            --fin-bg-card: #0B2239;
            --fin-border: #29435D;
            --fin-inner-bg: #102B45;
            --fin-text-title: #FFFFFF;
            --fin-text-sub: #8FA1B5;
        }

        .fin-header-bar {
            background: var(--fin-bg-card);
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--fin-border);
            margin-bottom: 24px;
            color: var(--fin-text-title);
        }

        .metric-card-custom {
            background: var(--fin-bg-card);
            border: 1px solid var(--fin-border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
            height: 100%;
        }

        .metric-card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-color: var(--dd-gold);
        }

        .metric-lbl {
            font-family: var(--font-code);
            font-size: 11px;
            font-weight: 700;
            color: var(--fin-text-sub);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .metric-val {
            font-size: 26px;
            font-weight: 800;
            color: var(--fin-text-title);
            line-height: 1.1;
        }

        .net-profit-banner {
            background: linear-gradient(135deg, #071C2F 0%, #0F3356 100%);
            border: 1px solid var(--fin-border);
            border-radius: 18px;
            padding: 24px 28px;
            color: #FFFFFF;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            margin-bottom: 24px;
        }

        .chart-card-custom {
            background: var(--fin-bg-card);
            border: 1px solid var(--fin-border);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            height: 100%;
            color: var(--fin-text-title);
        }

        .table-custom-fin {
            font-size: 13.5px;
            color: var(--fin-text-title);
        }

        .table-custom-fin th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--dd-gold);
            font-weight: 700;
            background: var(--fin-inner-bg);
            border-bottom: 1px solid var(--fin-border);
        }

        .table-custom-fin td {
            border-bottom: 1px solid var(--fin-border);
            color: var(--fin-text-title);
        }
    </style>
@endpush

@section('content')
    @php
        $currency = subscriptionPaymentSettings()['CURRENCY_SYMBOL'] ?? '₹';
    @endphp

    <!-- Header & Date Filter Bar -->
    <div class="fin-header-bar d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="avtar avtar-m rounded-circle" style="background: var(--dd-gold-light); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.3);">
                <i class="ti ti-chart-dots f-24"></i>
            </div>
            <div>
                <h4 class="mb-0 font-weight-bold" style="color: var(--fin-text-title);">{{ __('Financial & Revenue Intelligence') }}</h4>
                <small style="color: var(--fin-text-sub);">{{ __('Real-time financial performance, profit margins, payouts and asset valuations') }}</small>
            </div>
        </div>

        <!-- Filter Selector -->
        <form method="GET" action="{{ route('financials.analytics') }}" class="d-flex align-items-center gap-2">
            <label class="fs-8 font-weight-bold mb-0 text-uppercase" style="color: var(--fin-text-sub);">{{ __('PERIOD') }}:</label>
            <select name="filter" onchange="this.form.submit()" class="form-select form-select-sm rounded-3 font-weight-bold" style="width: 160px; background-color: var(--fin-inner-bg); border-color: var(--fin-border); color: var(--fin-text-title);">
                <option value="all_time" {{ $filter == 'all_time' ? 'selected' : '' }}>{{ __('All Time') }}</option>
                <option value="this_month" {{ $filter == 'this_month' ? 'selected' : '' }}>{{ __('This Month') }}</option>
                <option value="last_month" {{ $filter == 'last_month' ? 'selected' : '' }}>{{ __('Last Month') }}</option>
                <option value="this_year" {{ $filter == 'this_year' ? 'selected' : '' }}>{{ __('This Year') }}</option>
            </select>
        </form>
    </div>

    <!-- Net Profit Highlight Banner -->
    <div class="net-profit-banner d-flex flex-wrap align-items-center justify-content-between gap-4">
        <div>
            <span class="badge px-3 py-1 rounded-pill font-weight-bold mb-2" style="background: var(--dd-gold); color: #03111F;">{{ __('NET PROFIT & MARGIN') }}</span>
            <h2 class="display-6 font-weight-bold mb-1 text-white">{{ $currency . number_format($netProfit, 2) }}</h2>
            <p class="mb-0 opacity-75 fs-7">{{ __('Calculated as Total Collections minus Operating Expenses & Tailor Payouts') }}</p>
        </div>
        <div class="d-flex gap-4">
            <div class="border-end border-white-50 pe-4">
                <small class="d-block text-white-50 font-weight-bold text-uppercase fs-8">{{ __('PROFIT MARGIN') }}</small>
                <span class="fs-3 font-weight-bold text-white">{{ number_format($profitMargin, 1) }}%</span>
            </div>
            <div>
                <small class="d-block text-white-50 font-weight-bold text-uppercase fs-8">{{ __('TOTAL COSTS') }}</small>
                <span class="fs-3 font-weight-bold text-white">{{ $currency . number_format($totalExpenses, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- 4 Key Financial Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="metric-card-custom">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avtar avtar-s bg-light-success text-success rounded-circle">
                        <i class="ti ti-wallet fs-4"></i>
                    </div>
                    <span class="badge bg-light-success text-success rounded-pill px-2 py-1 fs-8">{{ __('Collections') }}</span>
                </div>
                <div class="metric-lbl">{{ __('TOTAL REVENUE') }}</div>
                <div class="metric-val text-success">{{ $currency . number_format($totalRevenue, 2) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="metric-card-custom">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avtar avtar-s bg-light-warning text-warning rounded-circle">
                        <i class="ti ti-clock fs-4"></i>
                    </div>
                    <span class="badge bg-light-warning text-warning rounded-pill px-2 py-1 fs-8">{{ __('Pending') }}</span>
                </div>
                <div class="metric-lbl">{{ __('OUTSTANDING INVOICES') }}</div>
                <div class="metric-val text-warning">{{ $currency . number_format($outstandingAmount, 2) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="metric-card-custom">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avtar avtar-s bg-light-danger text-danger rounded-circle">
                        <i class="ti ti-receipt-off fs-4"></i>
                    </div>
                    <span class="badge bg-light-danger text-danger rounded-pill px-2 py-1 fs-8">{{ __('Operating') }}</span>
                </div>
                <div class="metric-lbl">{{ __('OPERATING EXPENSES') }}</div>
                <div class="metric-val text-danger">{{ $currency . number_format($operatingExpenses, 2) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="metric-card-custom">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avtar avtar-s bg-light-primary text-primary rounded-circle">
                        <i class="ti ti-scissors fs-4"></i>
                    </div>
                    <span class="badge bg-light-primary text-primary rounded-pill px-2 py-1 fs-8">{{ __('Labor') }}</span>
                </div>
                <div class="metric-lbl">{{ __('TAILOR PAYOUTS') }}</div>
                <div class="metric-val text-primary">{{ $currency . number_format($tailorPayouts, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Row: Monthly Trend & Payment Method Breakdown -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8 col-12">
            <div class="chart-card-custom">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: var(--fin-border) !important;">
                    <div>
                        <h5 class="mb-0 font-weight-bold" style="color: var(--fin-text-title);"><i class="ti ti-trending-up me-2" style="color: var(--dd-gold);"></i>{{ __('Revenue vs. Operating Costs Trend') }}</h5>
                        <small style="color: var(--fin-text-sub);">{{ __('Monthly comparison over the last 6 months') }}</small>
                    </div>
                </div>
                <div id="monthlyFinancialChart" style="min-height: 280px;"></div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="chart-card-custom">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: var(--fin-border) !important;">
                    <div>
                        <h5 class="mb-0 font-weight-bold" style="color: var(--fin-text-title);"><i class="ti ti-credit-card me-2" style="color: var(--dd-gold);"></i>{{ __('Payment Methods') }}</h5>
                        <small style="color: var(--fin-text-sub);">{{ __('Collections by payment mode') }}</small>
                    </div>
                </div>
                <div id="paymentMethodChart" style="min-height: 260px;"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Expense Breakdown & Asset Valuation + Recent Payments -->
    <div class="row g-4">
        <!-- Expense Categories -->
        <div class="col-lg-4 col-12">
            <div class="chart-card-custom">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: var(--fin-border) !important;">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--fin-text-title);"><i class="ti ti-category text-danger me-2"></i>{{ __('Expense Categories') }}</h5>
                </div>
                <div>
                    @forelse($expenseCategories as $cat)
                        @php
                            $pct = $operatingExpenses > 0 ? ($cat->total / $operatingExpenses) * 100 : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="font-weight-bold fs-7" style="color: var(--fin-text-title);">{{ $cat->category->name ?? 'General Expense' }}</span>
                                <span class="font-monospace fs-7" style="color: var(--fin-text-sub);">{{ $currency . number_format($cat->total, 2) }} ({{ number_format($pct, 1) }}%)</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 4px; background-color: var(--fin-inner-bg);">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $pct }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4" style="color: var(--fin-text-sub);">
                            <i class="ti ti-receipt-off fs-2 d-block mb-1"></i>
                            {{ __('No expense categories recorded.') }}
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 p-3 rounded-3" style="background: var(--dd-gold-light); border: 1px solid rgba(217, 164, 65, 0.3);">
                    <small class="text-uppercase font-weight-bold d-block mb-1" style="color: var(--dd-gold);">{{ __('INVENTORY STOCK VALUATION') }}</small>
                    <div class="h4 font-weight-bold mb-0" style="color: var(--fin-text-title);">{{ $currency . number_format($stockValuation, 2) }}</div>
                    <small class="fs-8 d-block mt-1" style="color: var(--fin-text-sub);">{{ __('Valuation of raw fabric & trims across workshops') }}</small>
                </div>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="col-lg-8 col-12">
            <div class="chart-card-custom">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: var(--fin-border) !important;">
                    <div>
                        <h5 class="mb-0 font-weight-bold" style="color: var(--fin-text-title);"><i class="ti ti-history text-success me-2"></i>{{ __('Recent Payment Transactions') }}</h5>
                        <small style="color: var(--fin-text-sub);">{{ __('Latest incoming collections and advance payments') }}</small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-custom-fin align-middle">
                        <thead>
                            <tr>
                                <th>{{ __('Invoice') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Method') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th class="text-end">{{ __('Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $payment)
                                <tr>
                                    <td>
                                        @if(!empty($payment->invoice))
                                            <a href="{{ route('invoice.show', encrypt($payment->invoice->id)) }}" class="badge font-monospace" style="background: var(--dd-gold-light); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.3);">
                                                {{ invoicePrefix() . $payment->invoice->invoice_id }}
                                            </a>
                                        @else
                                            <span class="font-monospace" style="color: var(--fin-text-sub);">#INV</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold" style="color: var(--fin-text-title);">
                                            {{ $payment->invoice->customers->name ?? __('Walk-in Client') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge px-2 py-1" style="background: var(--fin-inner-bg); color: var(--fin-text-title); border: 1px solid var(--fin-border);">
                                            <i class="ti ti-credit-card me-1"></i>{{ $payment->payment_type ?: 'Cash' }}
                                        </span>
                                    </td>
                                    <td><span style="color: var(--fin-text-sub);">{{ dateFormat($payment->payment_date ?: $payment->created_at) }}</span></td>
                                    <td class="text-end font-monospace font-weight-bold text-success">
                                        +{{ $currency . number_format($payment->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4" style="color: var(--fin-text-sub);">
                                        <i class="ti ti-inbox fs-2 d-block mb-1"></i>
                                        {{ __('No transactions logged yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@push('script-page')
<script>
    $(document).ready(function() {
        // 1. Monthly Revenue vs Costs Chart (ApexCharts)
        const monthlyOptions = {
            series: [{
                name: "{{ __('Total Collections') }}",
                data: {!! json_encode($monthlyRevenues) !!}
            }, {
                name: "{{ __('Total Operating Costs') }}",
                data: {!! json_encode($monthlyExpenses) !!}
            }],
            chart: {
                type: 'area',
                height: 280,
                toolbar: { show: false },
                fontFamily: 'Hanken Grotesk, sans-serif'
            },
            colors: ['#006A67', '#EF4444'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: { opacityFrom: 0.4, opacityTo: 0.05 }
            },
            xaxis: {
                categories: {!! json_encode($monthlyLabels) !!},
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return "{{ $currency }}" + val.toLocaleString();
                    }
                }
            },
            grid: { borderColor: '#E2E8F0', strokeDashArray: 4 },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "{{ $currency }}" + val.toLocaleString();
                    }
                }
            }
        };
        const monthlyChart = new ApexCharts(document.querySelector("#monthlyFinancialChart"), monthlyOptions);
        monthlyChart.render();

        // 2. Payment Method Donut Chart
        @php
            $pmLabels = $paymentMethods->pluck('payment_type')->map(fn($t) => $t ?: 'Cash')->toArray();
            $pmData = $paymentMethods->pluck('total')->map(fn($v) => (float)$v)->toArray();
            if (empty($pmLabels)) {
                $pmLabels = ['Cash'];
                $pmData = [$totalRevenue];
            }
        @endphp

        const pmOptions = {
            series: {!! json_encode($pmData) !!},
            labels: {!! json_encode($pmLabels) !!},
            chart: {
                type: 'donut',
                height: 260,
                fontFamily: 'Hanken Grotesk, sans-serif'
            },
            colors: ['#006A67', '#10B981', '#6366F1', '#F59E0B', '#EC4899'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: false },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "{{ $currency }}" + val.toLocaleString();
                    }
                }
            }
        };
        const pmChart = new ApexCharts(document.querySelector("#paymentMethodChart"), pmOptions);
        pmChart.render();
    });
</script>
@endpush
@endsection
