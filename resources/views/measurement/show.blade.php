@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ measurementPrefix() . $measurement->measurement_id }} {{ __('Details') }}
@endsection

@push('css-page')
    <style>
        .dd-show-banner {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .dd-show-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #E6F4F1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dd-show-icon i {
            font-size: 24px;
            color: #00796B;
        }
        .dd-show-title {
            font-size: 22px;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 2px;
        }
        .dd-show-subtitle {
            font-size: 13.5px;
            color: #64748B;
            margin-bottom: 0;
        }

        .dd-card-box {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .dd-table th {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #F8FAFC;
            padding: 12px 16px;
        }
        .dd-table td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: 14px;
        }

        .dd-unit-pill {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            color: #00796B;
            background: #E6F4F1;
            padding: 4px 10px;
            border-radius: 12px;
        }

        .dd-toggle-btn {
            font-size: 12px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            cursor: pointer;
            border: 1px solid #CBD5E1;
            background: #FFFFFF;
            color: #475569;
            transition: all 0.2s ease;
        }
        .dd-toggle-btn.active {
            background: #00796B;
            color: #FFFFFF;
            border-color: #00796B;
        }

        .dd-timeline-item {
            position: relative;
            padding-left: 28px;
            margin-bottom: 20px;
            border-left: 2px solid #E2E8F0;
        }
        .dd-timeline-item::before {
            content: '';
            position: absolute;
            left: -7px;
            top: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #00796B;
        }
    </style>
@endpush

