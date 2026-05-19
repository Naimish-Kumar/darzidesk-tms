@extends('layouts.app')
@section('page-title')
    {{ __('Packages') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Packages') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Pricing Packages List') }}</h5>
                        </div>
                        @if (
                            \Auth::user()->type == 'super admin' &&
                                (subscriptionPaymentSettings()['STRIPE_PAYMENT'] == 'on' ||
                                    subscriptionPaymentSettings()['paypal_payment'] == 'on' ||
                                    subscriptionPaymentSettings()['bank_transfer_payment'] == 'on'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="md"
                                    data-url="{{ route('subscriptions.create') }}" data-title="{{ __('Create Package') }}">
                                    <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Package') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @php
                            $currentPlan = $subscriptions->where('id', \Auth::user()->subscription)->first();
                            $currentPlanAmount = $currentPlan ? $currentPlan->package_amount : 0;
                        @endphp
                        @foreach ($subscriptions as $subscription)
                            <div class="col-xl-4 col-md-6">
                                <div class="card pricing-card shadow-sm border-0 h-100 {{ \Auth::user()->subscription == $subscription->id ? 'border-primary border-2' : '' }}" style="border-radius: 16px; overflow: hidden; transition: all 0.3s ease;">
                                    @if (\Auth::user()->subscription == $subscription->id)
                                        <div class="bg-primary text-white text-center py-2 fw-bold small text-uppercase letter-spacing-1">
                                            {{ __('Current Plan') }}
                                        </div>
                                    @endif
                                    <div class="card-body p-4 d-flex flex-column">
                                        <div class="mb-4">
                                            <h4 class="fw-bold mb-1">{{ $subscription->title }}</h4>
                                            <p class="text-muted small mb-0">{{ __('Perfect for') }} {{ strtolower($subscription->title) }} {{ __('needs') }}</p>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <h2 class="fw-bold mb-0 text-primary">{{ dynamicPrice($subscription->package_amount) }}</h2>
                                            @if(session('geo_location') && session('geo_location')['currency'] != (subscriptionPaymentSettings()['CURRENCY'] ?? 'INR'))
                                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">(≈ {{ priceFormat($subscription->package_amount) }})</small>
                                            @endif
                                            <span class="text-muted small">/ {{ ucfirst($subscription->interval) }}</span>
                                        </div>

                                        <ul class="list-unstyled mb-4 flex-grow-1">
                                            <li class="mb-3 d-flex align-items-center">
                                                <div class="bg-light-primary avtar avtar-xs me-2 rounded-circle">
                                                    <i class="ti ti-users text-primary f-14"></i>
                                                </div>
                                                <span class="text-muted">{{ $subscription->user_limit }} {{ __('User Limit') }}</span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center">
                                                <div class="bg-light-primary avtar avtar-xs me-2 rounded-circle">
                                                    <i class="ti ti-user-check text-primary f-14"></i>
                                                </div>
                                                <span class="text-muted">{{ $subscription->customer_limit }} {{ __('Customer Limit') }}</span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center">
                                                <div class="bg-light-primary avtar avtar-xs me-2 rounded-circle">
                                                    <i class="ti ti-scissors text-primary f-14"></i>
                                                </div>
                                                <span class="text-muted">{{ $subscription->cloth_type_limit }} {{ __('Cloth Type Limit') }}</span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center">
                                                @if ($subscription->enabled_logged_history)
                                                    <div class="bg-light-success avtar avtar-xs me-2 rounded-circle">
                                                        <i class="ti ti-check text-success f-14"></i>
                                                    </div>
                                                    <span class="text-muted">{{ __('Logged History Enabled') }}</span>
                                                @else
                                                    <div class="bg-light-danger avtar avtar-xs me-2 rounded-circle">
                                                        <i class="ti ti-x text-danger f-14"></i>
                                                    </div>
                                                    <span class="text-muted text-decoration-line-through">{{ __('Logged History') }}</span>
                                                @endif
                                            </li>
                                            <li class="mb-0 d-flex align-items-center">
                                                @if ($subscription->couponCheck() > 0)
                                                    <div class="bg-light-success avtar avtar-xs me-2 rounded-circle">
                                                        <i class="ti ti-ticket text-success f-14"></i>
                                                    </div>
                                                    <span class="text-muted">{{ __('Coupons Applicable') }}</span>
                                                @else
                                                    <div class="bg-light-danger avtar avtar-xs me-2 rounded-circle">
                                                        <i class="ti ti-x text-danger f-14"></i>
                                                    </div>
                                                    <span class="text-muted text-decoration-line-through">{{ __('Coupons Applicable') }}</span>
                                                @endif
                                            </li>
                                        </ul>

                                        <div class="mt-auto">
                                            @if (\Auth::user()->subscription == $subscription->id && $subscription->package_amount > 0)
                                                <div class="alert alert-success border-0 mb-0 py-2 small d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-calendar-event me-2 f-18"></i>
                                                    {{ \Auth::user()->subscription_expire_date ? __('Expires on') . ' ' . dateFormat(\Auth::user()->subscription_expire_date) : __('Unlimited access') }}
                                                </div>
                                            @else
                                                @if (\Auth::user()->type == 'owner' && \Auth::user()->subscription != $subscription->id)
                                                    @if ($subscription->package_amount > $currentPlanAmount)
                                                        <a href="{{ route('subscriptions.show', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                                            class="btn btn-primary w-100 shadow-sm py-2 fw-bold">
                                                            <i class="ti ti-shopping-cart me-2"></i>{{ __('Upgrade Now') }}
                                                        </a>
                                                    @else
                                                        <button class="btn btn-light w-100 py-2 fw-bold" disabled>
                                                            <i class="ti ti-arrow-down me-2"></i>{{ __('Current plan is higher') }}
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif

                                            @if(\Auth::user()->type == 'super admin')
                                                <div class="d-flex gap-2 mt-3 justify-content-center border-top pt-3">
                                                    <a class="btn btn-sm btn-light-secondary customModal"
                                                        data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                        href="#"
                                                        data-url="{{ route('subscriptions.edit', $subscription->id) }}"
                                                        data-title="{{ __('Edit Package') }}"> <i class="ti ti-edit f-18"></i></a>
                                                    
                                                    @if ($subscription->id != 1)
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['subscriptions.destroy', encrypt($subscription->id)], 'class' => 'd-inline']) !!}
                                                            <button type="button" class="btn btn-sm btn-light-danger confirm_dialog" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </button>
                                                        {!! Form::close() !!}
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
