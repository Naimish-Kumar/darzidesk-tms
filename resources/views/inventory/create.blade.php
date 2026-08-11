@extends('layouts.app')

@section('page-title')
    {{ __('Add Fabric / Material') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">{{ __('Inventory') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Add Material') }}</li>
    </ul>
@endsection

@section('content')
<div class="card p-4 max-w-700 mx-auto">
    <h4 class="fw-bold mb-3">{{ __('Register New Fabric / Accessory Material') }}</h4>
    <p class="text-muted mb-4" style="font-size: 13.5px;">{{ __('Add raw fabrics, lining, buttons, threads or zippers to your inventory database.') }}</p>

    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Material Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Loro Piana Super 150s Wool" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Material Code / SKU') }}</label>
                <input type="text" name="code" class="form-control font-monospace" placeholder="e.g. FAB-LP-01">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Unit of Measurement') }}</label>
                <select name="unit" class="form-select">
                    <option value="Meters">Meters</option>
                    <option value="Yards">Yards</option>
                    <option value="Pieces">Pieces</option>
                    <option value="Spools">Spools</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Initial Quantity in Stock') }} <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="quantity" class="form-control" placeholder="e.g. 150" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">{{ __('Cost Price per Unit') }}</label>
                <input type="number" step="0.01" name="unit_price" class="form-control font-monospace" placeholder="e.g. 85.00">
            </div>
        </div>

        <div class="d-flex justify-content-between border-top pt-3">
            <a href="{{ route('inventory.index') }}" class="btn btn-light fw-bold">{{ __('Cancel') }}</a>
            <button type="submit" class="btn btn-primary px-4" style="background:#006A67; border:none; border-radius:8px; font-weight:700;">
                <i class="ti ti-check me-1"></i> {{ __('Save Material') }}
            </button>
        </div>
    </form>
</div>
@endsection
