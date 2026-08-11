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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="dd-card p-4 p-md-5">
                <h4 class="fw-bold mb-1 text-dark">{{ __('Account Profile & Delivery Address') }}</h4>
                <p class="text-muted small mb-4">{{ __('Manage your contact details and address for garment deliveries and measurements') }}</p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-circle-check me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Profile Avatar Section --}}
                    <div class="d-flex align-items-center gap-4 mb-4 pb-3 border-bottom">
                        <img src="{{ !empty($user->profile) && file_exists(public_path('storage/upload/profile/' . $user->profile)) ? asset('storage/upload/profile/' . $user->profile) : asset('storage/upload/profile/avatar.png') }}"
                            alt="Profile Photo" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;"
                            onerror="this.onerror=null;this.src='{{ asset('storage/upload/profile/avatar.png') }}';" />

                        <div>
                            <label class="form-label fw-bold mb-1">{{ __('Profile Photo') }}</label>
                            <input type="file" name="profile" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted d-block mt-1">{{ __('Allowed formats: JPG, PNG, GIF. Max 2MB.') }}</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled title="{{ __('Email cannot be changed directly.') }}">
                            <small class="text-muted">{{ __('Registered account email address.') }}</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">{{ __('Phone Number / WhatsApp') }}</label>
                            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+91 9876543210">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">{{ __('Account Role') }}</label>
                            <input type="text" class="form-control bg-light" value="Customer Portal" disabled>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">{{ __('Primary Delivery / Fitting Address') }}</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="{{ __('Enter house/flat number, street name, city, pincode...') }}">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4 mt-4">
                        <button type="submit" class="btn btn-primary" style="background: var(--dd-teal); border-color: var(--dd-teal); min-width: 140px;">
                            <i class="ti ti-device-floppy me-1"></i> {{ __('Save Profile') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
