@extends('layouts.app')

@section('page-title')
    {{ __('Branch Coordination') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Branches') }}</li>
    </ul>
@endsection

@section('content')
<style>
    .btn-add-branch {
        background: #006A67; color: #FFFFFF; border: none;
        padding: 10px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
    }
    .btn-add-branch:hover { background: #004D40; color: #FFFFFF; }

    .top-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px; }
    @media (max-width: 991px) { .top-grid { grid-template-columns: 1fr; } }

    .map-card {
        background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px;
        min-height: 200px; position: relative; padding: 20px;
        background-image: radial-gradient(#CBD5E1 1px, transparent 1px); background-size: 20px 20px;
    }
    .map-tag {
        background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 8px;
        padding: 6px 12px; font-size: 10px; font-weight: 800; letter-spacing: 0.8px;
        display: inline-block; color: #006A67;
    }

    .stats-col { display: flex; flex-direction: column; gap: 16px; }
    .stat-card {
        background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px; flex: 1;
    }
    .stat-lbl { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: #64748B; margin-bottom: 4px; }
    .stat-val { font-size: 26px; font-weight: 800; color: #0F172A; }

    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .section-header h3 { font-size: 17px; font-weight: 800; margin: 0; }

    .branches-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-bottom: 28px; }
    .branch-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.03); }
    .branch-card-hero {
        height: 110px; background: linear-gradient(180deg, #475569 0%, #1E293B 100%);
        padding: 16px; color: #FFFFFF; position: relative; display: flex; flex-direction: column; justify-content: flex-end;
    }
    .branch-status-badge {
        position: absolute; top: 12px; right: 12px; background: #10B981; color: #FFF;
        font-size: 9px; font-weight: 800; letter-spacing: 0.8px; padding: 3px 8px; border-radius: 4px;
    }
    .branch-status-badge.inactive { background: #EF4444; }
    .branch-name { font-size: 16px; font-weight: 800; }
    .branch-loc { font-size: 11.5px; opacity: 0.85; display: flex; align-items: center; gap: 4px; margin-top: 2px; }

    .branch-metrics {
        display: grid; grid-template-columns: repeat(3, 1fr); padding: 14px; text-align: center;
        border-bottom: 1px solid #E2E8F0; background: #F8FAFC;
    }
    .metric-item .lbl { font-size: 10px; font-weight: 700; color: #64748B; margin-bottom: 2px; }
    .metric-item .val { font-size: 14px; font-weight: 800; color: #006A67; }

    .branch-actions { padding: 12px 14px; display: flex; gap: 8px; }
    .btn-switch-context {
        flex: 1; background: #006A67; color: #FFF; border: none; padding: 8px 12px;
        border-radius: 8px; font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer; text-decoration: none;
    }
    .btn-switch-context:hover { color: #FFF; background: #004D40; }

    .ledger-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; margin-top: 24px; }
    .ledger-header {
        padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;
        background: #F8FAFC; border-bottom: 1px solid #E2E8F0; font-size: 13.5px; font-weight: 800;
    }
    .ledger-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .ledger-table th {
        text-align: left; padding: 12px 20px; font-size: 10px; font-weight: 800; letter-spacing: 0.8px;
        color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;
    }
    .ledger-table td { padding: 14px 20px; border-bottom: 1px solid #E2E8F0; }
    .branch-avatar {
        width: 32px; height: 32px; background: #E2E8F0; border-radius: 8px; font-size: 11px; font-weight: 800;
        display: flex; align-items: center; justify-content: center; color: #006A67;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 font-weight-bold mb-1" style="font-weight: 800;">{{ __('Branch Coordination') }}</h2>
        <p class="text-muted mb-0">{{ __('Manage and monitor your boutique empire across active locations.') }}</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('branches.create.step1') }}" class="btn-add-branch">
            <i class="ti ti-building-store" style="font-size: 18px;"></i>
            {{ __('Add New Branch') }}
        </a>
    </div>
</div>

<!-- Top Grid: Map & Stats -->
<div class="top-grid">
    <div class="map-card">
        <span class="map-tag"><i class="ti ti-map-pin me-1"></i>LIVE GEOLOCATION NETWORK</span>
        <div class="mt-4">
            <h5 class="font-weight-bold mb-2">{{ __('Boutique Map & Workshop Locations') }}</h5>
            <p class="text-muted" style="font-size: 13px;">{{ $totalBranches }} active location(s) tracked across your business network.</p>
        </div>
    </div>

    <div class="stats-col">
        <div class="stat-card">
            <div class="stat-lbl">{{ __('TOTAL ACTIVE LOCATIONS') }}</div>
            <div class="stat-val">{{ $totalBranches }}</div>
            <div style="font-size: 11.5px; color: #64748B; margin-top: 4px;">{{ $activeBranches }} operational / {{ $totalBranches - $activeBranches }} offline</div>
        </div>

        <div class="stat-card">
            <div class="stat-lbl">{{ __('TOTAL REGISTERED STAFF') }}</div>
            <div class="stat-val">{{ $totalStaff }}</div>
            <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Master tailors, cutters & store managers</div>
        </div>
    </div>
</div>

<!-- Active Branches Section -->
<div class="section-header">
    <h3>{{ __('Active Locations & Workshops') }}</h3>
</div>

<div class="branches-grid">
    @forelse($branches as $branch)
        <div class="branch-card">
            <div class="branch-card-hero">
                <span class="branch-status-badge {{ $branch->is_active ? '' : 'inactive' }}">
                    {{ $branch->is_active ? 'ACTIVE' : 'INACTIVE' }}
                </span>
                <div class="branch-name">{{ $branch->name }}</div>
                <div class="branch-loc">
                    <i class="ti ti-map-pin"></i>
                    {{ $branch->address ?? 'Location info unassigned' }}
                </div>
            </div>
            <div class="branch-metrics">
                <div class="metric-item">
                    <div class="lbl">Code</div>
                    <div class="val">{{ $branch->code ?? 'BR-'. $branch->id }}</div>
                </div>
                <div class="metric-item">
                    <div class="lbl">Manager</div>
                    <div class="val">{{ $branch->manager ? $branch->manager->name : 'Unassigned' }}</div>
                </div>
                <div class="metric-item">
                    <div class="lbl">Phone</div>
                    <div class="val" style="font-size: 11px;">{{ $branch->phone ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="branch-actions">
                <a href="{{ route('dashboard') }}" class="btn-switch-context">
                    <i class="ti ti-login"></i>
                    {{ __('Switch Context') }}
                </a>
                <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this branch?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px; padding: 7px 10px;">
                        <i class="ti ti-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card text-center p-5">
                <i class="ti ti-building-store mb-3" style="font-size: 42px; color: #006A67;"></i>
                <h5 class="font-weight-bold">{{ __('No Branches Found') }}</h5>
                <p class="text-muted">{{ __('Click "Add New Branch" above to register your first studio or workshop location.') }}</p>
                <div>
                    <a href="{{ route('branches.create.step1') }}" class="btn-add-branch">
                        <i class="ti ti-plus me-1"></i> {{ __('Add New Branch') }}
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Ledger Table -->
<div class="ledger-card">
    <div class="ledger-header">
        <span>{{ __('Live Branch Performance Ledger') }}</span>
        <span style="font-size:11.5px; font-weight:500; color:#64748B;">
            {{ __('Updated Live') }} 🔄
        </span>
    </div>

    <table class="ledger-table">
        <thead>
            <tr>
                <th>{{ __('BRANCH IDENTITY') }}</th>
                <th>{{ __('CODE') }}</th>
                <th>{{ __('MANAGER') }}</th>
                <th>{{ __('PHONE') }}</th>
                <th>{{ __('STATUS') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($branches as $b)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="branch-avatar">{{ strtoupper(substr($b->name, 0, 2)) }}</div>
                            <div>
                                <div style="font-weight:700;">{{ $b->name }}</div>
                                <div style="font-size:11.5px; color:#64748B;">{{ $b->address ?? 'No address' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="font-monospace fw-bold">{{ $b->code }}</td>
                    <td>{{ $b->manager ? $b->manager->name : 'Unassigned' }}</td>
                    <td class="font-monospace">{{ $b->phone ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $b->is_active ? 'success' : 'danger' }}">
                            {{ $b->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">{{ __('No ledger entries available.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
