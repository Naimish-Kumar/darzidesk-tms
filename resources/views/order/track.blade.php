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
    
    {{-- Local bundled icon sets --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        :root {
            --dd-gold: #D9A441;
            --dd-gold-hover: #F4C861;
            --dd-gold-light: rgba(217, 164, 65, 0.15);
            --dd-bg: #03111F;
            --dd-card: #0B2239;
            --dd-border: #29435D;
            --font-main: 'Hanken Grotesk', -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--dd-bg);
            color: #FFFFFF;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .dd-hero {
            background: linear-gradient(135deg, #03111F 0%, #0B2239 100%);
            padding: 50px 0 60px;
            position: relative;
            border-bottom: 1px solid var(--dd-border);
        }

        .dd-brand-logo {
            font-size: 26px;
            font-weight: 800;
            color: #FFFFFF;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.5px;
        }

        .dd-brand-logo i {
            color: var(--dd-gold);
            font-size: 30px;
        }

        .dd-search-box {
            max-width: 600px;
            margin: 24px auto 0;
        }

        .dd-search-input {
            border-radius: 30px 0 0 30px;
            padding: 14px 22px;
            font-size: 14px;
            border: 1px solid var(--dd-border);
            background: #102B45;
            color: #FFFFFF !important;
        }

        .dd-search-input::placeholder {
            color: #8FA1B5;
        }

        .dd-search-input:focus {
            background: #102B45;
            border-color: var(--dd-gold);
            box-shadow: 0 0 0 3px var(--dd-gold-light);
        }

        .dd-search-btn {
            background: var(--dd-gold);
            color: #03111F;
            border-radius: 0 30px 30px 0;
            padding: 12px 28px;
            font-weight: 800;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .dd-search-btn:hover {
            background: var(--dd-gold-hover);
            color: #03111F;
        }

        /* Card Container */
        .dd-card {
            background: var(--dd-card);
            border: 1px solid var(--dd-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            color: #FFFFFF;
        }

        /* Pipeline */
        .dd-step-bubble {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin: 0 auto 10px;
            z-index: 2;
            position: relative;
            font-family: var(--font-mono);
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .dd-step-bubble.active {
            background: var(--dd-gold);
            color: #03111F;
            box-shadow: 0 0 0 5px var(--dd-gold-light);
        }

        .dd-step-bubble.completed {
            background: #22C55E;
            color: #FFFFFF;
        }

        .dd-step-bubble.pending {
            background: #102B45;
            color: #8FA1B5;
            border: 1px solid var(--dd-border);
        }

        .dd-step-line {
            position: absolute;
            top: 22px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: var(--dd-border);
            z-index: 1;
        }

        .dd-code-badge {
            font-family: var(--font-mono);
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
            border: 1px solid var(--dd-border);
            border-radius: 10px;
            padding: 12px 16px;
        }

        .dd-spec-pill-label {
            font-family: var(--font-mono);
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

        .dd-footer {
            margin-top: auto;
            border-top: 1px solid var(--dd-border);
            padding: 24px 0;
            color: #8FA1B5;
            font-size: 13px;
        }
    </style>
</head>
<body>

    {{-- Hero Section --}}
    <div class="dd-hero text-center">
        <div class="container">
            <a href="/" class="dd-brand-logo mb-2">
                <i class="ti ti-scissors"></i>
                <span>{{ env('APP_NAME', 'DarziDesk') }}</span>
            </a>
            <p class="mb-3" style="color: #8FA1B5; font-size: 14px;">{{ __('Bespoke Tailoring & Garment Order Tracking Portal') }}</p>

            {{-- Search Bar --}}
            <div class="dd-search-box">
                <form action="{{ route('track.order.search') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="order_query" class="form-control dd-search-input" 
                            placeholder="{{ __('Enter Order ID (e.g. #ORD-001) or Tracking Code...') }}" 
                            value="{{ $token ?? '' }}" required>
                        <button type="submit" class="dd-search-btn">
                            <i class="ti ti-search"></i> {{ __('Track') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Content Section --}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-12">
                
                {{-- Search Error Alert --}}
                @if(isset($searchError) && !empty($searchError))
                    <div class="alert alert-warning shadow-sm border-0 rounded-4 p-4 text-center mb-4" style="background: rgba(217, 164, 65, 0.15); border: 1px solid var(--dd-gold) !important; color: #FFFFFF;">
                        <i class="ti ti-alert-triangle fs-1 d-block mb-2" style="color: var(--dd-gold);"></i>
                        <h5 class="fw-bold mb-1">{{ __('Order Not Found') }}</h5>
                        <p class="mb-0" style="color: #8FA1B5;">{{ $searchError }}</p>
                    </div>
                @endif

                @if(!empty($order))
                    <div class="dd-card p-4 p-md-5 mb-4">
                        {{-- Header Details --}}
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 border-bottom mb-4" style="border-color: var(--dd-border) !important;">
                            <div>
                                <span class="dd-code-badge mb-2">{{ orderPrefix() . $order->order_id }}</span>
                                <h4 class="fw-bold mb-1 text-white">
                                    {{ !empty($order->customers) ? $order->customers->name : __('Valued Client') }}
                                </h4>
                                <p class="small mb-0" style="color: #8FA1B5;">
                                    <i class="ti ti-calendar me-1"></i>{{ __('Booked Date: ') . dateFormat($order->order_date) }}
                                </p>
                            </div>
                            <div class="text-md-end">
                                <span class="badge" style="background: var(--dd-gold-light); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.4); font-weight: 700; font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                                    {{ $order->productionStage->name ?? ucfirst($order->status) }}
                                </span>
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
                        <div class="row g-3 mt-3 pt-3 border-top" style="border-color: var(--dd-border) !important;">
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
                    <div class="dd-card p-5 text-center">
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
    </div>

    {{-- Footer --}}
    <footer class="dd-footer text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} {{ env('APP_NAME', 'DarziDesk') }}. {{ __('All rights reserved.') }}</p>
        </div>
    </footer>

</body>
</html>
