<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order #{{ orderPrefix() . $order->order_id }} - DarziDesk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', system-ui, sans-serif; }
        .hero-banner { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; padding: 40px 0 60px; }
        .step-bubble { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin: 0 auto 8px; z-index: 2; position: relative; }
        .step-line { position: absolute; top: 18px; left: 0; right: 0; height: 4px; background-color: #e2e8f0; z-index: 1; }
        .step-progress-active { background-color: #3b82f6; }
    </style>
</head>
<body>

    <!-- Hero Header -->
    <div class="hero-banner shadow-sm">
        <div class="container text-center">
            <span class="badge bg-primary px-3 py-2 fs-6 mb-2">Order Tracking</span>
            <h2 class="fw-bold mb-1">Order #{{ orderPrefix() . $order->order_id }}</h2>
            <p class="text-white-50 mb-0">Customer: <strong>{{ $order->customers->name ?? 'Valued Customer' }}</strong></p>
        </div>
    </div>

    <!-- Content Container -->
    <div class="container" style="margin-top: -30px;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-12">
                <!-- Timeline Card -->
                <div class="card shadow-lg border-0 mb-4 rounded-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-4 text-center">Current Production Progress</h5>

                        @php
                            $currentStageIndex = $order->productionStage->order_index ?? 1;
                            $totalStages = $allStages->count();
                        @endphp

                        <div class="position-relative py-3">
                            <div class="step-line"></div>
                            <div class="row text-center">
                                @foreach($allStages as $stage)
                                    @php
                                        $isDone = $stage->order_index <= $currentStageIndex;
                                        $isCurrent = $stage->order_index == $currentStageIndex;
                                    @endphp
                                    <div class="col">
                                        <div class="step-bubble {{ $isDone ? 'bg-primary text-white' : 'bg-light text-muted border' }}">
                                            @if($isDone) <i class="ti ti-check"></i> @else {{ $stage->order_index }} @endif
                                        </div>
                                        <div class="fw-bold small {{ $isCurrent ? 'text-primary' : ($isDone ? 'text-dark' : 'text-muted') }}">
                                            {{ $stage->name }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-center mt-4 pt-3 border-top">
                            <span class="fs-6 text-muted me-2">Estimated Delivery:</span>
                            <span class="fw-bold fs-5 text-dark"><i class="ti ti-calendar me-1 text-primary"></i>{{ dateFormat($order->deadline_date) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Details & Digital Receipt Card -->
                <div class="row">
                    <div class="col-md-7 col-12 mb-4">
                        <div class="card shadow-sm border-0 h-100 rounded-3">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold"><i class="ti ti-shirt text-primary me-2"></i>Garment Specifications</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                        <span class="text-muted">Garment / Cloth Type</span>
                                        <span class="fw-semibold text-dark">{{ $order->clothTypes->title ?? 'Custom Garment' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                        <span class="text-muted">Quantity</span>
                                        <span class="fw-semibold text-dark">{{ $order->quantity }} pcs</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                        <span class="text-muted">Fabric Selection</span>
                                        <span class="fw-semibold text-dark">{{ $order->febric ?? 'Customer Supplied' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                                        <span class="text-muted">Color</span>
                                        <span class="fw-semibold text-dark">{{ $order->febric_color ?? 'Standard' }}</span>
                                    </li>
                                </ul>
                                @if(!empty($order->notes))
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <small class="text-muted fw-bold d-block mb-1">Tailoring Notes:</small>
                                        <small class="text-dark">{{ $order->notes }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-12 mb-4">
                        <div class="card shadow-sm border-0 h-100 rounded-3">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold"><i class="ti ti-receipt text-success me-2"></i>Digital Receipt</h5>
                                <a href="{{ route('order.public.qr-receipt', $order->tracking_token ?? $order->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-printer me-1"></i> Print Slip
                                </a>
                            </div>
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <!-- QR Code Generator via API -->
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(route('order.public.track', $order->tracking_token ?? $order->id)) }}" alt="QR Code" class="img-fluid rounded border p-2">
                                </div>
                                <small class="text-muted d-block mb-3">Scan QR code to view live status on mobile</small>
                                <div class="alert alert-info py-2 mb-0">
                                    <i class="ti ti-info-circle me-1"></i> Keep your tracking token safe for appointment check-in.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center text-muted py-4">
                    <small>Powered by <strong>DarziDesk Tailoring Management System</strong></small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
