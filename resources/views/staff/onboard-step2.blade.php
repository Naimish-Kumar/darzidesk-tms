@extends('layouts.app')

@section('page-title')
    {{ __('Staff Onboarding - Step 2: Branch Assignment & Shift') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">{{ __('Staff') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Onboard Step 2') }}</li>
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
    .step-circle.done { background: #10B981; }
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
        <div class="step-circle done"><i class="ti ti-check"></i></div>
        <div class="step-lbl">Basic Details</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle active">2</div>
        <div class="step-lbl active">Assignment & Shift</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle">3</div>
        <div class="step-lbl">Review & Confirm</div>
    </div>
</div>

<div class="form-card">
    <div class="mb-4">
        <h3 class="font-weight-bold mb-1" style="font-weight: 800;">{{ __('Branch & Shift Allocation') }}</h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">{{ __('Assign') }} <strong>{{ session('staff_onboard_draft.name', 'the new staff member') }}</strong> {{ __('to a boutique branch and work schedule.') }}</p>
    </div>

    <form method="POST" action="{{ route('staff.onboard.store.step2') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Primary Branch Location') }}</label>
                <select name="branch_id" class="form-select">
                    <option value="">-- {{ __('Select Branch') }} --</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ session('staff_onboard_draft.branch_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->name }} ({{ $b->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Specialization') }}</label>
                <input type="text" name="specialization" class="form-control" placeholder="e.g. Bespoke Tuxedos & Italian Wool" value="{{ old('specialization', session('staff_onboard_draft.specialization')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Work Shift') }}</label>
                <select name="shift" class="form-select">
                    <option value="Full Time (09:00 - 18:00)">Full Time (09:00 - 18:00)</option>
                    <option value="Morning Shift (08:00 - 14:00)">Morning Shift (08:00 - 14:00)</option>
                    <option value="Evening Shift (14:00 - 20:00)">Evening Shift (14:00 - 20:00)</option>
                </select>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <a href="{{ route('staff.onboard.step1') }}" class="btn btn-outline-secondary fw-bold">{{ __('Back') }}</a>
            <button type="submit" class="btn-save-next">
                {{ __('Next Step') }}
                <i class="ti ti-arrow-right me-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection
