<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Job Card') }} - {{ orderPrefix() . $order->order_id }}</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Hanken Grotesk', -apple-system, sans-serif;
            color: #0f172a;
            padding: 30px 15px;
        }

        .job-card-container {
            max-width: 780px;
            margin: 0 auto;
            background: #ffffff;
            border: 2px solid #0f172a;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .job-card-header {
            border-bottom: 2px dashed #cbd5e1;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .job-badge {
            display: inline-block;
            background: #0f172a;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .spec-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
        }

        .spec-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .spec-value {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }

        .measurement-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .measurement-table th {
            background: #0f172a;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 8px 12px;
            text-align: left;
        }

        .measurement-table td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .measurement-table tr:nth-child(even) td {
            background: #f8fafc;
        }

        .qr-placeholder {
            border: 2px dashed #0f172a;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background: #fafafa;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .job-card-container {
                box-shadow: none;
                border: 2px solid #000000;
                padding: 20px;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Action Bar (Hidden on Print) -->
    <div class="no-print text-center mb-4">
        <button onclick="window.print()" class="btn btn-primary fw-bold px-4 py-2 me-2 shadow-sm">
            <i class="ti ti-printer me-1"></i> {{ __('Print Job Card (A5)') }}
        </button>
        <a href="{{ route('order.show', encrypt($order->id)) }}" class="btn btn-outline-secondary fw-bold px-4 py-2">
            <i class="ti ti-arrow-left me-1"></i> {{ __('Back to Order') }}
        </a>
    </div>

    <!-- Job Card Container -->
    <div class="job-card-container">
        
        <!-- Header -->
        <div class="job-card-header d-flex align-items-center justify-content-between">
            <div>
                <span class="job-badge">{{ __('WORKSHOP GARMENT JOB CARD') }}</span>
                <h2 class="fw-extrabold text-dark mt-2 mb-0" style="font-size: 24px; letter-spacing: -0.5px;">
                    {{ orderPrefix() . $order->order_id }}
                </h2>
                <small class="text-muted">{{ __('Generated on') }} {{ dateFormat(now()) }}</small>
            </div>
            <div class="text-end">
                <h4 class="fw-bold mb-0 text-primary">{{ $settings['company_name'] ?? env('APP_NAME') }}</h4>
                <small class="text-muted d-block">{{ $settings['company_phone'] ?? '' }}</small>
            </div>
        </div>

        <!-- Order Meta Grid -->
        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="spec-box">
                    <div class="spec-label">{{ __('Customer') }}</div>
                    <div class="spec-value">{{ !empty($order->customers) ? $order->customers->name : '-' }}</div>
                    <small class="text-muted d-block mt-1">{{ !empty($order->customers) ? $order->customers->phone_number : '' }}</small>
                </div>
            </div>
            <div class="col-4">
                <div class="spec-box">
                    <div class="spec-label">{{ __('Garment / Cloth Type') }}</div>
                    <div class="spec-value text-capitalize">{{ !empty($order->clothTypes) ? $order->clothTypes->title : '-' }}</div>
                    <small class="text-muted d-block mt-1">{{ __('Fabric') }}: {{ $order->febric ?? 'Standard' }} ({{ $order->febric_color ?? '-' }})</small>
                </div>
            </div>
            <div class="col-4">
                <div class="spec-box">
                    <div class="spec-label">{{ __('Assigned Master Tailor') }}</div>
                    <div class="spec-value">{{ !empty($order->users) ? $order->users->name : '-' }}</div>
                    <small class="text-muted d-block mt-1">{{ __('Stage') }}: {{ $order->productionStage->name ?? ucfirst($order->status) }}</small>
                </div>
            </div>
        </div>

        <!-- Schedule / Key Dates -->
        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="p-2 border rounded text-center bg-light">
                    <span class="spec-label">{{ __('Order Date') }}</span>
                    <div class="fw-bold text-dark fs-6">{{ dateFormat($order->order_date) }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 border border-warning rounded text-center bg-light-warning">
                    <span class="spec-label text-warning">{{ __('Trial / Fitting Date') }}</span>
                    <div class="fw-bold text-dark fs-6">{{ !empty($order->trial_date) ? dateFormat($order->trial_date) : __('Not Scheduled') }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="p-2 border border-danger rounded text-center bg-light-danger">
                    <span class="spec-label text-danger">{{ __('Deadline Date') }}</span>
                    <div class="fw-bold text-dark fs-6">{{ dateFormat($order->deadline_date) }}</div>
                </div>
            </div>
        </div>

        <!-- Measurement Details Specification Table -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="fw-bold text-dark uppercase mb-0" style="letter-spacing: 0.5px;">
                    <i class="ti ti-ruler me-1"></i> {{ __('BODY MEASUREMENTS SPECIFICATION') }}
                </h6>
                <span class="badge bg-dark text-white px-2 py-1">{{ __('Qty') }}: {{ $order->quantity ?? 1 }}</span>
            </div>

            @php
                $measurements = $order->measurement ?? [];
            @endphp

            @if(!empty($measurements) && is_array($measurements))
                <table class="measurement-table">
                    <thead>
                        <tr>
                            <th>{{ __('Measurement Parameter') }}</th>
                            <th>{{ __('Specification / Size') }}</th>
                            <th>{{ __('Notes / Adjustments') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($measurements as $key => $val)
                            @if(!in_array($key, ['_token', 'id', 'created_at', 'updated_at']) && !is_array($val))
                                <tr>
                                    <td class="text-capitalize">{{ str_replace(['_', '-'], ' ', $key) }}</td>
                                    <td><strong class="text-primary fs-6">{{ $val }}</strong></td>
                                    <td class="text-muted small">-</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-light border text-center text-muted py-3">
                    {{ __('No custom body measurement values recorded.') }}
                </div>
            @endif
        </div>

        <!-- Stitching Notes & Instructions -->
        @if(!empty($order->notes))
            <div class="p-3 border rounded bg-light mb-4">
                <span class="spec-label">{{ __('Special Stitching Instructions') }}</span>
                <p class="mb-0 fw-semibold text-dark small mt-1">{{ $order->notes }}</p>
            </div>
        @endif

        <!-- Footer / QR Tag -->
        <div class="pt-3 border-top d-flex align-items-center justify-content-between">
            <div>
                <small class="text-muted d-block">{{ __('Please attach this Job Card to the fabric cut during tailoring.') }}</small>
                <strong class="small text-dark">{{ __('DarziDesk Tailoring TMS') }}</strong>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <small class="spec-label d-block">{{ __('Scan to Track') }}</small>
                    <span class="badge bg-light-primary text-primary fw-mono">#{{ orderPrefix() . $order->order_id }}</span>
                </div>
                <div class="qr-placeholder">
                    {!! QrCode::size(54)->generate(route('order.public.track', $order->tracking_token ?? $order->id)) !!}
                </div>
            </div>
        </div>

    </div>

</body>
</html>
