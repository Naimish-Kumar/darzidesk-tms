@extends('layouts.app')

@section('page-title')
    {{ __('Fabric & Material Inventory') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Inventory') }}</li>
    </ul>
@endsection

@section('content')
<style>
    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .kpi-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
    .kpi-lbl { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: #64748B; margin-bottom: 4px; text-transform: uppercase; }
    .kpi-val { font-size: 24px; font-weight: 800; color: #0F172A; }

    .inv-table-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; }
    .inv-table-header { padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; }
    .inv-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .inv-table th { text-align: left; padding: 12px 20px; font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; }
    .inv-table td { padding: 14px 20px; border-bottom: 1px solid #E2E8F0; vertical-align: middle; }
</style>

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 font-weight-bold mb-1" style="font-weight: 800;">{{ __('Inventory & Fabric Vault') }}</h2>
        <p class="text-muted mb-0">{{ __('Manage wool, silk, linings, buttons and zippers stock across your workshops.') }}</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('inventory.create') }}" class="btn btn-primary" style="background:#006A67; border:none; border-radius:10px; padding:10px 18px; font-weight:700;">
            <i class="ti ti-plus me-1"></i> {{ __('Add Material') }}
        </a>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('TOTAL MATERIALS') }}</div>
        <div class="kpi-val">{{ $totalMaterials }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Fabric & trims catalogue</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('LOW STOCK ALERTS') }}</div>
        <div class="kpi-val text-danger">{{ $lowStock }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Requires reordering</div>
    </div>
</div>

<div class="inv-table-card">
    <div class="inv-table-header">
        <h5 class="mb-0 fw-bold">{{ __('Stock Register') }}</h5>
        <form method="GET" action="{{ route('inventory.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search material..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="ti ti-search"></i></button>
        </form>
    </div>

    <table class="inv-table">
        <thead>
            <tr>
                <th>{{ __('MATERIAL NAME') }}</th>
                <th>{{ __('CODE') }}</th>
                <th>{{ __('QUANTITY IN STOCK') }}</th>
                <th>{{ __('UNIT PRICE') }}</th>
                <th class="text-end">{{ __('ACTIONS') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($materials as $material)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="p-2 rounded bg-light text-dark fw-bold" style="font-size:12px;">
                                <i class="ti ti-cut me-1" style="color:#006A67;"></i> {{ $material->name }}
                            </div>
                        </div>
                    </td>
                    <td class="font-monospace text-muted">{{ $material->code }}</td>
                    <td class="font-monospace fw-bold {{ $material->quantity <= 5 ? 'text-danger' : 'text-success' }}">
                        {{ $material->quantity }} {{ $material->unit ?? 'Units' }}
                    </td>
                    <td class="font-monospace fw-bold">{{ priceFormat($material->unit_price ?? 0) }}</td>
                    <td class="text-end">
                        <form action="{{ route('inventory.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Delete material?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px;">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="ti ti-box mb-2" style="font-size: 32px; color: #006A67;"></i>
                        <div>{{ __('No materials found in inventory.') }}</div>
                        <a href="{{ route('inventory.create') }}" class="btn btn-sm btn-primary mt-3" style="background:#006A67; border:none;">
                            <i class="ti ti-plus me-1"></i> {{ __('Add First Material') }}
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
