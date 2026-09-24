@extends('layouts.app')

@section('page-title')
    {{ __('Track Order') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Track Order') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --dd-gold: #D9A441;
            --dd-gold-hover: #F4C861;
            --dd-gold-light: rgba(217, 164, 65, 0.15);
            --dd-card-bg: #0B2239;
            --dd-card-border: #29435D;
            --dd-text-title: #FFFFFF;
            --dd-text-sub: #8FA1B5;
            --dd-input-bg: #102B45;
            --dd-input-border: #29435D;
        }

        .dd-portal-card {
            background: var(--dd-card-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            transition: all 0.2s ease;
        }

        .dd-search-input {
            border-radius: 30px 0 0 30px !important;
            padding: 12px 20px !important;
            font-size: 14px !important;
            border: 1px solid var(--dd-input-border) !important;
            background: var(--dd-input-bg) !important;
            color: #FFFFFF !important;
        }

        .dd-search-input::placeholder {
            color: #8FA1B5 !important;
        }

        .dd-search-btn {
            background: var(--dd-gold) !important;
            color: #03111F !important;
            border-radius: 0 30px 30px 0 !important;
            padding: 10px 24px !important;
            font-weight: 800 !important;
            border: none !important;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .dd-search-btn:hover {
            background: var(--dd-gold-hover) !important;
            color: #03111F !important;
        }

        .dd-step-bubble {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin: 0 auto 10px;
            z-index: 2;
            position: relative;
            font-size: 13px;
            transition: all 0.2s ease;
        }

        .dd-step-bubble.active {
            background: var(--dd-gold);
            color: #03111F;
            box-shadow: 0 0 0 4px var(--dd-gold-light);
        }

        .dd-step-bubble.completed {
            background: #22C55E;
            color: #FFFFFF;
        }

        .dd-step-bubble.pending {
            background: #102B45;
            color: #8FA1B5;
            border: 1px solid var(--dd-card-border);
        }

        .dd-step-line {
            position: absolute;
            top: 21px;
            left: 8%;
            right: 8%;
            height: 3px;
            background: var(--dd-card-border);
            z-index: 1;
        }

        .dd-code-badge {
            font-size: 13px;
            font-weight: 700;
            color: var(--dd-gold);
            background: var(--dd-gold-light);
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid rgba(217, 164, 65, 0.3);
            display: inline-block;
        }

        .dd-spec-pill {
            background: #102B45;
            border: 1px solid var(--dd-card-border);
            border-radius: 10px;
            padding: 12px 16px;
        }

        .dd-spec-pill-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #8FA1B5;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .dd-spec-pill-val {
            font-size: 14px;
            font-weight: 700;
            color: #FFFFFF;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-10 col-12">
            
            {{-- Header / Search Section Card --}}
            <div class="dd-portal-card p-4 mb-4">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <h4 class="fw-bold mb-1 text-white"><i class="ti ti-search text-gold me-2"></i>{{ __('Track Tailoring Order Status') }}</h4>
                        <p class="dd-portal-sub mb-0">{{ __('Enter your order ID or tracking code to see live atelier stitching & trial updates.') }}</p>
                    </div>
                    <div class="col-lg-6">
                        <form action="{{ route('customer.track.search') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="order_query" class="form-control dd-search-input" 
                                    placeholder="{{ __('Enter Order Code (e.g. #ORD-001)...') }}" 
                                    value="{{ $searchQuery ?? '' }}" required>
                                <button type="submit" class="dd-search-btn">
                                    <i class="ti ti-search me-1"></i> {{ __('Track') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Search Error Alert --}}
            @if(!empty($searchError))
                <div class="alert alert-warning shadow-sm border-0 rounded-4 p-4 text-center mb-4" style="background: rgba(217, 164, 65, 0.15); border: 1px solid var(--dd-gold) !important; color: #FFFFFF;">
                    <i class="ti ti-alert-triangle fs-2 d-block mb-2" style="color: var(--dd-gold);"></i>
                    <h5 class="fw-bold mb-1">{{ __('Order Not Found') }}</h5>
                    <p class="mb-0" style="color: #8FA1B5;">{{ $searchError }}</p>
                </div>
            @endif

            @if(!empty($order))
                <div class="dd-portal-card p-4 p-md-5 mb-4">
                    {{-- Header Details --}}
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 border-bottom mb-4" style="border-color: var(--dd-card-border) !important;">
                        <div>
                            <span class="dd-code-badge mb-2">{{ orderPrefix() . $order->order_id }}</span>
                            <h4 class="fw-bold mb-1 text-white">
                                {{ !empty($order->customers) ? $order->customers->name : __('Valued Client') }}
                            </h4>
                            <p class="small mb-0" style="color: #8FA1B5;">
                                <i class="ti ti-calendar me-1"></i>{{ __('Booked Date: ') . dateFormat($order->order_date) }}
                            </p>
                        </div>
                        <div class="text-md-end d-flex align-items-center gap-2">
                            <span class="badge" style="background: var(--dd-gold-light); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.4); font-weight: 700; font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                                {{ $order->productionStage->name ?? ucfirst($order->status) }}
                            </span>
                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                <i class="ti ti-eye me-1"></i> {{ __('View Details') }}
                            </a>
                        </div>
                    </div>

                    {{-- Visual Production Progress --}}
                    <h6 class="fw-bold text-uppercase mb-4 text-center" style="font-size: 11.5px; letter-spacing: 1px; color: var(--dd-gold);">
                        <i class="ti ti-activity me-1"></i>{{ __('Production Stage Workflow') }}
                    </h6>

                    @php
                        $currentStageIndex = $order->productionStage->order_index ?? 1;
                    @endphp

                    <div class="position-relative py-3 mb-4">
                        <div class="dd-step-line"></div>
                        <div class="row text-center position-relative" style="z-index: 2;">
                            @foreach($allStages as $stg)
                                @php
                                    $isDone = $stg->order_index < $currentStageIndex;
                                    $isCurrent = $stg->order_index == $currentStageIndex;
                                    $bubbleClass = $isCurrent ? 'active' : ($isDone ? 'completed' : 'pending');
                                @endphp
                                <div class="col">
                                    <div class="dd-step-bubble {{ $bubbleClass }}">
                                        @if($isDone) 
                                            <i class="ti ti-check"></i> 
                                        @else 
                                            {{ $stg->order_index }} 
                                        @endif
                                    </div>
                                    <div class="fw-bold small {{ $isCurrent ? 'text-gold' : ($isDone ? 'text-white' : 'text-muted') }}" style="{{ $isCurrent ? 'color: var(--dd-gold);' : '' }} font-size: 12px;">
                                        {{ $stg->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Spec Details Grid --}}
                    <div class="row g-3 mt-3 pt-3 border-top" style="border-color: var(--dd-card-border) !important;">
                        <div class="col-md-4 col-sm-6">
                            <div class="dd-spec-pill">
                                <div class="dd-spec-pill-label">{{ __('Cloth / Garment') }}</div>
                                <div class="dd-spec-pill-val">{{ $order->clothTypes->title ?? $order->clothTypes->name ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="dd-spec-pill">
                                <div class="dd-spec-pill-label">{{ __('Fabric Selected') }}</div>
                                <div class="dd-spec-pill-val">{{ $order->febric ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="dd-spec-pill">
                                <div class="dd-spec-pill-label">{{ __('Estimated Delivery') }}</div>
                                <div class="dd-spec-pill-val" style="color: var(--dd-gold);">{{ $order->deadline_date ? dateFormat($order->deadline_date) : '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty Initial State --}}
                <div class="dd-portal-card p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 72px; height: 72px; background: var(--dd-gold-light); border: 1px solid rgba(217, 164, 65, 0.3);">
                        <i class="ti ti-scissors fs-1" style="color: var(--dd-gold);"></i>
                    </div>
                    <h4 class="fw-bold text-white mb-2">{{ __('Track Your Bespoke Garment') }}</h4>
                    <p class="mx-auto mb-0" style="color: #8FA1B5; max-width: 480px; font-size: 14px;">
                        {{ __('Enter your Order Number or Tracking Code in the search bar above to view real-time stitching progress, milestone trials, and delivery schedules.') }}
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection
