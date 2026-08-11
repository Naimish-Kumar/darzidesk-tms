@extends('layouts.app')

@section('page-title')
    {{ __('Add New Branch - Step 1: Basic Info') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">{{ __('Branches') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Add Step 1') }}</li>
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
        <div class="step-circle active">1</div>
        <div class="step-lbl active">Basic Info</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle">2</div>
        <div class="step-lbl">Manager & Operations</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle">3</div>
        <div class="step-lbl">Confirmation</div>
    </div>
</div>

<div class="form-card">
    <div class="mb-4">
        <h3 class="font-weight-bold mb-1" style="font-weight: 800;">{{ __('Branch Identity & Contact') }}</h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">{{ __('Provide the essential identification and contact details for your new workspace.') }}</p>
    </div>

    <form method="POST" action="{{ route('branches.store.step1') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Branch / Studio Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Savile Row Atelier" required value="{{ old('name', session('branch_draft.name')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Branch Code') }} <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control font-monospace" placeholder="e.g. BR-LON-01" required value="{{ old('code', session('branch_draft.code', 'BR-'.rand(100,999))) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Contact Phone') }}</label>
                <input type="text" name="phone" class="form-control" placeholder="+44 20 7123 4567" value="{{ old('phone', session('branch_draft.phone')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Full Physical Address') }}</label>
                <input type="text" name="address" class="form-control" placeholder="14 Savile Row, Mayfair, London" value="{{ old('address', session('branch_draft.address')) }}">
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <a href="{{ route('branches.index') }}" class="btn btn-link text-muted fw-bold">{{ __('Cancel') }}</a>
            <button type="submit" class="btn-save-next">
                {{ __('Save & Next') }}
                <i class="ti ti-arrow-right me-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection
