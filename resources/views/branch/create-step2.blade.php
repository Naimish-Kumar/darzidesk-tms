@extends('layouts.app')

@section('page-title')
    {{ __('Add New Branch - Step 2: Manager & Operations') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">{{ __('Branches') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Add Step 2') }}</li>
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
    .step-circle.active { background: #006A67; }
    .step-lbl { font-size: 12px; font-weight: 700; color: #64748B; }
    .step-lbl.active { color: #006A67; }
    .step-line { flex: 1; height: 2px; background: #CBD5E1; }

    .form-card {
        background: #FFFFFF; border: 1px solid #E2E8F0;
        border-radius: 18px; padding: 36px; margin-bottom: 28px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    }
    .btn-save-next {
        background: #006A67; color: #FFF; border: none;
        padding: 12px 24px; border-radius: 10px;
        font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;
        cursor: pointer; text-decoration: none;
    }
    .btn-save-next:hover { background: #004D40; color: #FFF; }
</style>

<div class="stepper-container">
    <div class="step-item">
        <div class="step-circle done"><i class="ti ti-check"></i></div>
        <div class="step-lbl">Basic Info</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle active">2</div>
        <div class="step-lbl active">Manager & Operations</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle">3</div>
        <div class="step-lbl">Confirmation</div>
    </div>
</div>

<div class="form-card">
    <div class="mb-4">
        <h3 class="font-weight-bold mb-1" style="font-weight: 800;">{{ __('Manager & Operational Hours') }}</h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">{{ __('Assign a store manager and define operating capacity for') }} <strong>{{ session('branch_draft.name', 'this branch') }}</strong>.</p>
    </div>

    <form method="POST" action="{{ route('branches.store.step2') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Assign Store Manager') }}</label>
                <select name="manager_id" class="form-select">
                    <option value="">-- {{ __('Select Manager (Optional)') }} --</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ (session('branch_draft.manager_id') == $manager->id) ? 'selected' : '' }}>
                            {{ $manager->name }} ({{ ucfirst($manager->type) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Operating Hours') }}</label>
                <input type="text" name="operating_hours" class="form-control" placeholder="e.g. Mon - Sat: 9:00 AM - 8:00 PM" value="{{ old('operating_hours', session('branch_draft.operating_hours', 'Mon - Sat: 09:00 - 19:00')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Daily Fitting Capacity (Orders)') }}</label>
                <input type="number" name="capacity" class="form-control" placeholder="e.g. 25" value="{{ old('capacity', session('branch_draft.capacity', 20)) }}">
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <a href="{{ route('branches.create.step1') }}" class="btn btn-outline-secondary fw-bold">{{ __('Back') }}</a>
            <button type="submit" class="btn-save-next">
                {{ __('Review & Finalize') }}
                <i class="ti ti-arrow-right me-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection
