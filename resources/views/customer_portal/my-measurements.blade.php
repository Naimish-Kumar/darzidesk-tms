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
            --dd-teal: #00796B;
            --dd-teal-light: #E6F4F1;
            --dd-teal-dark: #004D40;
        }
        .dd-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .dd-meas-badge {
            background: var(--dd-teal-light);
            color: var(--dd-teal);
            font-weight: 700;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="dd-card p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">{{ __('Saved Body Measurements') }}</h4>
                        <p class="text-muted mb-0 small">{{ __('Review your exact custom fitting profiles recorded by our master tailors') }}</p>
                    </div>
                </div>

                @forelse ($measurements as $measurement)
                    <div class="border rounded-3 p-4 mb-4" style="background: #FAFAFA;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: var(--dd-teal-light); width: 44px; height: 44px;">
                                    <i class="ti ti-ruler-2 fs-4" style="color: var(--dd-teal);"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">{{ $measurement->clothTypes->title ?? $measurement->clothTypes->name ?? __('Custom Fitting Profile') }}</h5>
                                    <small class="text-muted">
                                        <i class="ti ti-calendar me-1"></i> {{ __('Recorded on') }}: {{ $measurement->date ? \Carbon\Carbon::parse($measurement->date)->format('M d, Y') : '-' }}
                                        @if($measurement->users)
                                            | <i class="ti ti-user me-1"></i> {{ __('Tailor') }}: {{ $measurement->users->name }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <span class="dd-meas-badge">
                                <i class="ti ti-check me-1"></i> {{ __('Verified Fit') }}
                            </span>
                        </div>

                        {{-- Measurement Values Grid --}}
                        @if(!empty($measurement->measurement_detail) && is_array($measurement->measurement_detail))
                            <h6 class="fw-bold mb-3 text-dark small text-uppercase" style="letter-spacing: 0.5px;">{{ __('Measurement Specifications') }}</h6>
                            <div class="row g-2">
                                @foreach($measurement->measurement_detail as $paramKey => $paramVal)
                                    @if($paramVal !== null && $paramVal !== '')
                                        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                            <div class="bg-white border rounded p-2 text-center shadow-sm">
                                                <span class="text-muted d-block" style="font-size: 11px; font-weight: 600;">{{ ucwords(str_replace('_', ' ', $paramKey)) }}</span>
                                                <span class="fw-bold text-dark fs-6">{{ $paramVal }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small mb-0">{{ __('No specific detailed parameters listed for this entry.') }}</p>
                        @endif

                        {{-- Posture Adjustments --}}
                        @if(!empty($measurement->posture_adjustments) && is_array($measurement->posture_adjustments))
                            <div class="mt-3 pt-3 border-top">
                                <small class="fw-bold text-dark d-block mb-1">{{ __('Posture & Structure Notes:') }}</small>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($measurement->posture_adjustments as $posture)
                                        <span class="badge bg-light-secondary text-secondary" style="font-size: 11px;">{{ ucwords(str_replace('_', ' ', $posture)) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="ti ti-ruler-off f-36 d-block mb-2" style="color: #94A3B8;"></i>
                        <h6 class="fw-bold mb-1">{{ __('No Measurements Recorded') }}</h6>
                        <p class="text-muted small mb-0">{{ __('Visit our studio to get measured by a master tailor.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
