@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Measurement Units') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Measurement Unit') }}</li>
@endsection

@push('css-page')
    <style>
        .dd-unit-banner {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .dd-unit-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #E6F4F1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dd-unit-icon i {
            font-size: 24px;
            color: #00796B;
        }
        .dd-unit-title {
            font-size: 22px;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 2px;
        }
        .dd-unit-subtitle {
            font-size: 13.5px;
            color: #64748B;
            margin-bottom: 0;
        }
        .dd-btn-primary {
            background: #00796B;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            padding: 9px 20px;
            font-size: 13.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dd-btn-primary:hover {
            background: #004D40;
            color: #FFFFFF;
            text-decoration: none;
        }
        .dd-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .dd-table th {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            background: #F8FAFC;
            padding: 14px 20px;
            border-bottom: 1px solid #E2E8F0;
        }
        .dd-table td {
            font-size: 14px;
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #E2E8F0;
        }
        .dd-table tr:hover td {
            background: #E6F4F1;
        }
        .dd-unit-pill {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            font-weight: 700;
            color: #00796B;
            background: #E6F4F1;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .dd-action-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            text-decoration: none;
            border: 1px solid #E2E8F0;
            background: #FFFFFF;
        }
        .dd-action-edit {
            color: #00796B;
        }
        .dd-action-edit:hover {
            background: #00796B;
            color: #FFFFFF;
            border-color: #00796B;
        }
        .dd-action-delete {
            color: #EF4444;
        }
        .dd-action-delete:hover {
            background: #EF4444;
            color: #FFFFFF;
            border-color: #EF4444;
        }
    </style>
@endpush

@section('content')
    <div class="dd-dashboard">
        {{-- Banner Card --}}
        <div class="dd-unit-banner">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="dd-unit-icon">
                        <i class="ti ti-ruler-2"></i>
                    </div>
                    <div>
                        <h4 class="dd-unit-title">{{ __('Measurement Units') }}</h4>
                        <p class="dd-unit-subtitle">{{ __('Manage standard measurement units for garment sizing and tailoring dimensions') }}</p>
                    </div>
                </div>
                <div>
                    @if (Gate::check('create measurement unit'))
                        <a class="dd-btn-primary customModal" href="#" data-size="md"
                            data-url="{{ route('measurement-unit.create') }}" data-title="{{ __('Create Measurement Unit') }}">
                            <i class="ti ti-plus" style="font-size: 16px;"></i>
                            {{ __('Create Unit') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="dd-card">
            <div class="table-responsive">
                <table class="table dd-table advance-datatable mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Measurement Unit') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                            <tr>
                                <td>
                                    <span class="dd-unit-pill">
                                        <i class="ti ti-ruler me-1"></i> {{ $unit->unit }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        @can('edit measurement unit')
                                            <a class="dd-action-btn dd-action-edit customModal"
                                                data-bs-toggle="tooltip" data-size="md"
                                                data-bs-original-title="{{ __('Edit') }}" href="#"
                                                data-url="{{ route('measurement-unit.edit', encrypt($unit->id)) }}"
                                                data-title="{{ __('Edit Unit') }}">
                                                <i class="ti ti-pencil" style="font-size: 16px;"></i>
                                            </a>
                                        @endcan
                                        @can('delete measurement unit')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['measurement-unit.destroy', encrypt($unit->id)], 'class' => 'd-inline mb-0']) !!}
                                                <a class="dd-action-btn dd-action-delete confirm_dialog"
                                                    data-bs-toggle="tooltip" data-bs-original-title="{{ __('Delete') }}"
                                                    href="#">
                                                    <i class="ti ti-trash" style="font-size: 16px;"></i>
                                                </a>
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
