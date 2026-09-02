@extends('layouts.app')

@section('page-title')
    {{ __('My Measurements') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('My Measurements') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --dd-gold: #D9A441;
            --dd-gold-hover: #F4C861;
            --dd-gold-light: rgba(217, 164, 65, 0.12);
            --dd-card-bg: #FFFFFF;
            --dd-card-border: #E2E8F0;
            --dd-inner-bg: #F8FAFC;
            --dd-spec-bg: #FFFFFF;
            --dd-text-title: #0F172A;
            --dd-text-sub: #64748B;
        }

        [data-pc-theme="dark"] {
            --dd-card-bg: #0B2239;
            --dd-card-border: #29435D;
            --dd-inner-bg: #102B45;
            --dd-spec-bg: #0B2239;
            --dd-text-title: #FFFFFF;
            --dd-text-sub: #8FA1B5;
        }

        .dd-portal-card {
            background: var(--dd-card-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }

        .dd-portal-title {
            color: var(--dd-text-title);
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .dd-portal-sub {
            color: var(--dd-text-sub);
            font-size: 13px;
        }

        /* Blueprint Spec Card */
        .dd-blueprint-card {
            background: var(--dd-inner-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.2s ease;
        }

        .dd-blueprint-card:hover {
            border-color: var(--dd-gold);
        }

        .dd-spec-item {
            background: var(--dd-spec-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 10px;
            padding: 12px 14px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .dd-spec-item:hover {
            border-color: rgba(217, 164, 65, 0.5);
            transform: translateY(-2px);
        }

        .dd-spec-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            color: var(--dd-text-sub);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 4px;
        }

        .dd-spec-val {
            font-family: 'JetBrains Mono', monospace;
            font-size: 17px;
            font-weight: 800;
            color: var(--dd-gold);
        }

        .dd-meas-badge {
            background: var(--dd-gold-light);
            color: var(--dd-gold);
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid rgba(217, 164, 65, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .dd-empty-state {
            padding: 48px 24px;
            text-align: center;
        }

        .dd-empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--dd-gold-light);
            color: var(--dd-gold);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 16px;
            border: 1px solid rgba(217, 164, 65, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="dd-portal-card p-4 p-md-5">
                {{-- Header --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--dd-card-border) !important;">
                    <div>
                        <h4 class="mb-1 dd-portal-title">{{ __('Saved Anatomical Blueprints & Measurements') }}</h4>
                        <p class="dd-portal-sub mb-0">{{ __('Review your exact custom fitting profiles and posture configurations recorded by our master tailors') }}</p>
                    </div>
                </div>

                @forelse ($measurements as $measurement)
                    <div class="dd-blueprint-card">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-3 border-bottom" style="border-color: var(--dd-card-border) !important;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="background: var(--dd-gold-light); border: 1px solid rgba(217, 164, 65, 0.4); width: 48px; height: 48px;">
                                    <i class="ti ti-ruler-2 fs-4" style="color: var(--dd-gold);"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 dd-portal-title">{{ $measurement->clothTypes->title ?? $measurement->clothTypes->name ?? __('Custom Fitting Profile') }}</h5>
                                    <small class="dd-portal-sub">
                                        <i class="ti ti-calendar me-1"></i> {{ __('Recorded') }}: {{ $measurement->date ? \Carbon\Carbon::parse($measurement->date)->format('M d, Y') : '-' }}
                                        @if($measurement->users)
                                            <span class="mx-2">•</span> <i class="ti ti-user me-1"></i> {{ __('Master Tailor') }}: {{ $measurement->users->name }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <span class="dd-meas-badge">
                                <i class="ti ti-circle-check"></i> {{ __('Verified Atelier Fit') }}
                            </span>
                        </div>

                        {{-- Measurement Values Grid --}}
                        @if(!empty($measurement->measurement_detail) && is_array($measurement->measurement_detail))
                            <h6 class="fw-bold mb-3 dd-portal-title small text-uppercase" style="letter-spacing: 0.8px; color: var(--dd-gold) !important;">
                                <i class="ti ti-list-details me-1"></i>{{ __('Specification Metrics') }}
                            </h6>
                            <div class="row g-2">
                                @foreach($measurement->measurement_detail as $paramKey => $paramVal)
                                    @if($paramVal !== null && $paramVal !== '')
                                        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                            <div class="dd-spec-item">
                                                <span class="dd-spec-label">{{ ucwords(str_replace('_', ' ', $paramKey)) }}</span>
                                                <span class="dd-spec-val">{{ $paramVal }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="dd-portal-sub mb-0">{{ __('No specific detailed parameters listed for this entry.') }}</p>
                        @endif

                        {{-- Posture Adjustments --}}
                        @if(!empty($measurement->posture_adjustments) && is_array($measurement->posture_adjustments) && count($measurement->posture_adjustments) > 0)
                            <div class="mt-3 pt-3 border-top" style="border-color: var(--dd-card-border) !important;">
                                <small class="fw-bold dd-portal-title d-block mb-2"><i class="ti ti-user-check me-1"></i>{{ __('Posture & Structure Adjustments:') }}</small>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($measurement->posture_adjustments as $posture)
                                        <span class="badge" style="background: rgba(217, 164, 65, 0.15); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.3); font-size: 11px; padding: 5px 10px;">
                                            {{ ucwords(str_replace('_', ' ', $posture)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="dd-empty-state">
                        <div class="dd-empty-icon">
                            <i class="ti ti-ruler-2"></i>
                        </div>
                        <h5 class="fw-bold dd-portal-title mb-1">{{ __('No Saved Measurement Profiles') }}</h5>
                        <p class="dd-portal-sub mb-3">{{ __('Visit our tailoring studio or book a master fitting session to record your bespoke body measurements.') }}</p>
                        <a href="{{ route('customer.orders') }}" class="btn" style="background: var(--dd-gold); color: #03111F; font-weight: 700; border-radius: 10px; padding: 9px 20px;">
                            <i class="ti ti-shopping-cart me-1"></i> {{ __('View My Orders') }}
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
