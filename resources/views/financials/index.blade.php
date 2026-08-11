@extends('layouts.app')

@section('page-title')
    {{ __('Financial Analytics & P&L') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Financials') }}</li>
    </ul>
@endsection

@section('content')
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; margin-bottom: 24px; }
    .kpi-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
    .kpi-lbl { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: #64748B; margin-bottom: 4px; text-transform: uppercase; }
    .kpi-val { font-size: 28px; font-weight: 800; color: #0F172A; }
</style>

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 font-weight-bold mb-1" style="font-weight: 800;">{{ __('Financial Dashboard & P&L Analysis') }}</h2>
        <p class="text-muted mb-0">{{ __('Track revenue, operational expenses, profit margins and cash flow across all locations.') }}</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('financials.analytics') }}" class="btn btn-primary" style="background:#006A67; border:none; border-radius:10px; padding:10px 18px; font-weight:700;">
            <i class="ti ti-chart-bar me-1"></i> {{ __('View Detailed Reports') }}
        </a>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('TOTAL REVENUE GENERATED') }}</div>
        <div class="kpi-val text-success">{{ priceFormat($totalRevenue) }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">From bespoke orders</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('OPERATIONAL EXPENSES') }}</div>
        <div class="kpi-val text-danger">{{ priceFormat($totalExpenses) }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Materials, rent & overheads</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('NET OPERATING PROFIT') }}</div>
        <div class="kpi-val text-primary">{{ priceFormat($netProfit) }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Net earnings after expenses</div>
    </div>
</div>

<div class="card p-4">
    <h5 class="fw-bold mb-3">{{ __('Recent Financial Transactions') }}</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:13.5px;">
            <thead>
                <tr class="text-muted">
                    <th>ORDER / INVOICE ID</th>
                    <th>CLIENT NAME</th>
                    <th>AMOUNT</th>
                    <th>STATUS</th>
                    <th>DATE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders->take(10) as $ord)
                    <tr>
                        <td class="font-monospace fw-bold">#{{ $ord->order_id ?? 'ORD-'.$ord->id }}</td>
                        <td class="fw-bold">{{ $ord->customer ? $ord->customer->name : 'Walk-in Client' }}</td>
                        <td class="font-monospace fw-bold text-success">{{ priceFormat($ord->total_amount ?? 0) }}</td>
                        <td><span class="badge bg-success">Received</span></td>
                        <td class="text-muted font-monospace">{{ $ord->created_at ? $ord->created_at->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No transactions recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
