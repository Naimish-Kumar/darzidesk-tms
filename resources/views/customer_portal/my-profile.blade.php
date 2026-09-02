@extends('layouts.app')

@section('page-title')
    {{ __('My Profile') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('My Profile') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --dd-gold: #D9A441;
            --dd-gold-hover: #F4C861;
            --dd-gold-light: rgba(217, 164, 65, 0.12);
            --dd-card-bg: #FFFFFF;
            --dd-card-border: #E2E8F0;
            --dd-text-title: #0F172A;
            --dd-text-sub: #64748B;
            --dd-input-bg: #FFFFFF;
            --dd-input-border: #CBD5E1;
            --dd-input-disabled: #F1F5F9;
        }

        [data-pc-theme="dark"] {
            --dd-card-bg: #0B2239;
            --dd-card-border: #29435D;
            --dd-text-title: #FFFFFF;
            --dd-text-sub: #8FA1B5;
            --dd-input-bg: #102B45;
            --dd-input-border: #29435D;
            --dd-input-disabled: #081726;
        }

        .dd-portal-card {
            background: var(--dd-card-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
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

        .dd-form-label {
            color: var(--dd-text-title);
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .dd-form-control {
            background-color: var(--dd-input-bg) !important;
            border-color: var(--dd-input-border) !important;
            color: var(--dd-text-title) !important;
            border-radius: 10px;
            font-size: 14px;
            padding: 10px 14px;
        }

        .dd-form-control:focus {
            border-color: var(--dd-gold) !important;
            box-shadow: 0 0 0 3px var(--dd-gold-light) !important;
        }

        .dd-form-control:disabled, .dd-form-control[readonly] {
            background-color: var(--dd-input-disabled) !important;
            opacity: 0.85;
        }

        .dd-save-btn {
            background: var(--dd-gold);
            color: #03111F !important;
            border: 1px solid var(--dd-gold);
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 700;
            font-size: 13.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .dd-save-btn:hover {
            background: var(--dd-gold-hover);
            border-color: var(--dd-gold-hover);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="dd-portal-card p-4 p-md-5">
                <h4 class="fw-bold mb-1 dd-portal-title">{{ __('Account Profile & Delivery Address') }}</h4>
                <p class="dd-portal-sub mb-4">{{ __('Manage your contact details, phone number, and address for garment deliveries and fittings') }}</p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-circle-check me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Profile Avatar Section --}}
                    <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom" style="border-color: var(--dd-card-border) !important;">
                        <img src="{{ !empty($user->profile) && file_exists(public_path('storage/upload/profile/' . $user->profile)) ? asset('storage/upload/profile/' . $user->profile) : asset('storage/upload/profile/avatar.png') }}"
                            alt="Profile Photo" class="rounded-circle border" style="width: 84px; height: 84px; object-fit: cover; border-color: var(--dd-gold) !important; border-width: 2px !important;"
                            onerror="this.onerror=null;this.src='{{ asset('storage/upload/profile/avatar.png') }}';" />

                        <div class="flex-grow-1">
                            <label class="dd-form-label mb-1">{{ __('Profile Photo') }}</label>
                            <input type="file" name="profile" class="form-control form-control-sm dd-form-control" accept="image/*">
                            <small class="dd-portal-sub d-block mt-1">{{ __('Recommended: Square format JPG, PNG. Max 2MB.') }}</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="dd-form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control dd-form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="dd-form-label">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control dd-form-control" value="{{ $user->email }}" disabled title="{{ __('Email cannot be changed directly.') }}">
                            <small class="dd-portal-sub">{{ __('Registered account email address.') }}</small>
                        </div>

                        <div class="col-md-6">
                            <label class="dd-form-label">{{ __('Phone Number / WhatsApp') }}</label>
                            <input type="text" name="phone_number" class="form-control dd-form-control" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+91 9876543210">
                        </div>

                        <div class="col-md-6">
                            <label class="dd-form-label">{{ __('Account Role') }}</label>
                            <input type="text" class="form-control dd-form-control" value="Customer Portal" disabled>
                        </div>

                        <div class="col-12">
                            <label class="dd-form-label">{{ __('Primary Delivery / Fitting Address') }}</label>
                            <textarea name="address" class="form-control dd-form-control" rows="3" placeholder="{{ __('Enter house/flat number, street name, city, pincode...') }}">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4 mt-4" style="border-color: var(--dd-card-border) !important;">
                        <button type="submit" class="dd-save-btn">
                            <i class="ti ti-device-floppy"></i> {{ __('Save Profile') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
