@extends('layouts.app')
@section('page-title')
    {{ __('Packages') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Packages') }}</li>
@endsection

@push('css-page')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dd-brand-teal: #00796B;
            --dd-brand-teal-hover: #005A50;
            --dd-brand-teal-light: #E6F4F1;
            --dd-brand-teal-border: #B2E0D8;
            --jasper-bg: #F8FAFC;
            --jasper-card-bg: #FFFFFF;
            --jasper-card-subtle: #F8FAFC;
            --jasper-border: #E2E8F0;
            --jasper-text-dark: #0F172A;
            --jasper-text-muted: #64748B;
            --jasper-green: #00796B;
            --jasper-green-bg: #E6F4F1;
        }

        .dd-pricing-wrapper {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #F3F4F6;
            padding: 24px;
            border-radius: 16px;
        }

        .dd-pricing-box {
            background: var(--jasper-card-bg);
            border: 1px solid var(--jasper-border);
            border-radius: 16px;
            padding: 32px 36px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        /* ─── Top Header Bar ─── */
        .dd-top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--jasper-border);
        }
        .dd-top-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--jasper-text-dark);
            margin: 0;
            letter-spacing: -0.3px;
        }
        .dd-signout-btn {
            font-size: 13px;
            font-weight: 600;
            color: var(--jasper-text-dark);
            background: #FFFFFF;
            border: 1px solid var(--jasper-border);
            padding: 7px 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .dd-signout-btn:hover {
            background: #F8FAFC;
            color: var(--jasper-text-dark);
            text-decoration: none;
        }

        /* ─── Billing Sub-Bar ─── */
        .dd-billing-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 24px;
        }
        .dd-billing-save {
            font-size: 13px;
            font-weight: 600;
            color: var(--dd-brand-teal);
        }
        .dd-billing-select {
            font-size: 13px;
            font-weight: 600;
            color: var(--jasper-text-dark);
            background: #FFFFFF;
            border: 1px solid var(--jasper-border);
            border-radius: 8px;
            padding: 6px 14px;
            cursor: pointer;
            outline: none;
            appearance: none;
            padding-right: 28px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2300796B'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 14px;
        }

        /* ─── Cards Grid ─── */
        .dd-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            align-items: stretch;
        }
        @media (max-width: 992px) {
            .dd-cards-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .dd-cards-grid { grid-template-columns: 1fr; }
            .dd-pricing-box { padding: 20px; }
        }

        /* ─── Pricing Card ─── */
        .dd-card-item {
            background: var(--jasper-card-subtle);
            border: 1px solid var(--jasper-border);
            border-radius: 14px;
            padding: 28px 24px;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .dd-card-item:hover {
            border-color: var(--dd-brand-teal-border);
            box-shadow: 0 4px 16px rgba(0, 121, 107, 0.08);
        }
        .dd-card-item.dd-card-featured {
            border-color: var(--dd-brand-teal);
            box-shadow: 0 2px 14px rgba(0, 121, 107, 0.12);
        }

        /* Title & Badge */
        .dd-card-title-row {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        .dd-card-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--jasper-text-dark);
            margin: 0;
            letter-spacing: -0.3px;
        }
        .dd-badge-recommended {
            font-size: 11px;
            font-weight: 600;
            background: var(--dd-brand-teal-light);
            color: var(--dd-brand-teal);
            border: 1px solid var(--dd-brand-teal-border);
            padding: 2px 8px;
            border-radius: 6px;
            margin-left: 8px;
        }
        .dd-badge-current {
            font-size: 11px;
            font-weight: 700;
            background: #FEF3C7;
            color: #D97706;
            border: 1px solid #FDE68A;
            padding: 2px 8px;
            border-radius: 6px;
            margin-left: 8px;
        }

        .dd-card-desc {
            font-size: 13px;
            color: var(--jasper-text-muted);
            line-height: 1.55;
            margin-bottom: 20px;
            min-height: 40px;
        }

        /* Price */
        .dd-card-price-row {
            display: flex;
            align-items: baseline;
            gap: 4px;
            margin-bottom: 4px;
        }
        .dd-price-val {
            font-size: 32px;
            font-weight: 800;
            color: var(--jasper-text-dark);
            line-height: 1;
            letter-spacing: -0.8px;
        }
        .dd-price-unit {
            font-size: 13.5px;
            color: var(--jasper-text-muted);
            font-weight: 500;
        }
        .dd-badge-save {
            font-size: 11px;
            font-weight: 700;
            background: var(--dd-brand-teal-light);
            color: var(--dd-brand-teal);
            border: 1px solid var(--dd-brand-teal-border);
            padding: 2px 7px;
            border-radius: 4px;
            margin-left: 6px;
        }
        .dd-price-subtext {
            font-size: 12px;
            color: var(--jasper-text-muted);
            margin-bottom: 24px;
        }

        /* CTA Button */
        .dd-cta-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 11px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s ease;
            margin-bottom: 28px;
            border: 1px solid transparent;
        }
        .dd-cta-btn-outline {
            background: #FFFFFF;
            color: var(--jasper-text-dark);
            border-color: #D1D5DB;
        }
        .dd-cta-btn-outline:hover {
            background: var(--dd-brand-teal-light);
            border-color: var(--dd-brand-teal);
            color: var(--dd-brand-teal);
            text-decoration: none;
        }
        .dd-cta-btn-solid {
            background: var(--dd-brand-teal);
            color: #FFFFFF;
            border-color: var(--dd-brand-teal);
        }
        .dd-cta-btn-solid:hover {
            background: var(--dd-brand-teal-hover);
            color: #FFFFFF;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 121, 107, 0.25);
        }
        .dd-cta-btn-active {
            background: #E2E8F0;
            color: #475569;
            cursor: default;
        }

        /* Features List */
        .dd-features-header {
            font-size: 13px;
            font-weight: 700;
            color: var(--jasper-text-dark);
            margin-bottom: 14px;
        }
        .dd-features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }
        .dd-features-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 6px 0;
            font-size: 13px;
            color: var(--jasper-text-dark);
            line-height: 1.5;
        }
        .dd-check-icon {
            color: var(--dd-brand-teal);
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .dd-cross-icon {
            color: #94A3B8;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .dd-feat-disabled {
            text-decoration: line-through;
            color: #94A3B8;
        }

        /* Admin Action Buttons */
        .dd-admin-bar {
            display: flex;
            gap: 8px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--jasper-border);
            justify-content: flex-end;
        }
        .dd-admin-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--jasper-border);
            background: #FFFFFF;
            color: var(--jasper-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
        }
        .dd-admin-icon-btn:hover {
            color: var(--dd-brand-teal);
            border-color: var(--dd-brand-teal);
        }
    </style>
