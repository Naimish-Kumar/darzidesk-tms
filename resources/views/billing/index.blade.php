@extends('layouts.app')

@section('page-title')
    {{ __('Billing & Subscriptions') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Billing') }}</li>
    </ul>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <!-- Active Subscription Banner -->
    <div class="col-12">
        <div class="card p-4 text-white" style="background: linear-gradient(135deg, #006A67 0%, #0B1C30 100%); border-radius:18px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-white text-dark fw-bold mb-2 text-uppercase" style="font-size:10px; letter-spacing:1px;">Active Plan</span>
                    <h3 class="fw-bold mb-1">{{ $subscription ? $subscription->name : 'Bespoke Atelier Tier' }}</h3>
                    <p class="mb-0 text-white-50" style="font-size:13.5px;">Enjoying unlimited orders, multi-branch coordination, and 3D digital measurement passport integration.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-light fw-bold px-4" style="border-radius:10px; color:#006A67;">
                        {{ __('Upgrade Subscription') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Subscription Plans -->
    <div class="col-lg-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">{{ __('Available Subscription Packages') }}</h5>
            <div class="row g-3">
                @forelse($plans as $plan)
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 {{ ($user->subscription == $plan->id) ? 'border-success bg-light-success' : '' }}" style="border-radius:14px;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0">{{ $plan->name }}</h6>
                                @if($user->subscription == $plan->id)
                                    <span class="badge bg-success">Current</span>
                                @endif
                            </div>
                            <div class="h4 fw-bold font-monospace text-primary mb-2">{{ priceFormat($plan->package_price ?? 0) }} <small class="fs-6 text-muted">/{{ $plan->time_period ?? 'Month' }}</small></div>
                            <ul class="list-unstyled text-muted mb-3" style="font-size:12px;">
                                <li><i class="ti ti-check text-success me-1"></i> {{ $plan->max_user ?? 'Unlimited' }} Staff Accounts</li>
                                <li><i class="ti ti-check text-success me-1"></i> Multi-branch Sync</li>
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-3">No plans available.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Payment History -->
    <div class="col-lg-5">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">{{ __('Billing Transaction History') }}</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:13px;">
                    <thead>
                        <tr class="text-muted">
                            <th>TRANSACTION</th>
                            <th>AMOUNT</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $txn)
                            <tr>
                                <td>
                                    <div class="fw-bold">#{{ $txn->payment_id ?? $txn->id }}</div>
                                    <div class="text-muted" style="font-size:11px;">{{ $txn->created_at ? $txn->created_at->format('M d, Y') : 'N/A' }}</div>
                                </td>
                                <td class="font-monospace fw-bold">{{ priceFormat($txn->amount ?? 0) }}</td>
                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">No recent billing transactions.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
