@extends('layouts.app')
@section('page-title')
    {{ __('Production Kanban Board') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Production Board') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">{{ __('Shop Floor Production Stages') }}</h4>
            <div>
                <a href="{{ route('production-stages.index') }}" class="btn btn-outline-primary me-2">
                    <i class="ti ti-settings me-1"></i> {{ __('Manage Stages') }}
                </a>
                <a href="{{ route('worker-assignments.index') }}" class="btn btn-outline-success me-2">
                    <i class="ti ti-user-check me-1"></i> {{ __('Tailor Assignments') }}
                </a>
                <a href="{{ route('materials.index') }}" class="btn btn-outline-warning">
                    <i class="ti ti-box me-1"></i> {{ __('Fabric Inventory') }}
                </a>
            </div>
        </div>

        <div class="col-12">
            <div class="row flex-nowrap overflow-auto pb-4">
                @foreach ($stages as $stage)
                    @php
                        $stageOrders = $kanbanData[$stage->id]['orders'] ?? collect();
                    @endphp
                    <div class="col-md-4 col-lg-3 col-12 flex-shrink-0">
                        <div class="card h-100 shadow-sm border-top border-4" style="border-top-color: {{ $stage->color_code }} !important; min-height: 500px; background-color: #f8fafc;">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <span class="fw-bold fs-6" style="color: {{ $stage->color_code }}">
                                    <i class="ti ti-circle-filled fs-6 me-1"></i> {{ $stage->name }}
                                </span>
                                <span class="badge bg-secondary rounded-pill">{{ $stageOrders->count() }}</span>
                            </div>
                            <div class="card-body p-2 overflow-auto" style="max-height: 650px;">
                                @forelse ($stageOrders as $order)
                                    <div class="card mb-3 shadow-sm border-0">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-light-primary text-primary fw-bold">
                                                    {{ orderPrefix() . $order->order_id }}
                                                </span>
                                                <small class="text-muted fs-7">
                                                    <i class="ti ti-calendar me-1"></i>{{ dateFormat($order->deadline_date) }}
                                                </small>
                                            </div>

                                            <h6 class="mb-1 fw-bold text-dark">
                                                {{ !empty($order->customers) ? $order->customers->name : '-' }}
                                            </h6>
                                            <p class="text-muted small mb-2">
                                                <i class="ti ti-shirt me-1"></i>{{ !empty($order->clothTypes) ? $order->clothTypes->title : '-' }} (Qty: {{ $order->quantity }})
                                            </p>
                                            
                                            @if(!empty($order->febric))
                                                <div class="mb-2">
                                                    <span class="badge bg-light-info text-info">
                                                        Fabric: {{ $order->febric }} ({{ $order->febric_color ?? 'Standard' }})
                                                    </span>
                                                </div>
                                            @endif

                                            @if($order->assignments->count() > 0)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block mb-1 fw-semibold">Assigned Tailors:</small>
                                                    @foreach($order->assignments as $assign)
                                                        <span class="badge bg-light-success text-success me-1">
                                                            <i class="ti ti-user me-1"></i>{{ $assign->worker ? $assign->worker->name : 'Worker' }} (Pay: ${{ number_format($assign->piece_rate_pay, 2) }})
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <hr class="my-2 text-muted opacity-25">

                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <form action="{{ route('production.stage.update') }}" method="POST" class="w-100">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-light border-0"><i class="ti ti-arrow-right"></i></span>
                                                        <select name="stage_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                                            @foreach($stages as $stg)
                                                                <option value="{{ $stg->id }}" {{ $order->production_stage_id == $stg->id ? 'selected' : '' }}>
                                                                    Move to {{ $stg->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-5">
                                        <i class="ti ti-clipboard-x fs-1 d-block mb-2 text-secondary"></i>
                                        <small>{{ __('No orders in this stage') }}</small>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
