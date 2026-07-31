@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Create Measurement') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('measurement.index') }}">{{ __('Measurement') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
@endsection

@push('css-page')
    <style>
        .dd-measure-banner {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .dd-measure-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #E6F4F1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dd-measure-icon i {
            font-size: 24px;
            color: #00796B;
        }
        .dd-measure-title {
            font-size: 22px;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 2px;
        }
        .dd-measure-subtitle {
            font-size: 13.5px;
            color: #64748B;
            margin-bottom: 0;
        }
        
        /* Unit converter bar */
        .dd-converter-bar {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .dd-converter-pill {
            font-size: 12.5px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 20px;
            cursor: pointer;
            border: 1px solid #CBD5E1;
            background: #FFFFFF;
            color: #475569;
            transition: all 0.2s ease;
        }
        .dd-converter-pill.active {
            background: #00796B;
            color: #FFFFFF;
            border-color: #00796B;
        }
        .dd-convert-hint {
            font-size: 12px;
            color: #64748B;
            font-weight: 600;
        }

        /* Spec Cards */
        .dd-spec-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .dd-spec-card:hover {
            border-color: #00796B;
            background: #E6F4F1;
            transform: translateY(-2px);
        }
        .dd-spec-card i {
            font-size: 20px;
            color: #00796B;
            display: block;
            margin-bottom: 4px;
        }
        .dd-spec-card span {
            font-size: 12px;
            font-weight: 700;
            color: #1E293B;
        }

        .dd-table-container {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            overflow: hidden;
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
        }
        .dd-converted-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            font-weight: 700;
            color: #00796B;
            background: #E6F4F1;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="dd-dashboard wrapper">
        {{-- Banner Card --}}
        <div class="dd-measure-banner">
            <div class="d-flex align-items-center gap-3">
                <div class="dd-measure-icon">
                    <i class="ti ti-ruler-measure"></i>
                </div>
                <div>
                    <h4 class="dd-measure-title">{{ __('Record Customer Measurement') }}</h4>
                    <p class="dd-measure-subtitle">{{ __('Enter garment sizing with instant Inches ↔ Centimeters live conversion') }}</p>
                </div>
            </div>
        </div>

        {{-- Form Container --}}
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4">
                {{ Form::open(['url' => 'measurement', 'method' => 'post', 'id' => 'measurementForm']) }}
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Measurement Number') }}</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold" style="background:#F8FAFC; color:#00796B;">
                                {{ measurementPrefix() }}
                            </span>
                            {{ Form::text('measurement_id', $measurementNumber, ['class' => 'form-control', 'placeholder' => __('Enter measurement Number'), 'style' => 'border-radius: 0 10px 10px 0;']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Date') }} <span class="text-danger">*</span></label>
                        {{ Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'required' => 'required', 'style' => 'border-radius: 10px;']) }}
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Customer') }} <span class="text-danger">*</span></label>
                        {!! Form::select('customer', $customer, old('customer'), ['class' => 'form-control select2', 'required' => 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Cloth / Garment Type') }} <span class="text-danger">*</span></label>
                        {!! Form::select('cloth_type', $clothType, null, ['class' => 'form-control select2', 'id' => 'cloth_type', 'required' => 'required']) !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Responsible Master / Tailor') }}</label>
                        {!! Form::select('responsible', $user, old('responsible'), ['class' => 'form-control select2']) !!}
                    </div>
                </div>

                {{-- Converter Bar --}}
                <div class="dd-converter-bar">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold text-dark" style="font-size: 13px;">{{ __('Active Input Unit:') }}</span>
                        <span class="dd-converter-pill active" id="unit-in-pill" onclick="setPrimaryUnit('in')">
                            📏 Inches (in)
                        </span>
                        <span class="dd-converter-pill" id="unit-cm-pill" onclick="setPrimaryUnit('cm')">
                            📐 Centimeters (cm)
                        </span>
                    </div>
                    <div class="dd-convert-hint">
                        💡 <span id="convert-rule-text">Live conversion enabled: 1 in = 2.54 cm</span>
                    </div>
                </div>

                {{-- Visual Spec Cards Bar --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold mb-2" style="font-size: 13.5px;">{{ __('Quick Add Garment Spec Fields:') }}</label>
                    <div class="row g-2">
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="dd-spec-card" onclick="addQuickSpec('Chest / Bust')">
                                <i class="ti ti-vector-triangle"></i>
                                <span>Chest / Bust</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="dd-spec-card" onclick="addQuickSpec('Waist')">
                                <i class="ti ti-circle-half-vertical"></i>
                                <span>Waist</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="dd-spec-card" onclick="addQuickSpec('Hips')">
                                <i class="ti ti-arrows-horizontal"></i>
                                <span>Hips</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="dd-spec-card" onclick="addQuickSpec('Shoulder Width')">
                                <i class="ti ti-ruler-measure"></i>
                                <span>Shoulder</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="dd-spec-card" onclick="addQuickSpec('Inseam Length')">
                                <i class="ti ti-arrows-vertical"></i>
                                <span>Inseam</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="dd-spec-card" onclick="addQuickSpec('Neck Circumference')">
                                <i class="ti ti-circle-dot"></i>
                                <span>Neck</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Measurement Table --}}
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">{{ __('Measurement Specifications') }}</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm measure_type_clone" style="border-radius: 8px;">
                        <i class="ti ti-plus me-1"></i>{{ __('Add Spec Field') }}
                    </button>
                </div>

                <div class="dd-table-container mb-4">
                    <table class="table dd-table mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Measurement Type / Spec Name') }}</th>
                                <th>{{ __('Value') }}</th>
                                <th>{{ __('Input Unit') }}</th>
                                <th>{{ __('Live Equivalent') }}</th>
                                <th class="text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="measurement_tbody">
                            {{-- Rows appended dynamically --}}
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <a href="{{ route('measurement.index') }}" class="btn btn-light me-2" style="border-radius: 10px;">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background: #00796B; border-radius: 10px;">
                        <i class="ti ti-check me-1"></i>{{ __('Save Measurement') }}
                    </button>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        let currentPrimaryUnit = 'in';

        function setPrimaryUnit(unit) {
            currentPrimaryUnit = unit;
            if (unit === 'in') {
                $('#unit-in-pill').addClass('active');
                $('#unit-cm-pill').removeClass('active');
                $('#convert-rule-text').text('Live conversion enabled: 1 in = 2.54 cm');
            } else {
                $('#unit-cm-pill').addClass('active');
                $('#unit-in-pill').removeClass('active');
                $('#convert-rule-text').text('Live conversion enabled: 1 cm = 0.3937 in');
            }

            // Update all row units and trigger recalculation
            $('.unit-select-input').val(unit);
            recalculateAllConversions();
        }

        function calculateConversion(value, unit) {
            const num = parseFloat(value);
            if (isNaN(num) || num <= 0) return '-';
            
            if (unit === 'in' || unit === 'inches') {
                const cm = (num * 2.54).toFixed(1);
                return cm + ' cm';
            } else if (unit === 'cm' || unit === 'centimeters') {
                const inches = (num / 2.54).toFixed(1);
                return inches + ' in';
            }
            return num + ' ' + unit;
        }

        function handleValInput(inputEl) {
            const row = $(inputEl).closest('tr');
            const val = $(inputEl).val();
            const unit = row.find('.unit-select-input').val();
            const convertedText = calculateConversion(val, unit);
            row.find('.live-converted-text').text(convertedText);
        }

        function recalculateAllConversions() {
            $('.measure-val-input').each(function() {
                handleValInput(this);
            });
        }

        function addMeasurementRow(typeTitle = '', val = '', unit = currentPrimaryUnit) {
            const converted = calculateConversion(val, unit);
            const row = `
                <tr class="measure_type">
                    <td>
                        <input type="text" class="form-control" name="type[]" value="${typeTitle}" placeholder="e.g., Chest, Waist" required style="border-radius: 8px;">
                    </td>
                    <td>
                        <input type="number" step="0.1" class="form-control measure-val-input" name="measurement[]" value="${val}" placeholder="0.0" oninput="handleValInput(this)" required style="border-radius: 8px;">
                    </td>
                    <td>
                        <select name="unit[]" class="form-select unit-select-input" onchange="handleValInput($(this).closest('tr').find('.measure-val-input'))" style="border-radius: 8px;">
                            <option value="in" ${unit === 'in' ? 'selected' : ''}>Inches (in)</option>
                            <option value="cm" ${unit === 'cm' ? 'selected' : ''}>Centimeters (cm)</option>
                            <option value="m" ${unit === 'm' ? 'selected' : ''}>Meters (m)</option>
                            <option value="yd" ${unit === 'yd' ? 'selected' : ''}>Yards (yd)</option>
                        </select>
                    </td>
                    <td>
                        <span class="dd-converted-badge live-converted-text">${converted}</span>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm cloth_type_remove" style="border-radius: 8px;">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#measurement_tbody').append(row);
        }

        function addQuickSpec(specTitle) {
            addMeasurementRow(specTitle, '', currentPrimaryUnit);
        }

        $(document).ready(function() {
            // Default 3 initial fields
            addMeasurementRow('Chest / Bust');
            addMeasurementRow('Waist');
            addMeasurementRow('Hips');

            $('#cloth_type').on('change', function() {
                var cloty_type_id = $(this).val();
                if (!cloty_type_id) return;
                
                $.ajax({
                    url: '{{ route('measurement.type') }}',
                    type: 'GET',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { 'cloty_type_id': cloty_type_id },
                    success: function(data) {
                        var response = JSON.parse(data);
                        $('#measurement_tbody').empty();

                        response.forEach(function(item) {
                            var unitVal = (item.units && item.units.unit) ? item.units.unit.toLowerCase() : 'in';
                            if (unitVal.includes('cm')) unitVal = 'cm';
                            else unitVal = 'in';
                            
                            addMeasurementRow(item.title, '', unitVal);
                        });
                    }
                });
            });

            $('.wrapper').on('click', '.cloth_type_remove', function() {
                $(this).closest('tr').remove();
            });

            $('.wrapper').on('click', '.measure_type_clone', function() {
                addMeasurementRow('', '', currentPrimaryUnit);
            });
        });
    </script>
@endpush
