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
        .dd-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 10px;
            text-transform: uppercase;
        }
        .dd-badge-pending { background: #FEF3C7; color: #92400E; }
        .dd-badge-in_progress { background: #E0F2FE; color: #075985; }
        .dd-badge-completed { background: #DCFCE7; color: #166534; }
        .dd-badge-ready_for_delivery { background: #F3E8FF; color: #6B21A8; }
        .dd-badge-delivered { background: #E0E7FF; color: #3730A3; }
        .dd-badge-on_hold { background: #FFEDD5; color: #9A3412; }
        .dd-badge-cancelled { background: #FEE2E2; color: #991B1B; }

        /* Stepper progress */
        .dd-step-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin: 20px 0 30px;
        }
        .dd-step-item {
            text-align: center;
            flex: 1;
            position: relative;
            z-index: 1;
        }
        .dd-step-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #F1F5F9;
            color: #64748B;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 8px;
            border: 2px solid #CBD5E1;
            transition: all 0.3s ease;
        }
        .dd-step-item.completed .dd-step-icon {
            background: var(--dd-teal);
            color: #FFFFFF;
            border-color: var(--dd-teal);
        }
        .dd-step-item.active .dd-step-icon {
            background: #FFFFFF;
            color: var(--dd-teal);
            border-color: var(--dd-teal);
            box-shadow: 0 0 0 4px var(--dd-teal-light);
        }
        .dd-step-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748B;
        }
        .dd-step-item.completed .dd-step-label,
        .dd-step-item.active .dd-step-label {
            color: #0F172A;
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
            <div class="dd-card p-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 border-bottom pb-3 mb-4">
                    <div>
                        <span class="text-muted small d-block">{{ __('ORDER NUMBER') }}</span>
                        <h3 class="mb-0 fw-bold text-dark">{{ orderPrefix() . $order->id }}</h3>
                    </div>
                    <div>
                        @php $badgeClass = 'dd-badge-' . ($order->status ?? 'pending'); @endphp
                        <span class="dd-badge {{ $badgeClass }}">
                            {{ $statuses[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>

                {{-- Status Stepper Timeline --}}
                <h6 class="fw-bold mb-3">{{ __('Order Status Progression') }}</h6>
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
                <h6 class="fw-bold mb-3 border-top pt-4">{{ __('Garment Specifications') }}</h6>
                <div class="row g-3">
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block">{{ __('Cloth / Garment Type') }}</span>
                            <strong class="text-dark">{{ $order->clothTypes->title ?? $order->clothTypes->name ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block">{{ __('Gender') }}</span>
                            <strong class="text-dark">{{ ucfirst($order->gender ?? '-') }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block">{{ __('Quantity') }}</span>
                            <strong class="text-dark">{{ $order->quantity ?? 1 }} {{ __('Pcs') }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block">{{ __('Fabric Type') }}</span>
                            <strong class="text-dark">{{ $order->febric ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block">{{ __('Fabric Color') }}</span>
                            <strong class="text-dark">{{ $order->febric_color ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-muted small d-block">{{ __('Assigned Master Tailor') }}</span>
                            <strong class="text-dark">{{ $order->users->name ?? 'Artisan Team' }}</strong>
                        </div>
                    </div>
                </div>

                @if(!empty($order->notes))
                    <div class="mt-4 p-3 border rounded-3 bg-light-warning">
                        <h6 class="fw-bold text-warning mb-1"><i class="ti ti-note me-1"></i> {{ __('Special Instructions / Notes') }}</h6>
                        <p class="mb-0 text-dark small">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Measurement Section --}}
            @if(!empty($order->measurement) && is_array($order->measurement))
                <div class="dd-card p-4">
                    <h6 class="fw-bold mb-3"><i class="ti ti-ruler-2 me-1" style="color: var(--dd-teal);"></i> {{ __('Applied Garment Measurements') }}</h6>
                    <div class="row g-2">
                        @foreach($order->measurement as $mKey => $mValue)
                            @if(!empty($mValue))
                                <div class="col-sm-4 col-6">
                                    <div class="border rounded p-2 text-center bg-light">
                                        <span class="text-muted d-block" style="font-size: 11px; text-transform: uppercase;">{{ ucwords(str_replace('_', ' ', $mKey)) }}</span>
                                        <strong class="text-dark fs-6">{{ $mValue }}</strong>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column: Key Dates & Receipt Link --}}
        <div class="col-lg-4">
            <div class="dd-card p-4">
                <h6 class="fw-bold mb-3">{{ __('Order Metadata') }}</h6>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">{{ __('Booking Date') }}</span>
                        <strong class="text-dark">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y') : '-' }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted">{{ __('Delivery Deadline') }}</span>
                        <strong class="text-dark">{{ $order->deadline_date ? \Carbon\Carbon::parse($order->deadline_date)->format('M d, Y') : '-' }}</strong>
                    </li>
                </ul>

                @if($order->tracking_token)
                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('track.order', $order->tracking_token) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="ti ti-external-link me-1"></i> {{ __('Public Tracking Page') }}
                        </a>
                        <a href="{{ route('order.public.qr-receipt', $order->tracking_token) }}" target="_blank" class="btn btn-primary" style="background: var(--dd-teal); border-color: var(--dd-teal);">
                            <i class="ti ti-qrcode me-1"></i> {{ __('Digital QR Receipt') }}
                        </a>
                    </div>
                @endif

                <a href="{{ route('customer.orders') }}" class="btn btn-light w-100 mt-2">
                    <i class="ti ti-arrow-left me-1"></i> {{ __('Back to My Orders') }}
                </a>
            </div>
        </div>
    </div>
@endsection