@section('content')
    <div class="dd-dashboard" id="invoice-print">
        {{-- Banner Card --}}
        <div class="dd-show-banner">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="dd-show-icon">
                        <i class="ti ti-file-certificate"></i>
                    </div>
                    <div>
                        <h4 class="dd-show-title">{{ measurementPrefix() . $measurement->measurement_id }}</h4>
                        <p class="dd-show-subtitle">{{ __('Customer Measurement Record & Sizing Specs') }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm print" style="border-radius: 8px;">
                        <i class="ti ti-printer me-1"></i>{{ __('Print Specs') }}
                    </button>
                    @can('edit measurement')
                        <a href="{{ route('measurement.edit', encrypt($measurement->id)) }}" class="btn text-white btn-sm" style="background:#00796B; border-radius: 8px;">
                            <i class="ti ti-pencil me-1"></i>{{ __('Edit Measurement') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        {{-- Specs & Customer Details Row --}}
        <div class="row g-4 mb-4">
            {{-- Customer Box --}}
            <div class="col-md-6">
                <div class="dd-card-box h-100">
                    <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="font-size: 11.5px; letter-spacing: 0.8px;">
                        <i class="ti ti-user me-1 text-primary"></i>{{ __('Customer Profile') }}
                    </h6>
                    <h5 class="fw-bold text-dark mb-1">
                        {{ !empty($measurement->customers) ? $measurement->customers->name : __('Walk-in Customer') }}
                    </h5>
                    <p class="text-muted mb-2" style="font-size: 13.5px;">
                        <i class="ti ti-id me-1"></i>{{ customerPrefix() }}{{ !empty($measurement->customers->customers) ? $measurement->customers->customers->customer_id : '-' }}
                    </p>
                    <p class="text-muted mb-1" style="font-size: 13.5px;">
                        <i class="ti ti-phone me-1"></i>{{ !empty($measurement->customers) ? $measurement->customers->phone_number : '-' }}
                    </p>
                    @if(!empty($measurement->customers) && !empty($measurement->customers->customers))
                        <p class="text-muted mb-0" style="font-size: 13.5px;">
                            <i class="ti ti-map-pin me-1"></i>{{ $measurement->customers->customers->address }}, {{ $measurement->customers->customers->city }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Measurement Metadata Box --}}
            <div class="col-md-6">
                <div class="dd-card-box h-100">
                    <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="font-size: 11.5px; letter-spacing: 0.8px;">
                        <i class="ti ti-info-circle me-1 text-primary"></i>{{ __('Garment & Master Details') }}
                    </h6>
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <span class="text-muted" style="font-size: 13.5px;">{{ __('Recorded Date:') }}</span>
                        <span class="fw-bold text-dark">{{ dateFormat($measurement->date) }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <span class="text-muted" style="font-size: 13.5px;">{{ __('Cloth / Garment Type:') }}</span>
                        <span class="badge" style="background:#E6F4F1; color:#00796B; font-weight:700;">
                            {{ !empty($measurement->clothTypes) ? $measurement->clothTypes->title : '-' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted" style="font-size: 13.5px;">{{ __('Responsible Master / Tailor:') }}</span>
                        <span class="fw-bold text-dark">{{ !empty($measurement->users) ? $measurement->users->name : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Current Measurement Details Card --}}
        <div class="dd-card-box mb-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3">
                <h5 class="fw-bold mb-0">{{ __('Measurement Specifications') }}</h5>
                
                {{-- Live Unit Converter Toggle --}}
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted" style="font-size: 12px; font-weight: 600;">{{ __('Display Unit:') }}</span>
                    <button type="button" class="dd-toggle-btn active" id="view-in-btn" onclick="toggleDisplayUnit('in')">Inches (in)</button>
                    <button type="button" class="dd-toggle-btn" id="view-cm-btn" onclick="toggleDisplayUnit('cm')">Centimeters (cm)</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table dd-table mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Specification Field') }}</th>
                            <th>{{ __('Recorded Measurement') }}</th>
                            <th>{{ __('Original Unit') }}</th>
                            <th>{{ __('Converted Equivalent') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($measurement->measurement_detail))
                            @foreach ($measurement->measurement_detail as $details)
                                @php
                                    $details = (object)$details;
                                    $numVal = (float)($details->measurement ?? 0);
                                    $unitStr = strtolower($details->unit ?? 'in');
                                    
                                    if(str_contains($unitStr, 'cm')) {
                                        $cmVal = $numVal;
                                        $inVal = round($numVal / 2.54, 1);
                                    } else {
                                        $inVal = $numVal;
                                        $cmVal = round($numVal * 2.54, 1);
                                    }
                                @endphp
                                <tr>
                                    <td class="fw-bold text-dark">
                                        <i class="ti ti-ruler me-1 text-primary"></i>{{ $details->type ?? 'Spec' }}
                                    </td>
                                    <td>
                                        <span class="fw-bold fs-6 val-in">{{ $inVal }} in</span>
                                        <span class="fw-bold fs-6 val-cm d-none">{{ $cmVal }} cm</span>
                                    </td>
                                    <td>
                                        <span class="dd-unit-pill">{{ $details->unit ?? 'in' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary fw-semibold val-in" style="font-size: 13px;">({{ $cmVal }} cm)</span>
                                        <span class="text-secondary fw-semibold val-cm d-none" style="font-size: 13px;">({{ $inVal }} in)</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">{{ __('No measurement details recorded') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Customer Measurement History Timeline --}}
        <div class="dd-card-box">
            <h5 class="fw-bold mb-3">
                <i class="ti ti-history me-1 text-primary"></i>{{ __('Customer Measurement History & Timeline') }}
            </h5>
            <p class="text-muted mb-4" style="font-size: 13.5px;">
                {{ __('Track how this customer\'s body measurements evolved across previous orders and updates.') }}
            </p>

            @if(isset($histories) && $histories->count() > 0)
                <div class="timeline-wrapper">
                    @foreach($histories as $history)
                        <div class="dd-timeline-item">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="fw-bold text-dark" style="font-size: 14px;">
                                    {{ $history->change_notes ?? __('Measurement Recorded') }}
                                </span>
                                <span class="text-muted" style="font-size: 12px;">
                                    <i class="ti ti-calendar me-1"></i>{{ $history->created_at->format('M d, Y - h:i A') }}
                                </span>
                            </div>
                            <p class="text-muted mb-2" style="font-size: 12.5px;">
                                {{ __('Garment Type:') }} <strong>{{ $history->clothType ? $history->clothType->title : __('Standard') }}</strong> | 
                                {{ __('Updated by:') }} <strong>{{ $history->updatedByUser ? $history->updatedByUser->name : __('System') }}</strong>
                            </p>

                            @if(!empty($history->snapshot_data))
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach((array)$history->snapshot_data as $snap)
                                        @php $snap = (object)$snap; @endphp
                                        <span class="badge" style="background:#F1F5F9; color:#334155; font-size:11.5px; font-weight:600;">
                                            {{ $snap->type ?? '' }}: {{ $snap->measurement ?? '' }} {{ $snap->unit ?? '' }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="ti ti-clock-pause fs-2 d-block mb-1 text-secondary"></i>
                    <small>{{ __('First measurement recorded. Future edits will create a historical timeline here.') }}</small>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        function toggleDisplayUnit(unit) {
            if (unit === 'in') {
                $('#view-in-btn').addClass('active');
                $('#view-cm-btn').removeClass('active');
                $('.val-in').removeClass('d-none');
                $('.val-cm').addClass('d-none');
            } else {
                $('#view-cm-btn').addClass('active');
                $('#view-in-btn').removeClass('active');
                $('.val-cm').removeClass('d-none');
                $('.val-in').addClass('d-none');
            }
        }

        $(document).on('click', '.print', function() {
            var printContents = document.getElementById('invoice-print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });
    </script>
@endpush
