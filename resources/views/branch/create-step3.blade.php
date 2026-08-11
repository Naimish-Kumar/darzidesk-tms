@extends('layouts.app')

@section('page-title')
    {{ __('Add New Branch - Step 3: Confirmation') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">{{ __('Branches') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Add Step 3') }}</li>
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

    .summary-card {
        background: #FFFFFF; border: 1px solid #E2E8F0;
        border-radius: 18px; padding: 36px; margin-bottom: 28px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    }
    .btn-create-branch {
        background: #006A67; color: #FFF; border: none;
        padding: 12px 28px; border-radius: 10px;
        font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;
        cursor: pointer; text-decoration: none;
    }
    .btn-create-branch:hover { background: #004D40; color: #FFF; }
</style>

<div class="stepper-container">
    <div class="step-item">
        <div class="step-circle done"><i class="ti ti-check"></i></div>
        <div class="step-lbl">Basic Info</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle done"><i class="ti ti-check"></i></div>
        <div class="step-lbl">Manager & Operations</div>
    </div>
    <div class="step-line"></div>
    <div class="step-item">
        <div class="step-circle active">3</div>
        <div class="step-lbl active">Confirmation</div>
    </div>
</div>

<div class="summary-card">
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-light-success text-success rounded-circle mb-3" style="width:64px; height:64px;">
            <i class="ti ti-building-store" style="font-size: 32px;"></i>
        </div>
        <h3 class="font-weight-bold mb-1" style="font-weight: 800;">{{ __('Confirm Branch Creation') }}</h3>
        <p class="text-muted" style="font-size: 13.5px;">{{ __('Review your branch setup details before publishing to your DarziDesk network.') }}</p>
    </div>

    <div class="row g-3 p-4 bg-light rounded-3 mb-4" style="border: 1px solid #E2E8F0;">
        <div class="col-md-6">
            <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px;">Branch Name</small>
            <span class="fw-bold text-dark fs-6">{{ $draft['name'] ?? 'N/A' }}</span>
        </div>
        <div class="col-md-6">
            <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px;">Branch Code</small>
            <span class="font-monospace fw-bold text-primary">{{ $draft['code'] ?? 'N/A' }}</span>
        </div>
        <div class="col-md-6">
            <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px;">Phone</small>
            <span class="fw-bold">{{ $draft['phone'] ?? 'Unassigned' }}</span>
        </div>
        <div class="col-md-6">
            <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px;">Address</small>
            <span class="fw-bold">{{ $draft['address'] ?? 'Unassigned' }}</span>
        </div>
        <div class="col-md-6">
            <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px;">Manager</small>
            <span class="fw-bold">{{ $manager ? $manager->name : 'Unassigned' }}</span>
        </div>
        <div class="col-md-6">
            <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px;">Operating Hours</small>
            <span class="fw-bold">{{ $draft['operating_hours'] ?? 'Mon - Sat 9:00 - 19:00' }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('branches.store.step3') }}">
        @csrf
        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
            <a href="{{ route('branches.create.step2') }}" class="btn btn-outline-secondary fw-bold">{{ __('Back') }}</a>
            <button type="submit" class="btn-create-branch">
                <i class="ti ti-check me-1"></i>
                {{ __('Confirm & Create Branch') }}
            </button>
        </div>
    </form>
</div>
@endsection
