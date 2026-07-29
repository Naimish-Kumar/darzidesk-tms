@extends('layouts.app')
@section('page-title')
    {{ __('Tailor Task Assignments & Piece-Rate Pay') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Tailor Assignments') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <!-- Artisan Earnings Overview -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Tailor Earnings & Productivity Summary') }}</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        @forelse($workerEarnings as $earning)
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="p-3 border rounded bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar avatar-md bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-user fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $earning['worker']->name ?? 'Worker' }}</h6>
                                            <small class="text-muted">{{ $earning['completed_tasks'] }}/{{ $earning['total_tasks'] }} Tasks Completed</small>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                        <div>
                                            <small class="text-muted d-block">Earned Payout</small>
                                            <span class="fw-bold text-success fs-6">${{ number_format($earning['total_earned'], 2) }}</span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Pending Payout</small>
                                            <span class="fw-bold text-warning fs-6">${{ number_format($earning['pending_earned'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-muted text-center py-3">
                                {{ __('No tailor task assignments recorded yet.') }}
                            </div>
                        @endforelse
                    </div>
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
