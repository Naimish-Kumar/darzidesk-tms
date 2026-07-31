<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ !empty($order) ? __('Track Order #') . orderPrefix() . $order->order_id : __('Public Order Tracking Portal') }} - {{ env('APP_NAME', 'DarziDesk') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        :root {
            --primary-teal: #00796B;
            --dark-teal: #004D40;
            --light-mint: #E6F4F1;
            --bg-light: #F8FAFC;
            --font-main: 'Hanken Grotesk', -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-light);
            color: #0F172A;
            min-height: 100vh;
        }

        .dd-hero {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #FFFFFF;
            padding: 44px 0 70px;
            position: relative;
        }

        .dd-brand-logo {
            font-size: 24px;
            font-weight: 800;
            color: #FFFFFF;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .dd-search-box {
            max-width: 600px;
            margin: 20px auto 0;
        }

        .dd-search-input {
            border-radius: 30px;
            padding: 12px 20px;
            font-size: 14.5px;
            border: 2px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: #FFFFFF !important;
            backdrop-filter: blur(10px);
        }

        .dd-search-input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .dd-search-input:focus {
            background: rgba(255,255,255,0.18);
            border-color: var(--primary-teal);
            box-shadow: 0 0 0 0.25rem rgba(0, 121, 107, 0.25);
        }

        .dd-search-btn {
            background: var(--primary-teal);
            color: #FFFFFF;
            border-radius: 30px;
            padding: 10px 24px;
            font-weight: 700;
            border: none;
            transition: all 0.2s ease;
        }

        .dd-search-btn:hover {
            background: var(--dark-teal);
            color: #FFFFFF;
        }

        /* Card Container */
        .dd-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            overflow: hidden;
            margin-top: -36px;
        }

        /* Pipeline */
        .dd-step-bubble {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin: 0 auto 8px;
            z-index: 2;
            position: relative;
            font-family: var(--font-mono);
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .dd-step-bubble.active {
            background: var(--primary-teal);
            color: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(0, 121, 107, 0.2);
        }

        .dd-step-bubble.completed {
            background: #10B981;
            color: #FFFFFF;
        }

        .dd-step-bubble.pending {
            background: #F1F5F9;
            color: #94A3B8;
            border: 1px solid #CBD5E1;
        }

        .dd-step-line {
            position: absolute;
            top: 21px;
            left: 10%;
            right: 10%;
            height: 4px;
            background: #E2E8F0;
            z-index: 1;
        }

        .dd-code-badge {
            font-family: var(--font-mono);
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-teal);
            background: var(--light-mint);
            padding: 4px 12px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    {{-- Hero Section --}}
    <div class="dd-hero text-center">
        <div class="container">
            <a href="/" class="dd-brand-logo mb-2">
                <i class="ti ti-scissors" style="font-size: 28px; color: var(--primary-teal);"></i>
                <span>{{ env('APP_NAME', 'DarziDesk') }}</span>
            </a>
            <p class="text-white-50 small mb-3">{{ __('Bespoke Tailoring & Garment Order Tracking Portal') }}</p>

            {{-- Search Bar --}}
            <div class="dd-search-box">
                <form action="{{ route('track.order.search') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="order_query" class="form-control dd-search-input" 
                            placeholder="{{ __('Enter Order ID (e.g. #ORD-001) or Tracking Code...') }}" 
                            value="{{ $token ?? '' }}" required>
                        <button type="submit" class="dd-search-btn">
                            <i class="ti ti-search me-1"></i>{{ __('Track') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Content Section --}}
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-12">
                
                {{-- Search Error Alert --}}
                @if(isset($searchError) && !empty($searchError))
                    <div class="alert alert-warning shadow-sm border-0 rounded-4 p-4 text-center mt-4">
                        <i class="ti ti-alert-triangle fs-1 d-block mb-2 text-warning"></i>
                        <h5 class="fw-bold text-dark">{{ __('Order Not Found') }}</h5>
                        <p class="text-muted mb-0">{{ $searchError }}</p>
                    </div>
                @endif

                @if(!empty($order))
                    <div class="dd-card mb-4">
                        <div class="card-body p-4">
                            
                            {{-- Header Details --}}
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-3 border-bottom mb-4">
                                <div>
                                    <span class="dd-code-badge mb-2 d-inline-block">{{ orderPrefix() . $order->order_id }}</span>
                                    <h4 class="fw-bold mb-1" style="font-size: 20px;">
                                        {{ !empty($order->customers) ? $order->customers->name : __('Valued Customer') }}
                                    </h4>
                                    <p class="text-muted small mb-0">
                                        <i class="ti ti-calendar me-1"></i>{{ __('Booked Date: ') . dateFormat($order->order_date) }}
                                    </p>
                                </div>
                                <div class="text-md-end">
                                    <span class="badge" style="background:#E6F4F1; color:#00796B; font-weight:700; font-size:13px; padding:6px 14px; border-radius:20px;">
                                        {{ $order->productionStage->name ?? ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Visual Production Progress --}}
                            <h6 class="fw-bold text-secondary text-uppercase mb-4 text-center" style="font-size: 11.5px; letter-spacing: 0.8px;">
                                {{ __('Production Stage Workflow') }}
                            </h6>

                            @php
                                $currentStageIndex = $order->productionStage->order_index ?? 1;
                                $totalStages = $allStages->count();
                            @endphp

                            <div class="position-relative py-3 mb-4">
                                <div class="dd-step-line"></div>
                                <div class="row text-center">
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
                                            <div class="fw-bold small {{ $isCurrent ? 'text-primary' : ($isDone ? 'text-dark' : 'text-muted') }}" style="font-size: 12.5px;">
                                                {{ $stg->name }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Fitting & Delivery Date Highlights --}}
                            <div class="row g-3 p-3 rounded-3 mb-4" style="background:#F8FAFC; border:1px solid #E2E8F0;">
                                <div class="col-md-6 text-center text-md-start">
                                    <small class="text-muted d-block fw-semibold mb-1">{{ __('Trial / Fitting Date:') }}</small>
                                    <span class="fw-bold text-dark" style="font-size: 15px;">
                                        <i class="ti ti-shirt me-1 text-primary"></i>
                                        {{ !empty($order->trial_date) ? dateFormat($order->trial_date) : __('To be scheduled') }}
                                    </span>
                                </div>
                                <div class="col-md-6 text-center text-md-end">
                                    <small class="text-muted d-block fw-semibold mb-1">{{ __('Target Delivery Date:') }}</small>
                                    <span class="fw-bold text-dark" style="font-size: 15px;">
                                        <i class="ti ti-calendar-check me-1 text-success"></i>
                                        {{ dateFormat($order->deadline_date) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Specs and Receipt Row --}}
                            <div class="row g-4">
                                {{-- Specs Card --}}
                                <div class="col-md-7">
                                    <div class="border rounded-3 p-3 h-100">
                                        <h6 class="fw-bold mb-3" style="font-size: 14px;">
                                            <i class="ti ti-scissors me-1 text-primary"></i>{{ __('Garment & Fabric Details') }}
                                        </h6>
                                        <ul class="list-group list-group-flush" style="font-size: 13.5px;">
                                            <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                                <span class="text-muted">{{ __('Cloth Type') }}</span>
                                                <span class="fw-semibold text-dark">{{ $order->clothTypes->title ?? __('Custom Garment') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                                <span class="text-muted">{{ __('Quantity') }}</span>
                                                <span class="fw-semibold text-dark">{{ $order->quantity }} {{ __('pcs') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                                <span class="text-muted">{{ __('Fabric') }}</span>
                                                <span class="fw-semibold text-dark">{{ $order->febric ?? __('Standard') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                                <span class="text-muted">{{ __('Fabric Color') }}</span>
                                                <span class="fw-semibold text-dark">{{ $order->febric_color ?? __('Standard') }}</span>
                                            </li>
                                        </ul>

                                        @if(!empty($order->notes))
                                            <div class="mt-3 p-2 bg-light rounded" style="font-size: 12.5px;">
                                                <strong>{{ __('Special Instructions:') }}</strong> {{ $order->notes }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Receipt & QR Actions --}}
                                <div class="col-md-5">
                                    <div class="border rounded-3 p-3 text-center h-100 d-flex flex-direction-column justify-content-between" style="display:flex; flex-direction:column;">
                                        <div>
                                            <h6 class="fw-bold mb-3 text-start" style="font-size: 14px;">
                                                <i class="ti ti-qrcode me-1 text-primary"></i>{{ __('Digital QR Receipt') }}
                                            </h6>
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode(route('track.order', ['token' => $order->tracking_token ?? $order->order_id])) }}" 
                                                alt="QR Code" class="img-fluid rounded border p-2 mb-2">
                                            <small class="text-muted d-block mb-3" style="font-size: 11.5px;">{{ __('Scan QR to check live status on mobile') }}</small>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <a href="{{ route('order.public.qr-receipt', $order->tracking_token ?? $order->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                                                <i class="ti ti-printer me-1"></i>{{ __('Print Slip') }}
                                            </a>
                                            @php
                                                $waPhone = $order->customers->phone_number ?? '';
                                                $waMsg = \App\Helper\WhatsAppService::getStatusUpdateMessage($order);
                                                $waUrl = \App\Helper\WhatsAppService::generateClickToChatUrl($waPhone, $waMsg);
                                            @endphp
                                            <a href="{{ $waUrl }}" target="_blank" class="btn btn-success btn-sm text-white fw-bold" style="border-radius: 8px; background:#25D366; border:none;">
                                                <i class="ti ti-brand-whatsapp me-1"></i>{{ __('Chat with Shop on WhatsApp') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @elseif(!isset($searchError))
                    {{-- Default Search Landing Card --}}
                    <div class="dd-card p-5 text-center mt-4">
                        <div class="py-4">
                            <i class="ti ti-scissors-off fs-1 text-primary d-block mb-3"></i>
                            <h4 class="fw-bold mb-2">{{ __('Track Your Bespoke Order') }}</h4>
                            <p class="text-muted max-w-md mx-auto mb-4" style="font-size: 14px;">
                                {{ __('Enter your Order Number or Tracking Code in the search bar above to view live stitching progress, fitting trial schedules, and digital receipts.') }}
                            </p>
                        </div>
                    </div>
                @endif

                <div class="text-center text-muted py-4">
                    <small>{{ __('Powered by ') }}<strong>{{ env('APP_NAME', 'DarziDesk TMS') }}</strong> {{ __('Tailoring Management System') }}</small>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
