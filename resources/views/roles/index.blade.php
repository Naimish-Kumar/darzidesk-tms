@extends('layouts.app')

@section('page-title')
    {{ __('Roles & Permissions Management') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Roles & Permissions') }}</li>
    </ul>
@endsection

@section('content')
<style>
    .roles-grid { display: grid; grid-template-columns: 300px 1fr; gap: 24px; }
    @media (max-width: 991px) { .roles-grid { grid-template-columns: 1fr; } }
    .role-card-item {
        background: #FFFFFF; border: 1.5px solid #E2E8F0;
        border-radius: 14px; padding: 16px; margin-bottom: 12px; transition: all 0.2s;
    }
    .role-card-item.selected { border-color: #006A67; box-shadow: 0 4px 12px rgba(0, 106, 103, 0.08); }
    .permissions-box { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 28px; }
</style>

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 font-weight-bold mb-1" style="font-weight: 800;">{{ __('System Roles & Access Control') }}</h2>
        <p class="text-muted mb-0">{{ __('Define role-based security boundaries for store owners, tailors, cutters and staff.') }}</p>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal" style="background:#006A67; border:none; border-radius:10px; padding:10px 18px; font-weight:700;">
            <i class="ti ti-plus me-1"></i> {{ __('Create New Role') }}
        </button>
    </div>
</div>

<div class="roles-grid">
    <!-- Left Roles Stack -->
    <div>
        <h5 class="fw-bold mb-3">{{ __('Defined Roles') }}</h5>
        @forelse($roles as $index => $role)
            <div class="role-card-item {{ $index === 0 ? 'selected' : '' }}">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded bg-light-teal text-teal">
                            <i class="ti ti-shield-check" style="font-size:18px; color:#006A67;"></i>
                        </div>
                        <h6 class="fw-bold mb-0">{{ ucfirst($role->name) }}</h6>
                    </div>
                    <span class="badge bg-light-primary text-primary" style="font-size:10px;">ROLE</span>
                </div>
                <p class="text-muted mb-0" style="font-size: 12px;">Guard: {{ $role->guard_name }}</p>
            </div>
        @empty
            <div class="card p-3 text-center text-muted">No roles defined.</div>
        @endforelse
    </div>

    <!-- Right Permissions Box -->
    <div class="permissions-box">
        <div class="d-flex align-items-center justify-content-between pb-3 border-bottom mb-4">
            <div>
                <h4 class="fw-bold mb-1">{{ __('Permission Matrix') }}</h4>
                <p class="text-muted mb-0" style="font-size: 13px;">{{ __('Configured access rights across all modules.') }}</p>
            </div>
        </div>

        <div class="row g-3">
            @forelse($permissions->groupBy(function($p) { return explode(' ', $p->name)[1] ?? 'General'; }) as $module => $modulePermissions)
                <div class="col-md-6 mb-3">
                    <div class="card border p-3 h-100" style="border-radius:12px;">
                        <h6 class="fw-bold text-uppercase text-teal mb-3" style="color:#006A67; font-size:12px;">
                            <i class="ti ti-lock me-1"></i> {{ $module }} {{ __('Module') }}
                        </h6>
                        @foreach($modulePermissions as $perm)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" checked disabled id="perm-{{ $perm->id }}">
                                <label class="form-check-label fw-bold text-dark" style="font-size:13px;" for="perm-{{ $perm->id }}">
                                    {{ ucfirst($perm->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">
                    <i class="ti ti-shield-off mb-2" style="font-size:32px;"></i>
                    <p>{{ __('Default permissions active.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('roles.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">{{ __('Create New Role') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Role Name') }}</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Master Tailor Admin" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary" style="background:#006A67; border:none;">{{ __('Save Role') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