@endpush

@section('content')
    <div class="dd-pricing-wrapper">
        <div class="dd-pricing-box">
            {{-- Top Header --}}
            <div class="dd-top-header">
                <h2>
                    @if (\Auth::user()->type == 'super admin')
                        {{ __('Manage Subscription Packages') }}
                    @else
                        {{ __('Select a plan to start your free 1-month trial') }}
                    @endif
                </h2>
                @if (\Auth::user()->type == 'super admin')
                    <a href="#" class="dd-signout-btn customModal" data-size="md"
                        data-url="{{ route('subscriptions.create') }}" data-title="{{ __('Create Package') }}">
                        <i class="ti ti-circle-plus me-1"></i> {{ __('Create Package') }}
                    </a>
                @endif
            </div>

            {{-- Billing Cycle Selector --}}
            <div class="dd-billing-bar">
                <span class="dd-billing-save">{{ __('Save up to 20% when billed annually') }}</span>
                <select class="dd-billing-select">
                    <option value="annually">{{ __('Annually') }}</option>
                    <option value="monthly">{{ __('Monthly') }}</option>
                </select>
            </div>

            {{-- Plans Loop --}}
            @php
                $currentPlan = $subscriptions->where('id', \Auth::user()->subscription)->first();
                $currentPlanAmount = $currentPlan ? $currentPlan->package_amount : 0;
                $planDescs = [
                    __('Powerful AI features to create & improve your content everywhere you work online.'),
                    __('Advanced AI features to create content for multiple brands & collaborate on campaigns.'),
                    __('Personalized AI features with additional control, security, team training & tech support.'),
                    __('Enterprise-grade tailored features for high-volume boutiques and teams.'),
                ];
                $planIncludesTitles = [
                    __('Includes:'),
                    __('Everything in Creator, plus:'),
                    __('Everything in Pro, plus:'),
                    __('Everything in Business, plus:'),
                ];
                $discountPills = ['SAVE 20%', 'SAVE 14%', 'SAVE 10%'];
            @endphp

            <div class="dd-cards-grid">
                @foreach ($subscriptions as $index => $subscription)
                    @php
                        $isCurrent = \Auth::user()->subscription == $subscription->id;
                        $isPopular = str_contains(strtolower($subscription->title), 'pro') ||
                                     str_contains(strtolower($subscription->title), 'boutique') ||
                                     ($index === 1 && count($subscriptions) >= 3);
                        $isEnterprise = str_contains(strtolower($subscription->title), 'business') ||
                                        str_contains(strtolower($subscription->title), 'enterprise') ||
                                        $index >= 2;
                        $cardClass = $isPopular ? 'dd-card-featured' : '';
                        $desc = $planDescs[$index] ?? $planDescs[0];
                        $includesTitle = $planIncludesTitles[$index] ?? __('Includes:');
                        $discount = $discountPills[$index] ?? 'SAVE 15%';
                    @endphp

                    <div class="dd-card-item {{ $cardClass }}">
                        {{-- Title Row --}}
                        <div class="dd-card-title-row">
                            <h3 class="dd-card-title">{{ $subscription->title }}</h3>
                            @if ($isPopular)
                                <span class="dd-badge-recommended">{{ __('Recommended') }}</span>
                            @endif
                            @if ($isCurrent)
                                <span class="dd-badge-current">{{ __('Current Plan') }}</span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <p class="dd-card-desc">{{ $desc }}</p>

                        {{-- Price Section --}}
                        @if ($isEnterprise && $subscription->package_amount == 0 && $index >= 2)
                            <div class="dd-card-price-row mb-1">
                                <span style="font-size: 20px; margin-right: 6px;">📦</span>
                                <span class="dd-price-val" style="font-size: 22px;">{{ __('Custom pricing') }}</span>
                            </div>
                            <div class="dd-price-subtext">{{ __('Contact our team for personalized plans') }}</div>
                        @else
                            <div class="dd-card-price-row">
                                <span class="dd-price-val">{{ dynamicPrice($subscription->package_amount) }}</span>
                                <span class="dd-price-unit">/ {{ $subscription->interval == 'year' ? 'year' : 'month' }}</span>
                                @if($subscription->package_amount > 0)
                                    <span class="dd-badge-save">{{ $discount }}</span>
                                @endif
                            </div>
                            <div class="dd-price-subtext">
                                {{ __('Billed annually after 1-month free trial') }}
                            </div>
                        @endif

                        {{-- CTA Button --}}
                        <div>
                            @if (\Auth::user()->type == 'super admin')
                                <div class="d-flex gap-2">
                                    <a href="#" class="dd-cta-btn dd-cta-btn-solid customModal flex-grow-1"
                                        data-url="{{ route('subscriptions.edit', $subscription->id) }}"
                                        data-title="{{ __('Edit Package') }}">
                                        <i class="ti ti-edit me-1"></i> {{ __('Edit Package') }}
                                    </a>
                                    @if ($subscription->id != 1)
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['subscriptions.destroy', encrypt($subscription->id)], 'class' => 'd-inline']) !!}
                                            <button type="button" class="dd-cta-btn dd-cta-btn-outline confirm_dialog px-3" data-bs-toggle="tooltip" title="{{ __('Delete Package') }}">
                                                <i class="ti ti-trash" style="color: #EF4444;"></i>
                                            </button>
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            @elseif ($isCurrent)
                                <div class="dd-cta-btn dd-cta-btn-active">
                                    <i class="ti ti-check me-1"></i> {{ __('Current active plan') }}
                                </div>
                            @elseif ($isEnterprise && $subscription->package_amount == 0 && $index >= 2)
                                <a href="mailto:support@darzidesk.com" class="dd-cta-btn dd-cta-btn-outline">
                                    {{ __('Contact sales') }}
                                </a>
                            @else
                                @if (\Auth::user()->type == 'owner' && \Auth::user()->subscription != $subscription->id)
                                    @if ($subscription->package_amount > $currentPlanAmount)
                                        <a href="{{ route('subscriptions.show', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                            class="dd-cta-btn {{ $isPopular ? 'dd-cta-btn-solid' : 'dd-cta-btn-outline' }}">
                                            {{ __('Select plan') }}
                                        </a>
                                    @else
                                        <div class="dd-cta-btn dd-cta-btn-outline" style="opacity: 0.6; cursor: not-allowed;">
                                            {{ __('Included in your current plan') }}
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('subscriptions.show', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                        class="dd-cta-btn {{ $isPopular ? 'dd-cta-btn-solid' : 'dd-cta-btn-outline' }}">
                                        {{ __('Select plan') }}
                                    </a>
                                @endif
                            @endif
                        </div>

                        {{-- Features List --}}
                        <div class="dd-features-header">{{ $includesTitle }}</div>
                        <ul class="dd-features-list">
                            <li>
                                <span class="dd-check-icon">✓</span>
                                <span>{{ $subscription->user_limit >= 1000 ? __('Unlimited') : $subscription->user_limit }} {{ __('user seat') }}{{ $subscription->user_limit > 1 ? 's' : '' }}</span>
                            </li>
                            <li>
                                <span class="dd-check-icon">✓</span>
                                <span>{{ $subscription->customer_limit >= 10000 ? __('Unlimited') : number_format($subscription->customer_limit) }} {{ __('Customer profiles') }}</span>
                            </li>
                            <li>
                                <span class="dd-check-icon">✓</span>
                                <span>{{ $subscription->cloth_type_limit >= 500 ? __('Unlimited') : $subscription->cloth_type_limit }} {{ __('Cloth types & patterns') }}</span>
                            </li>
                            <li>
                                @if ($subscription->enabled_logged_history)
                                    <span class="dd-check-icon">✓</span>
                                    <span>{{ __('Access to order history & activity logs') }}</span>
                                @else
                                    <span class="dd-cross-icon">✕</span>
                                    <span class="dd-feat-disabled">{{ __('Order history & activity logs') }}</span>
                                @endif
                            </li>
                            <li>
                                @if ($subscription->couponCheck() > 0)
                                    <span class="dd-check-icon">✓</span>
                                    <span>{{ __('Discount coupons & promotional codes') }}</span>
                                @else
                                    <span class="dd-cross-icon">✕</span>
                                    <span class="dd-feat-disabled">{{ __('Discount coupons') }}</span>
                                @endif
                            </li>
                            @if ($isEnterprise || $index >= 2)
                                <li>
                                    <span class="dd-check-icon">✓</span>
                                    <span>{{ __('Dedicated account manager & priority support') }}</span>
                                </li>
                            @endif
                        </ul>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
