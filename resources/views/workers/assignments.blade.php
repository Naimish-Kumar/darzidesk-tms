@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Tailor Performance & Payouts') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Tailor Payroll & Payouts') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --wa-banner-bg: #0B2239;
            --wa-banner-border: #29435D;
            --wa-card-bg: #0B2239;
            --wa-card-border: #29435D;
            --wa-inner-bg: #102B45;
            --wa-text-title: #FFFFFF;
            --wa-text-sub: #8FA1B5;
            --dd-gold: #D9A441;
        }

        .dd-wa-banner {
            background: var(--wa-banner-bg) !important;
            border: 1px solid var(--wa-banner-border) !important;
            border-radius: 16px;
            color: var(--wa-text-title);
        }

        .dd-wa-card {
            background: var(--wa-card-bg) !important;
            border: 1px solid var(--wa-card-border) !important;
            border-radius: 16px;
            color: var(--wa-text-title);
        }

        .dd-wa-inner-card {
            background: var(--wa-inner-bg) !important;
            border: 1px solid var(--wa-card-border) !important;
            border-radius: 12px;
            color: var(--wa-text-title);
        }

        /* Card headers should blend with card, not use global override */
        .dd-wa-card .card-header {
            background: transparent !important;
            border-bottom: 1px solid var(--wa-card-border) !important;
        }

        /* Table within worker assignments */
        .dd-wa-card .table thead th {
            background-color: #102B45 !important;
            color: #F4C861 !important;
            border-bottom: 1px solid #29435D !important;
        }

        .dd-wa-card .table tbody td {
            color: #D8E0E8 !important;
            border-bottom: 1px solid #29435D !important;
        }

        .dd-wa-card .table tbody tr:hover {
            background-color: #102B45 !important;
        }

        /* Empty state icon and text */
        .dd-wa-card .text-secondary,
        .dd-wa-card .text-muted {
            color: #8FA1B5 !important;
        }

        /* Badge colors for status */
        .dd-wa-card .badge.bg-light-info {
            background: rgba(59, 130, 246, 0.15) !important;
            color: #60A5FA !important;
        }

        .dd-wa-card .badge.bg-light-success {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34D399 !important;
        }

        .dd-wa-card .badge.bg-light-warning {
            background: rgba(245, 158, 11, 0.15) !important;
            color: #FBBF24 !important;
        }

        .dd-wa-card .badge.bg-light-secondary {
            background: rgba(100, 116, 139, 0.15) !important;
            color: #94A3B8 !important;
        }

        /* Form select inside table */
        .dd-wa-card .form-select {
            background-color: #102B45 !important;
            border: 1px solid #29435D !important;
            color: #D8E0E8 !important;
        }

        /* Piece-rate pay text */
        .dd-wa-card .text-dark {
            color: #D8E0E8 !important;
        }

        /* Commission/payout border */
        .dd-wa-inner-card .border-top {
            border-color: #29435D !important;
        }
    </style>
@endpush

