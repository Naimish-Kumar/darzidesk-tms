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
                            <h5 class="mb-0">{{ __('Shop Owner Subscription Plans') }}</h5>
                        </div>
                        @if (
                            \Auth::user()->type == 'super admin' &&
                                (subscriptionPaymentSettings()['STRIPE_PAYMENT'] == 'on' ||
                                    subscriptionPaymentSettings()['paypal_payment'] == 'on' ||
                                    subscriptionPaymentSettings()['bank_transfer_payment'] == 'on'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary customModal" data-size="md"
                                    data-url="{{ route('subscriptions.create') }}" data-title="{{ __('Create Package') }}">
                                    <i class="ti ti-circle-plus align-text-bottom me-1"></i> {{ __('Create Package') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Intro Header -->
                    <div class="text-center mb-4">
                        <span class="badge bg-light-primary text-primary fw-bold px-3 py-2 rounded-pill mb-2">
                            <i class="ti ti-scissors me-1"></i> {{ __('TAILOR SHOP & BOUTIQUE PLANS') }}
                        </span>
                        <h3 class="fw-bold mb-2">{{ __('Choose the Best Plan for Your Shop') }}</h3>
                        <p class="text-muted mx-auto" style="max-width: 650px;">
                            {{ __('Empower your tailoring business with high-precision order management, seamster limit controls, customer measurement tracking, and real-time activity logging.') }}
                        </p>
                    </div>

                    <!-- 3 Plans Grid -->
                    <div class="row g-4 mb-5">
                        @php
                            $currentPlan = $subscriptions->where('id', \Auth::user()->subscription)->first();
                            $currentPlanAmount = $currentPlan ? $currentPlan->package_amount : 0;
                        @endphp

                        @foreach ($subscriptions as $index => $subscription)
                            @php
                                $isCurrent = \Auth::user()->subscription == $subscription->id;
                                $isPopular = str_contains(strtolower($subscription->title), 'pro') || str_contains(strtolower($subscription->title), 'boutique') || ($index === 1 && count($subscriptions) >= 3);
                            @endphp

                            <div class="col-xl-4 col-md-6">
                                <div class="card shadow-sm border h-100 {{ $isCurrent ? 'border-primary border-2' : ($isPopular ? 'border-primary' : '') }}" style="border-radius: 16px; overflow: hidden; transition: all 0.3s ease;">
                                    @if ($isCurrent)
                                        <div class="bg-primary text-white text-center py-2 fw-bold small text-uppercase" style="letter-spacing: 1px;">
                                            <i class="ti ti-circle-check me-1"></i> {{ __('Current Plan') }}
                                        </div>
                                    @elseif ($isPopular)
                                        <div class="bg-primary text-white text-center py-2 fw-bold small text-uppercase" style="letter-spacing: 1px;">
                                            <i class="ti ti-flame me-1"></i> {{ __('Most Popular') }}
                                        </div>
                                    @endif

                                    <div class="card-body p-4 d-flex flex-column">
                                        <!-- Header & Subtitle -->
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <h4 class="fw-bold mb-1">{{ $subscription->title }}</h4>
                                                <p class="text-muted small mb-0">
                                                    @if($index == 0)
                                                        {{ __('Ideal for solo tailors & startup boutiques.') }}
                                                    @elseif($isPopular)
                                                        {{ __('Perfect for growing tailor shops & busy boutiques.') }}
                                                    @else
                                                        {{ __('For high-volume ateliers & multi-branch shops.') }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="avtar avtar-lg {{ $isPopular ? 'bg-primary text-white' : 'bg-light-primary text-primary' }} rounded-3">
                                                @if($index == 0)
                                                    <i class="ti ti-scissors f-22"></i>
                                                @elseif($isPopular)
                                                    <i class="ti ti-shirt f-22"></i>
                                                @else
                                                    <i class="ti ti-crown f-22"></i>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Price Tag -->
                                        <div class="mb-4">
                                            <h2 class="fw-bold mb-0 text-primary">{{ dynamicPrice($subscription->package_amount) }}</h2>
                                            @if(session('geo_location') && session('geo_location')['currency'] != (subscriptionPaymentSettings()['CURRENCY'] ?? 'INR'))
                                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">(≈ {{ priceFormat($subscription->package_amount) }})</small>
                                            @endif
                                            <span class="text-muted small">/ {{ ucfirst($subscription->interval) }}</span>
                                        </div>

                                        <!-- Features List -->
                                        <ul class="list-unstyled mb-4 flex-grow-1">
                                            <li class="mb-3 d-flex align-items-center">
                                                <div class="bg-light-primary avtar avtar-xs me-2 rounded-circle">
                                                    <i class="ti ti-users text-primary f-14"></i>
                                                </div>
                                                <span class="text-muted">
                                                    <strong class="text-dark">{{ $subscription->user_limit >= 1000 ? __('Unlimited') : $subscription->user_limit }}</strong> {{ __('User / Staff Limit') }}
                                                </span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center">
                                                <div class="bg-light-primary avtar avtar-xs me-2 rounded-circle">
                                                    <i class="ti ti-user-check text-primary f-14"></i>
                                                </div>
                                                <span class="text-muted">
                                                    <strong class="text-dark">{{ $subscription->customer_limit >= 10000 ? __('Unlimited') : number_format($subscription->customer_limit) }}</strong> {{ __('Customer Limit') }}
                                                </span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center">
                                                <div class="bg-light-primary avtar avtar-xs me-2 rounded-circle">
                                                    <i class="ti ti-scissors text-primary f-14"></i>
                                                </div>
                                                <span class="text-muted">
                                                    <strong class="text-dark">{{ $subscription->cloth_type_limit >= 500 ? __('Unlimited') : $subscription->cloth_type_limit }}</strong> {{ __('Cloth Type Limit') }}
                                                </span>
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

                                        <!-- Action Buttons -->
                                        <div class="mt-auto">
                                            @if ($isCurrent && $subscription->package_amount > 0)
                                                <div class="alert alert-success border-0 mb-0 py-2 small d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-calendar-event me-2 f-18"></i>
                                                    {{ \Auth::user()->subscription_expire_date ? __('Expires on') . ' ' . dateFormat(\Auth::user()->subscription_expire_date) : __('Unlimited access') }}
                                                </div>
                                            @elseif ($isCurrent && $subscription->package_amount == 0)
                                                <div class="alert alert-primary border-0 mb-0 py-2 small d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-check me-2 f-18"></i> {{ __('Current Active Plan') }}
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

                    <!-- Shop Owner Highlights -->
                    <div class="pt-4 border-top">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold mb-1">{{ __('Why Top Boutiques & Tailors Choose DarziDesk') }}</h4>
                            <p class="text-muted small">{{ __('Designed specifically for custom tailoring, garment measurements, and seamster management.') }}</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="card border shadow-none text-center h-100 mb-0">
                                    <div class="card-body p-4">
                                        <div class="avtar avtar-lg bg-light-primary text-primary rounded-circle mx-auto mb-3">
                                            <i class="ti ti-ruler-measure f-22"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">{{ __('Measurement Profiles') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('Store detailed body measurements per customer for suits, dresses, and traditional attire.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card border shadow-none text-center h-100 mb-0">
                                    <div class="card-body p-4">
                                        <div class="avtar avtar-lg bg-light-success text-success rounded-circle mx-auto mb-3">
                                            <i class="ti ti-needle f-22"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">{{ __('Seamster Assignments') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('Assign specific orders to master tailors and track completion deadlines smoothly.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card border shadow-none text-center h-100 mb-0">
                                    <div class="card-body p-4">
                                        <div class="avtar avtar-lg bg-light-warning text-warning rounded-circle mx-auto mb-3">
                                            <i class="ti ti-tags f-22"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">{{ __('Cloth Type Catalog') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('Manage unlimited fabric types, patterns, and stitching style categories.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card border shadow-none text-center h-100 mb-0">
                                    <div class="card-body p-4">
                                        <div class="avtar avtar-lg bg-light-info text-info rounded-circle mx-auto mb-3">
                                            <i class="ti ti-device-mobile-message f-22"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">{{ __('Fitting & Delivery Alerts') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('Keep clients informed about trial fitting dates and ready-for-pickup notifications.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="pt-5">
                        <div class="card border shadow-none mb-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="avtar avtar-md bg-light-primary text-primary rounded-circle me-3">
                                        <i class="ti ti-help-circle f-20"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ __('Frequently Asked Questions') }}</h5>
                                        <p class="text-muted small mb-0">{{ __('Have questions about our tailor shop subscription packages?') }}</p>
                                    </div>
                                </div>

                                <div class="accordion accordion-flush" id="subscriptionFaq">
                                    <div class="accordion-item border-bottom">
                                        <h2 class="accordion-header" id="faqOne">
                                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                                {{ __('Can I upgrade my plan as my tailoring shop grows?') }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#subscriptionFaq">
                                            <div class="accordion-body text-muted small">
                                                {{ __('Yes, absolutely! You can upgrade from Starter Tailor to Boutique Pro or Master Studio at any time. Your limits will expand immediately so your seamsters and front-desk staff won’t miss a beat.') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item border-bottom">
                                        <h2 class="accordion-header" id="faqTwo">
                                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                                {{ __('What counts towards the User Limit?') }}
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#subscriptionFaq">
                                            <div class="accordion-body text-muted small">
                                                {{ __('User limit includes staff members such as shop owners, master cutters, tailors, and cashier/billing managers who have login access to your shop’s TMS dashboard.') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faqThree">
                                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                {{ __('Are coupons and discounts supported during checkout?') }}
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#subscriptionFaq">
                                            <div class="accordion-body text-muted small">
                                                {{ __('Yes! If you have a valid coupon code provided by DarziDesk administration, you can apply it at checkout to enjoy special discounts on monthly or annual subscriptions.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
