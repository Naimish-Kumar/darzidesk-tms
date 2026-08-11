@extends('layouts.app')

@section('page-title')
    {{ __('Financial & Profit Analytics') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Financial Analytics') }}</li>
    </ul>
@endsection

@push('css-page')
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dd-teal: #00796B;
            --dd-teal-light: #E0F2F1;
            --dd-teal-dark: #004D40;
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

        .dd-fin-card {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            height: 100%;
        }
        .dd-fin-lbl {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            color: var(--dd-text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .dd-fin-val {
            font-size: 24px;
            font-weight: 800;
            color: var(--dd-text);
        }
    </style>
@endpush

@section('content')
    @php
        $currency = getSettingsValByName('CURRENCY_SYMBOL');
    @endphp

    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="h3 font-weight-bold mb-1" style="font-weight: 800; color: #0F172A;">{{ __('Financial & Revenue Intelligence') }}</h2>
            <p class="text-muted mb-0">{{ __('Comprehensive breakdown of income, operating costs, payouts and material assets.') }}</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Metric Cards -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="dd-fin-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="p-2 rounded bg-light-success text-success">
                        <i class="ti ti-wallet fs-4"></i>
                    </div>
                </div>
                <div class="dd-fin-lbl">{{ __('Total Collections') }}</div>
                <div class="dd-fin-val text-success">{{ $currency . number_format($totalRevenue, 2) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="dd-fin-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="p-2 rounded bg-light-warning text-warning">
                        <i class="ti ti-clock fs-4"></i>
                    </div>
                </div>
                <div class="dd-fin-lbl">{{ __('Outstanding Collections') }}</div>
                <div class="dd-fin-val text-warning">{{ $currency . number_format($outstandingAmount, 2) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="dd-fin-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="p-2 rounded bg-light-danger text-danger">
                        <i class="ti ti-receipt-off fs-4"></i>
                    </div>
                </div>
                <div class="dd-fin-lbl">{{ __('Operating Expenses') }}</div>
                <div class="dd-fin-val text-danger">{{ $currency . number_format($operatingExpenses, 2) }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="dd-fin-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="p-2 rounded bg-light-primary text-primary">
                        <i class="ti ti-cut fs-4"></i>
                    </div>
                </div>
                <div class="dd-fin-lbl">{{ __('Tailor Labor Expenses') }}</div>
                <div class="dd-fin-val text-primary">{{ $currency . number_format($tailorPayouts, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6 col-12">
            <div class="dd-fin-card">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-chart-bar text-primary me-2"></i>{{ __('Expense Breakdown') }}</h5>
                </div>
                <div>
                    @forelse($expenseCategories as $cat)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold text-dark">{{ $cat->category->name ?? 'General Expense' }}</span>
                                <span class="text-muted font-monospace">{{ $currency . number_format($cat->total, 2) }}</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 4px;">
                                @php
                                    $pct = $operatingExpenses > 0 ? ($cat->total / $operatingExpenses) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $pct }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="ti ti-receipt-off fs-1 d-block mb-2"></i>
                            {{ __('No expenses logged.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="dd-fin-card">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-box text-success me-2"></i>{{ __('Asset & Fabric Valuation') }}</h5>
                </div>
                <div class="p-4 text-center rounded" style="background: var(--dd-teal-light);">
                    <div class="dd-fin-lbl" style="color: var(--dd-teal);">{{ __('FABRIC & TRIM STOCK VALUATION') }}</div>
                    <div class="display-6 fw-bold" style="color: var(--dd-teal-dark);">{{ $currency . number_format($stockValuation ?? 0, 2) }}</div>
                    <p class="text-muted small mb-0 mt-2">{{ __('Total inventory stock value across all active workshops and branches') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
