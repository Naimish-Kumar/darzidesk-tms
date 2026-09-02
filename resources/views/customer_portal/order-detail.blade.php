@extends('layouts.app')

@section('page-title')
    {{ __('Order Details') }} - {{ orderPrefix() . $order->id }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('customer.orders') }}">{{ __('My Orders') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ orderPrefix() . $order->id }}</li>
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
            --dd-text-title: #0F172A;
            --dd-text-sub: #64748B;
        }

        [data-pc-theme="dark"] {
            --dd-card-bg: #0B2239;
            --dd-card-border: #29435D;
            --dd-inner-bg: #102B45;
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

        .dd-status-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .dd-status-pending { background: rgba(217, 164, 65, 0.15); color: #F4C861; border: 1px solid rgba(217, 164, 65, 0.4); }
        .dd-status-in_progress { background: rgba(59, 130, 246, 0.15); color: #60A5FA; border: 1px solid rgba(59, 130, 246, 0.4); }
        .dd-status-completed { background: rgba(34, 197, 94, 0.15); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.4); }
        .dd-status-ready_for_delivery { background: rgba(168, 85, 247, 0.15); color: #C084FC; border: 1px solid rgba(168, 85, 247, 0.4); }
        .dd-status-delivered { background: rgba(99, 102, 241, 0.15); color: #818CF8; border: 1px solid rgba(99, 102, 241, 0.4); }
        .dd-status-on_hold { background: rgba(249, 115, 22, 0.15); color: #FB923C; border: 1px solid rgba(249, 115, 22, 0.4); }
        .dd-status-cancelled { background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.4); }

        /* Stepper progress */
        .dd-step-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin: 24px 0 32px;
        }

        .dd-step-item {
            text-align: center;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .dd-step-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--dd-inner-bg);
            color: var(--dd-text-sub);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 8px;
            border: 2px solid var(--dd-card-border);
            transition: all 0.3s ease;
        }

        .dd-step-item.completed .dd-step-icon {
            background: #22C55E;
            color: #FFFFFF;
            border-color: #22C55E;
        }

        .dd-step-item.active .dd-step-icon {
            background: var(--dd-gold);
            color: #03111F;
            border-color: var(--dd-gold);
            box-shadow: 0 0 0 4px var(--dd-gold-light);
        }

        .dd-step-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--dd-text-sub);
        }

        .dd-step-item.completed .dd-step-label {
            color: var(--dd-text-title);
        }

        .dd-step-item.active .dd-step-label {
            color: var(--dd-gold);
        }

        .dd-info-tile {
            background: var(--dd-inner-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 12px;
            padding: 14px 16px;
        }
    </style>
@endpush

@section('content')
    @php
        $statuses = \App\Models\Order::$status;
        $orderSteps = ['pending', 'in_progress', 'ready_for_delivery', 'delivered'];
        $currentStatusIndex = array_search($order->status, $orderSteps);
        if ($currentStatusIndex === false) {
            $currentStatusIndex = ($order->status == 'completed') ? 2 : 0;
        }
    @endphp

    <div class="row">
        {{-- Left Column: Summary & Progress --}}
        <div class="col-lg-8">
            {{-- Header Card --}}
            <div class="dd-portal-card p-4 p-md-5">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 border-bottom pb-4 mb-4" style="border-color: var(--dd-card-border) !important;">
                    <div>
                        <span class="dd-portal-sub text-uppercase fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.8px;">{{ __('ORDER NUMBER') }}</span>
                        <h3 class="mb-0 fw-bold dd-portal-title" style="font-family: 'JetBrains Mono', monospace; color: var(--dd-gold);">{{ orderPrefix() . $order->id }}</h3>
                    </div>
                    <div>
                        @php
                            $statusKey = $order->status ?? 'pending';
                            $badgeClass = 'dd-status-' . $statusKey;
                        @endphp
                        <span class="dd-status-badge {{ $badgeClass }}">
                            {{ $statuses[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>

                {{-- Status Stepper Timeline --}}
                <h6 class="fw-bold mb-3 dd-portal-title">{{ __('Order Status Progression') }}</h6>
                <div class="dd-step-bar">
                    @foreach (['pending' => 'Placed', 'in_progress' => 'In Stitching', 'ready_for_delivery' => 'Ready', 'delivered' => 'Delivered'] as $stepKey => $stepTitle)
                        @php
                            $stepIdx = array_search($stepKey, array_keys(['pending' => 1, 'in_progress' => 2, 'ready_for_delivery' => 3, 'delivered' => 4]));
                            $isCompleted = $currentStatusIndex > $stepIdx;
                            $isActive = $currentStatusIndex === $stepIdx;
                        @endphp
                        <div class="dd-step-item {{ $isCompleted ? 'completed' : ($isActive ? 'active' : '') }}">
                            <div class="dd-step-icon">
                                @if($isCompleted)
                                    <i class="ti ti-check"></i>
                                @elseif($stepKey == 'pending')
                                    <i class="ti ti-receipt"></i>
                                @elseif($stepKey == 'in_progress')
                                    <i class="ti ti-cut"></i>
                                @elseif($stepKey == 'ready_for_delivery')
                                    <i class="ti ti-hanger"></i>
                                @else
                                    <i class="ti ti-package"></i>
                                @endif
                            </div>
                            <div class="dd-step-label">{{ $stepTitle }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- Garment Details Grid --}}
                <h6 class="fw-bold mb-3 border-top pt-4 dd-portal-title" style="border-color: var(--dd-card-border) !important;">{{ __('Garment Specifications') }}</h6>
                <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                        <div class="dd-info-tile">
                            <span class="dd-portal-sub small d-block mb-1">{{ __('Cloth / Garment Type') }}</span>
                            <strong class="dd-portal-title">{{ $order->clothTypes->title ?? $order->clothTypes->name ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="dd-info-tile">
                            <span class="dd-portal-sub small d-block mb-1">{{ __('Gender') }}</span>
                            <strong class="dd-portal-title">{{ ucfirst($order->gender ?? '-') }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="dd-info-tile">
                            <span class="dd-portal-sub small d-block mb-1">{{ __('Fabric') }}</span>
                            <strong class="dd-portal-title">{{ $order->febric ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="dd-info-tile">
                            <span class="dd-portal-sub small d-block mb-1">{{ __('Fabric Color') }}</span>
                            <strong class="dd-portal-title">{{ $order->febric_color ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="dd-info-tile">
                            <span class="dd-portal-sub small d-block mb-1">{{ __('Booking Date') }}</span>
                            <strong class="dd-portal-title">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y') : '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="dd-info-tile">
                            <span class="dd-portal-sub small d-block mb-1">{{ __('Estimated Delivery') }}</span>
                            <strong class="dd-portal-title" style="color: var(--dd-gold);">{{ $order->deadline_date ? \Carbon\Carbon::parse($order->deadline_date)->format('M d, Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Special Instructions / Notes --}}
                @if(!empty($order->special_instructions) || !empty($order->notes))
                    <div class="mt-4 pt-3 border-top" style="border-color: var(--dd-card-border) !important;">
                        <h6 class="fw-bold dd-portal-title mb-2">{{ __('Special Instructions & Styling Notes') }}</h6>
                        <div class="dd-info-tile">
                            <p class="mb-0 dd-portal-sub">{{ $order->special_instructions ?? $order->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Studio Atelier & Invoice Links --}}
        <div class="col-lg-4">
            <div class="dd-portal-card p-4">
                <h5 class="fw-bold mb-3 dd-portal-title">{{ __('Atelier Studio') }}</h5>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: var(--dd-gold-light); width: 44px; height: 44px; border: 1px solid rgba(217, 164, 65, 0.4);">
                        <i class="ti ti-building-store fs-4" style="color: var(--dd-gold);"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 dd-portal-title">{{ $order->shop->shop_name ?? __('DarziDesk Atelier') }}</h6>
                        <small class="dd-portal-sub">{{ $order->shop->address ?? __('Bespoke Custom Fitting') }}</small>
                    </div>
                </div>
            </div>

            @if($order->invoices)
                <div class="dd-portal-card p-4">
                    <h5 class="fw-bold mb-3 dd-portal-title">{{ __('Associated Invoice') }}</h5>
                    <div class="dd-info-tile mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="dd-portal-sub small">{{ __('Invoice #') }}</span>
                            <span class="fw-bold" style="font-family: 'JetBrains Mono', monospace; color: var(--dd-gold);">{{ invoicePrefix() . $order->invoices->invoice_id }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="dd-portal-sub small">{{ __('Total Amount') }}</span>
                            <strong class="dd-portal-title">{{ priceFormat($order->invoices->getInvoiceTotalAmount()) }}</strong>
                        </div>
                    </div>
                    <a href="{{ route('customer.invoices.show', $order->invoices->id) }}" class="btn w-100" style="background: var(--dd-gold); color: #03111F; font-weight: 700; border-radius: 10px;">
                        <i class="ti ti-receipt me-1"></i> {{ __('View Invoice Receipt') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
