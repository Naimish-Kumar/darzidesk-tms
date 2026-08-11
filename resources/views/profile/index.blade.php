@extends('layouts.app')

@section('page-title')
    {{ __('Business & Atelier Profile') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Business Profile') }}</li>
    </ul>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center p-4">
            <div class="mb-3">
                <div class="d-inline-flex align-items-center justify-content-center bg-light-teal text-teal rounded-circle" style="width: 80px; height: 80px; background:#E6F4F1; color:#006A67;">
                    <i class="ti ti-building-store" style="font-size: 36px;"></i>
                </div>
            </div>
            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
            <p class="badge bg-light-primary text-primary px-3 py-2 text-uppercase mb-3" style="font-size:11px;">{{ ucfirst($user->type) }} {{ __('Account') }}</p>

            <div class="border-top pt-3 text-start">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted" style="font-size: 13px;">Email Address</span>
                    <span class="fw-bold font-monospace" style="font-size: 13px;">{{ $user->email }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted" style="font-size: 13px;">Phone</span>
                    <span class="fw-bold font-monospace" style="font-size: 13px;">{{ $user->phone_number ?? 'N/A' }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size: 13px;">Account Status</span>
                    <span class="badge bg-success">Active Verified</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">{{ __('Edit Atelier & Business Details') }}</h5>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('Business / Owner Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('Work Email Address') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control font-monospace" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('WhatsApp / Phone') }}</label>
                        <input type="text" name="phone_number" class="form-control font-monospace" value="{{ old('phone_number', $user->phone_number) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('Profile Image / Logo') }}</label>
                        <input type="file" name="avatar" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4" style="background:#006A67; border:none; border-radius:8px; font-weight:700;">
                        <i class="ti ti-device-floppy me-1"></i> {{ __('Save Business Profile') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
