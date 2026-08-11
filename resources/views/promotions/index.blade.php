@extends('layouts.app')

@section('page-title')
    {{ __('Promotions & Loyalty Rewards') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Promotions') }}</li>
    </ul>
@endsection

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 font-weight-bold mb-1" style="font-weight: 800; color: #006A67;">{{ __('Promotions & Discount Vouchers') }}</h2>
        <p class="text-muted mb-0">{{ __('Create promotional codes, seasonal discounts and VIP customer loyalty offers.') }}</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('coupons.create') }}" class="btn btn-primary" style="background:#006A67; border:none; border-radius:10px; padding:10px 18px; font-weight:700;">
            <i class="ti ti-plus me-1"></i> {{ __('Create New Coupon') }}
        </a>
    </div>
</div>

<!-- Summary Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="text-muted small text-uppercase fw-bold">{{ __('Total Coupons') }}</div>
            <div class="h3 fw-bold mb-0 text-dark">{{ $totalCoupons }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="text-muted small text-uppercase fw-bold">{{ __('Active Campaigns') }}</div>
            <div class="h3 fw-bold mb-0 text-success">{{ $activeCoupons }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="text-muted small text-uppercase fw-bold">{{ __('Expired / Inactive') }}</div>
            <div class="h3 fw-bold mb-0 text-secondary">{{ $expiredCoupons }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm rounded-4">
            <div class="text-muted small text-uppercase fw-bold">{{ __('Total Redemptions') }}</div>
            <div class="h3 fw-bold mb-0 text-primary">{{ $totalRedemptions }}</div>
        </div>
    </div>
</div>

<div class="card p-4 border-0 shadow-sm rounded-4">
    <h5 class="fw-bold mb-3" style="color: #006A67;">{{ __('Active Promotional Coupons') }}</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:13.5px;">
            <thead>
                <tr class="text-muted">
                    <th>COUPON NAME</th>
                    <th>CODE</th>
                    <th>TYPE</th>
                    <th>RATE / DISCOUNT</th>
                    <th>VALID UNTIL</th>
                    <th>USAGE LIMIT</th>
                    <th>REDEMPTIONS</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    @php
                        $isExpired = $coupon->valid_for < date('Y-m-d');
                        $isLimitReached = $coupon->use_limit > 0 && $coupon->usedCoupon() >= $coupon->use_limit;
                        $isActive = $coupon->status == '1' && !$isExpired && !$isLimitReached;
                    @endphp
                    <tr>
                        <td class="fw-bold">{{ $coupon->name }}</td>
                        <td class="font-monospace fw-bold text-primary">{{ $coupon->code }}</td>
                        <td><span class="badge bg-light text-dark fw-bold text-uppercase">{{ $coupon->type }}</span></td>
                        <td class="font-monospace text-success fw-bold">
                            {{ $coupon->type == 'percentage' ? $coupon->rate.'%' : priceFormat($coupon->rate) }}
                        </td>
                        <td class="font-monospace">{{ $coupon->valid_for }}</td>
                        <td class="font-monospace">{{ $coupon->use_limit > 0 ? $coupon->use_limit : 'Unlimited' }}</td>
                        <td class="font-monospace">{{ $coupon->usedCoupon() }} times</td>
                        <td>
                            @if($isActive)
                                <span class="badge bg-success-subtle text-success fw-bold px-2 py-1">{{ __('Active') }}</span>
                            @elseif($isExpired)
                                <span class="badge bg-danger-subtle text-danger fw-bold px-2 py-1">{{ __('Expired') }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary fw-bold px-2 py-1">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="ti ti-tag mb-2" style="font-size:32px; color:#006A67;"></i>
                            <div>No promotional coupons active.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

