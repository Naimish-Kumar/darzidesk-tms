@extends('layouts.app')

@section('page-title')
    {{ __('Staff Onboarding - Step 1: Identity & Credentials') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">{{ __('Staff') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Onboard Step 1') }}</li>
    </ul>
@endsection

@section('content')
<style>
    .stepper-container {
        display: flex; align-items: center; justify-content: center;
        gap: 16px; padding: 16px 0 28px; max-width: 600px; margin: 0 auto;
    }
    .step-item { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .step-circle {
        width: 36px; height: 36px; border-radius: 50%; background: #CBD5E1; color: #FFF;
        font-size: 14px; font-weight: 800; display: flex; align-items: center; justify-content: center;
    }
    .step-circle.active { background: #26A69A; }
    .step-lbl { font-size: 12px; font-weight: 700; color: #64748B; }
    .step-lbl.active { color: #26A69A; }
    .step-line { flex: 1; height: 2px; background: #CBD5E1; }

    .form-card {
        background: #FFFFFF; border: 1px solid #E2E8F0;
        border-radius: 18px; padding: 36px; margin-bottom: 28px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    }
    .btn-save-next {
        background: #26A69A; color: #FFF; border: none;
        padding: 12px 24px; border-radius: 10px;
        font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;
        cursor: pointer; text-decoration: none;
    }
    .btn-save-next:hover { background: #006A67; color: #FFF; }
</style>

<div class="stepper-container">
    <div class="step-item">
        <div class="step-circle active">1</div>
        <div class="step-lbl active">Basic Details</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle">2</div>
        <div class="step-lbl">Assignment & Shift</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle">3</div>
        <div class="step-lbl">Review & Confirm</div>
    </div>
</div>

<div class="form-card">
    <div class="mb-4">
        <h3 class="font-weight-bold mb-1" style="font-weight: 800;">{{ __('Staff Personal Information') }}</h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">{{ __('Enter the full name, work email address, and role for the new artisan or staff member.') }}</p>
    </div>

    <form method="POST" action="{{ route('staff.onboard.store.step1') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Marco Rossi" required value="{{ old('name', session('staff_onboard_draft.name')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="marco@tailorshop.com" required value="{{ old('email', session('staff_onboard_draft.email')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Phone Number') }}</label>
                <input type="text" name="phone_number" class="form-control" placeholder="+44 7700 900077" value="{{ old('phone_number', session('staff_onboard_draft.phone_number')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Designation / Role') }}</label>
                <select name="role" class="form-select">
                    <option value="Master Tailor" {{ session('staff_onboard_draft.role') == 'Master Tailor' ? 'selected' : '' }}>Master Tailor</option>
                    <option value="Cutter & Pattern Maker" {{ session('staff_onboard_draft.role') == 'Cutter & Pattern Maker' ? 'selected' : '' }}>Cutter & Pattern Maker</option>
                    <option value="Finisher & Presser" {{ session('staff_onboard_draft.role') == 'Finisher & Presser' ? 'selected' : '' }}>Finisher & Presser</option>
                    <option value="Front Desk Consultant" {{ session('staff_onboard_draft.role') == 'Front Desk Consultant' ? 'selected' : '' }}>Front Desk Consultant</option>
                </select>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <a href="{{ route('staff.index') }}" class="btn btn-link text-muted fw-bold">{{ __('Cancel') }}</a>
            <button type="submit" class="btn-save-next">
                {{ __('Next Step') }}
                <i class="ti ti-arrow-right me-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection
