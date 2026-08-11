@extends('layouts.app')

@section('page-title')
    {{ __('Staff Management') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Staff Management') }}</li>
    </ul>
@endsection

@section('content')
<style>
    .btn-onboard {
        background: #26A69A; color: #FFF; border: none;
        padding: 10px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
    }
    .btn-onboard:hover { background: #006A67; color: #FFF; }

    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .kpi-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
    .kpi-lbl { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: #64748B; margin-bottom: 4px; text-transform: uppercase; }
    .kpi-val { font-size: 24px; font-weight: 800; color: #0F172A; }

    .staff-table-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; overflow: hidden; }
    .staff-table-header { padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; }
    .staff-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .staff-table th { text-align: left; padding: 12px 20px; font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; }
    .staff-table td { padding: 14px 20px; border-bottom: 1px solid #E2E8F0; vertical-align: middle; }
    .staff-avatar { width: 36px; height: 36px; border-radius: 50%; background: #26A69A; color: #FFF; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center; }
</style>

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 font-weight-bold mb-1" style="font-weight: 800;">{{ __('Staff Directory & Artisans') }}</h2>
        <p class="text-muted mb-0">{{ __('Manage master tailors, cutters, line operators and store personnel across your network.') }}</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('staff.onboard.step1') }}" class="btn-onboard">
            <i class="ti ti-user-plus me-1" style="font-size: 18px;"></i>
            {{ __('Onboard New Staff') }}
        </a>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('TOTAL STAFF') }}</div>
        <div class="kpi-val">{{ $totalStaff }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Master artisans & operators</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('ACTIVE PERSONNEL') }}</div>
        <div class="kpi-val text-success">{{ $activeStaff }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Currently assigned</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-lbl">{{ __('WORKSHOP BRANCHES') }}</div>
        <div class="kpi-val text-primary">{{ $branchesCount }}</div>
        <div style="font-size:11.5px; color:#64748B; margin-top:4px;">Boutique locations</div>
    </div>
</div>

<!-- Staff Table -->
<div class="staff-table-card">
    <div class="staff-table-header">
        <div class="d-flex align-items-center gap-2">
            <h5 class="mb-0 fw-bold">{{ __('Staff Members') }}</h5>
            <span class="badge bg-light-primary text-primary">{{ $totalStaff }} {{ __('records') }}</span>
        </div>
        <form method="GET" action="{{ route('staff.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search staff..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="ti ti-search"></i></button>
        </form>
    </div>

    <table class="staff-table">
        <thead>
            <tr>
                <th>{{ __('MEMBER NAME') }}</th>
                <th>{{ __('ROLE / DESIGNATION') }}</th>
                <th>{{ __('CONTACT EMAIL') }}</th>
                <th>{{ __('PHONE') }}</th>
                <th>{{ __('STATUS') }}</th>
                <th class="text-end">{{ __('ACTIONS') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staffMembers as $staff)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="staff-avatar">{{ strtoupper(substr($staff->name, 0, 2)) }}</div>
                            <div>
                                <div class="fw-bold text-dark">{{ $staff->name }}</div>
                                <div style="font-size:11px; color:#64748B;">ID: #STF-{{ 1000 + $staff->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light-info text-info fw-bold">{{ ucfirst($staff->type) }}</span></td>
                    <td class="font-monospace text-muted">{{ $staff->email }}</td>
                    <td class="font-monospace">{{ $staff->phone_number ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $staff->is_active ? 'success' : 'danger' }}">
                            {{ $staff->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" onsubmit="return confirm('Remove this staff member?');" style="display:inline;">
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
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="ti ti-users mb-2" style="font-size: 32px; color: #26A69A;"></i>
                        <div>{{ __('No staff members found.') }}</div>
                        <a href="{{ route('staff.onboard.step1') }}" class="btn-onboard mt-3">
                            <i class="ti ti-user-plus me-1"></i> {{ __('Onboard First Staff Member') }}
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
