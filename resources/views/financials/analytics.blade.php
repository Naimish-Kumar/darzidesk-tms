@extends('layouts.app')
@section('page-title')
    {{ __('Financial & Profit Analytics') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active"><a href="#">{{ __('Financial Analytics') }}</a></li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <!-- Metric Cards -->
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="card shadow-sm border-start border-4 border-success">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-semibold mb-1 small">{{ __('Total Collections') }}</h6>
                    <h3 class="fw-bold mb-0 text-success">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="card shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-semibold mb-1 small">{{ __('Outstanding Collections') }}</h6>
                    <h3 class="fw-bold mb-0 text-warning">${{ number_format($outstandingAmount, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="card shadow-sm border-start border-4 border-danger">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-semibold mb-1 small">{{ __('Operating Expenses') }}</h6>
                    <h3 class="fw-bold mb-0 text-danger">${{ number_format($operatingExpenses, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12 mb-3">
            <div class="card shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fw-semibold mb-1 small">{{ __('Tailor Labor Expenses') }}</h6>
                    <h3 class="fw-bold mb-0 text-primary">${{ number_format($tailorPayouts, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-chart-bar text-primary me-2"></i>Expense Breakdown</h5>
                </div>
                <div class="card-body">
                    @forelse($expenseCategories as $cat)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold text-dark">{{ $cat->category->name ?? 'General Expense' }}</span>
                                <span class="text-muted">${{ number_format($cat->total, 2) }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php
                                    $pct = $operatingExpenses > 0 ? ($cat->total / $operatingExpenses) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $pct }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="ti ti-receipt-off fs-1 d-block mb-2"></i>
                            No expenses logged.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12 mb-4">
            <div class="card shadow-sm h-100 bg-light">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-box text-success me-2"></i>Asset & Margin Value</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h1 class="display-5 fw-bold text-dark mb-1">${{ number_format($stockValuation, 2) }}</h1>
                    <span class="text-muted d-block fs-6 mb-3">Fabric & Trim Stock Inventory Value</span>
                    <div class="alert alert-success py-2 mb-0">
                        <i class="ti ti-check-circle me-1"></i> Fabric asset values automatically update with restock activities.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