@section('content')
    <div class="dd-dashboard">
        {{-- Hero Header Banner --}}
        <div class="dd-wa-banner shadow-sm mb-4 p-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background: rgba(217, 164, 65, 0.15); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.3);">
                        <i class="ti ti-user-check fs-2"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--wa-text-title); font-size: 20px;">{{ __('Tailor Workload & Piece-Rate Commission Payouts') }}</h4>
                        <p class="text-muted small mb-0">{{ __('Track garments completed, turnaround times (TAT), and calculated piece-rate commission payouts per tailor') }}</p>
                    </div>
                </div>
                <div>
                    <button class="btn fw-bold px-4" data-bs-toggle="modal" data-bs-target="#assignTaskModal" style="background: var(--dd-gold); border-radius:10px; color: #03111F;">
                        <i class="ti ti-plus me-1"></i> {{ __('Assign New Task') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Tailor Workload & Payout Cards -->
        <div class="dd-wa-card shadow-sm mb-4">
            <div class="card-header py-3" style="background: transparent; border-bottom: 1px solid var(--wa-card-border);">
                <h5 class="mb-0 fw-bold" style="font-size: 16px; color: var(--wa-text-title);"><i class="ti ti-chart-dots me-2" style="color: var(--dd-gold);"></i>{{ __('Tailor Productivity & Commission Summary') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($workerEarnings as $earning)
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="p-3 dd-wa-inner-card shadow-sm h-100">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark" style="width:38px; height:38px; background: var(--dd-gold);">
                                            {{ strtoupper(substr($earning['worker']->name ?? 'W', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold" style="color: var(--wa-text-title);">{{ $earning['worker']->name ?? 'Tailor' }}</h6>
                                            <small class="text-muted" style="font-size: 11.5px;">{{ $earning['completed_tasks'] }}/{{ $earning['total_tasks'] }} {{ __('Garments Completed') }}</small>
                                        </div>
                                    </div>
                                    <span class="badge" style="background: rgba(217, 164, 65, 0.15); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.3); font-weight:700; font-size:11px;">
                                        ⏱️ {{ $earning['avg_tat_days'] > 0 ? $earning['avg_tat_days'] . 'd TAT' : 'On Track' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: var(--wa-card-border) !important; font-size: 13px;">
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 11px;">{{ __('Earned Commission') }}</small>
                                        <span class="fw-bold text-success">{{ priceFormat($earning['total_earned']) }}</span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block" style="font-size: 11px;">{{ __('Pending Payout') }}</small>
                                        <span class="fw-bold text-warning">{{ priceFormat($earning['pending_earned']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-muted text-center py-4">
                            <i class="ti ti-user-x fs-1 d-block mb-2 text-secondary"></i>
                            <small>{{ __('No tailor task assignments recorded yet.') }}</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Task Assignment List & New Task Button -->
        <div class="col-12">
            <div class="dd-wa-card shadow-sm">
                <div class="card-header py-3" style="background: transparent; border-bottom: 1px solid var(--wa-card-border);">
                    <h5 class="mb-0 fw-bold" style="color: var(--wa-text-title);">{{ __('Shop Floor Worker Task List') }}</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Order ID') }}</th>
                                    <th>{{ __('Tailor / Worker') }}</th>
                                    <th>{{ __('Production Stage') }}</th>
                                    <th>{{ __('Piece-Rate Pay') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Assigned Date') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $assignment)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-primary">{{ orderPrefix() . ($assignment->order->order_id ?? '-') }}</span>
                                            <small class="d-block text-muted">{{ !empty($assignment->order->customers) ? $assignment->order->customers->name : '' }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $assignment->worker->name ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-info text-info">
                                                {{ $assignment->stage->name ?? 'General Task' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">${{ number_format($assignment->piece_rate_pay, 2) }}</span>
                                        </td>
                                        <td>
                                            @if($assignment->status === 'completed')
                                                <span class="badge bg-light-success text-success"><i class="ti ti-check me-1"></i>Completed</span>
                                            @elseif($assignment->status === 'in_progress')
                                                <span class="badge bg-light-warning text-warning"><i class="ti ti-loader me-1"></i>In Progress</span>
                                            @else
                                                <span class="badge bg-light-secondary text-secondary"><i class="ti ti-clock me-1"></i>Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ dateFormat($assignment->assigned_at) }}</small>
                                        </td>
                                        <td>
                                            <form action="{{ route('worker-assignments.update-status', $assignment->id) }}" method="POST" class="d-inline me-1">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                                    <option value="pending" {{ $assignment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="in_progress" {{ $assignment->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="completed" {{ $assignment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </form>
                                            <form action="{{ route('worker-assignments.destroy', $assignment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove assignment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            {{ __('No worker tasks assigned yet. Click Assign New Task to start!') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Task Modal -->
    <div class="modal fade" id="assignTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('worker-assignments.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Assign Task to Tailor') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Select Order') }}</label>
                        <select name="order_id" class="form-select" required>
                            <option value="">-- Select Order --</option>
                            @foreach($orders as $ord)
                                <option value="{{ $ord->id }}">Order #{{ orderPrefix() . $ord->order_id }} ({{ $ord->customers->name ?? 'Customer' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Select Tailor / Worker') }}</label>
                        <select name="worker_id" class="form-select" required>
                            <option value="">-- Select Worker --</option>
                            @foreach($workers as $wrk)
                                <option value="{{ $wrk->id }}">{{ $wrk->name }} ({{ ucfirst($wrk->type) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Target Production Stage') }}</label>
                        <select name="stage_id" class="form-select">
                            <option value="">-- General Task --</option>
                            @foreach($stages as $stg)
                                <option value="{{ $stg->id }}">{{ $stg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Piece-Rate Pay ($)') }}</label>
                        <input type="number" step="0.01" min="0" name="piece_rate_pay" class="form-control" value="10.00" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Notes / Garment Instructions') }}</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Specific tailoring requirements..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Assign Task') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
