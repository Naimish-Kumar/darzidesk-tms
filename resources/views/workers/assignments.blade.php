@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Tailor Performance & Payouts') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Tailor Payroll & Payouts') }}</li>
@endsection

@section('content')
    <div class="dd-dashboard">
        {{-- Hero Header Banner --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 p-4" style="background:#FFFFFF; border:1px solid #E2E8F0;">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background:#E6F4F1; color:#00796B;">
                        <i class="ti ti-user-check fs-2"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1" style="font-size: 20px;">{{ __('Tailor Workload & Piece-Rate Commission Payouts') }}</h4>
                        <p class="text-muted small mb-0">{{ __('Track garments completed, turnaround times (TAT), and calculated piece-rate commission payouts per tailor') }}</p>
                    </div>
                </div>
                <div>
                    <button class="btn text-white fw-bold px-4" data-bs-toggle="modal" data-bs-target="#newAssignmentModal" style="background:#00796B; border-radius:10px;">
                        <i class="ti ti-plus me-1"></i> {{ __('Assign New Task') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Tailor Workload & Payout Cards -->
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="font-size: 16px;"><i class="ti ti-chart-dots me-2 text-primary"></i>{{ __('Tailor Productivity & Commission Summary') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($workerEarnings as $earning)
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="p-3 border rounded-3 bg-white shadow-sm h-100" style="border-color:#E2E8F0 !important;">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width:38px; height:38px; background:#00796B;">
                                            {{ strtoupper(substr($earning['worker']->name ?? 'W', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $earning['worker']->name ?? 'Tailor' }}</h6>
                                            <small class="text-muted" style="font-size: 11.5px;">{{ $earning['completed_tasks'] }}/{{ $earning['total_tasks'] }} {{ __('Garments Completed') }}</small>
                                        </div>
                                    </div>
                                    <span class="badge" style="background:#E6F4F1; color:#00796B; font-weight:700; font-size:11px;">
                                        ⏱️ {{ $earning['avg_tat_days'] > 0 ? $earning['avg_tat_days'] . 'd TAT' : 'On Track' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="font-size: 13px;">
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
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Shop Floor Worker Task List') }}</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignTaskModal">
                        <i class="ti ti-plus me-1"></i> {{ __('Assign New Task') }}
                    </button>
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
