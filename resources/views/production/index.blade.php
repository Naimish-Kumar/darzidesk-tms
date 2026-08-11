@extends('layouts.app')

@section('page-title')
    {{ __('Production Pipeline') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Production Pipeline') }}</li>
@endsection

@section('content')
<style>
    .kanban-wrapper {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        padding-bottom: 1.5rem;
        align-items: flex-start;
        min-height: calc(100vh - 220px);
    }
    .kanban-col-wrap {
        flex: 0 0 300px;
        max-width: 300px;
        min-width: 280px;
        display: flex;
        flex-direction: column;
        background: #F8FAFC;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        padding: 14px;
        max-height: calc(100vh - 210px);
    }
    .col-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: #FFFFFF;
        border-radius: 12px;
        margin-bottom: 12px;
        border-left: 4px solid #00796B;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .col-title {
        font-weight: 700;
        font-size: 14px;
        color: #1E293B;
        margin: 0;
    }
    .col-badge-count {
        background: #E0F2F1;
        color: #00796B;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 9px;
        border-radius: 20px;
    }
    .kanban-drop-zone {
        flex: 1;
        overflow-y: auto;
        min-height: 150px;
        padding: 4px;
        border-radius: 12px;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .kanban-drop-zone.drag-over {
        background: #E0F2F1;
        border: 2px dashed #00796B;
    }
    .order-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.03);
        cursor: grab;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,121,107,0.1);
        border-color: #00796B;
    }
    .order-card:active {
        cursor: grabbing;
        opacity: 0.6;
    }
    .empty-stage-box {
        text-align: center;
        padding: 30px 15px;
        color: #94A3B8;
        font-size: 12px;
        background: #FFFFFF;
        border: 1px dashed #CBD5E1;
        border-radius: 12px;
    }
    .metric-pill {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
</style>

<!-- Top Banner Header & Statistics -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-light-teal p-3 rounded-4 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="ti ti-transform text-teal fs-2"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">{{ __('Production & Tailoring Board') }}</h4>
                        <p class="text-muted mb-0 small">{{ __('Drag and drop bespoke garments across stages to track real-time workshop progress.') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-md-end align-items-center gap-3 flex-wrap">
                    <div class="metric-pill shadow-none">
                        <i class="ti ti-shirt text-teal fs-4"></i>
                        <div>
                            <span class="d-block text-muted fs-8 text-uppercase fw-bold">{{ __('In Production') }}</span>
                            <strong class="fs-6 text-dark">{{ $totalInProduction }} {{ __('Garments') }}</strong>
                        </div>
                    </div>

                    <div class="metric-pill shadow-none">
                        <i class="ti ti-calendar-event text-warning fs-4"></i>
                        <div>
                            <span class="d-block text-muted fs-8 text-uppercase fw-bold">{{ __('Due Today') }}</span>
                            <strong class="fs-6 text-dark">{{ $dueToday }} {{ __('Orders') }}</strong>
                        </div>
                    </div>

                    <a href="{{ route('orders.create.step1') }}" class="btn btn-primary rounded-3 px-3 py-2 fw-bold" style="background:#00796B; border-color:#00796B;">
                        <i class="ti ti-plus me-1"></i> {{ __('New Order') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Horizontal Scrollable Kanban Pipeline Board -->
<div class="kanban-wrapper">
    @forelse($stages as $stage)
        @php
            $stageOrders = $orders->filter(function($o) use ($stage) {
                return $o->status == $stage->slug || $o->production_stage_id == $stage->id;
            });
            $stageColor = $stage->color_code ?: '#00796B';
        @endphp

        <div class="kanban-col-wrap">
            <div class="col-header-box" style="border-left-color: {{ $stageColor }};">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: {{ $stageColor }};"></span>
                    <h6 class="col-title">{{ $stage->name }}</h6>
                </div>
                <span class="col-badge-count" id="count-stage-{{ $stage->id }}">
                    {{ $stageOrders->count() }}
                </span>
            </div>

            <div class="kanban-drop-zone" data-stage-id="{{ $stage->id }}" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, {{ $stage->id }})">
                @forelse($stageOrders as $order)
                    <div class="order-card" draggable="true" ondragstart="handleDragStart(event, {{ $order->id }})" id="order-card-{{ $order->id }}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light-primary text-primary fw-bold fs-8">#{{ $order->order_id ?? 'ORD-'.$order->id }}</span>
                            @if(!empty($order->delivery_date))
                                <span class="badge bg-light-warning text-warning fs-8">
                                    <i class="ti ti-clock me-1"></i>{{ $order->delivery_date }}
                                </span>
                            @endif
                        </div>

                        <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $order->customer ? $order->customer->name : 'Walk-in Client' }}</h6>
                        <p class="text-muted small mb-3"><i class="ti ti-hanger me-1"></i>{{ $order->clothType ? $order->clothType->name : 'Bespoke Item' }}</p>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="fw-bold text-teal fs-6">{{ priceFormat($order->total_amount ?? 0) }}</span>
                            <a href="{{ route('order.show', encrypt($order->id)) }}" class="btn btn-sm btn-outline-teal rounded-pill px-3 py-1 fs-8">
                                {{ __('Details') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-stage-box empty-msg">
                        <i class="ti ti-sparkles fs-3 d-block mb-2 text-muted"></i>
                        No garments in {{ strtolower($stage->name) }}
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-5 bg-white rounded-4 border">
            <i class="ti ti-layout-board fs-1 d-block mb-2 text-muted"></i>
            <p class="mb-0">{{ __('No production stages configured.') }}</p>
        </div>
    @endforelse
</div>

@push('script-page')
<script>
    let draggedOrderId = null;

    function handleDragStart(e, orderId) {
        draggedOrderId = orderId;
        e.dataTransfer.setData('text/plain', orderId);
        e.dataTransfer.effectAllowed = 'move';
    }

    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        var zone = e.currentTarget.closest('.kanban-drop-zone');
        if (zone) zone.classList.add('drag-over');
    }

    function handleDragLeave(e) {
        var zone = e.currentTarget.closest('.kanban-drop-zone');
        if (zone) zone.classList.remove('drag-over');
    }

    function handleDrop(e, stageId) {
        e.preventDefault();
        var zone = e.currentTarget.closest('.kanban-drop-zone');
        if (zone) zone.classList.remove('drag-over');

        if (!draggedOrderId) return;

        const card = document.getElementById('order-card-' + draggedOrderId);
        if (card && zone) {
            zone.appendChild(card);
            const emptyMsg = zone.querySelector('.empty-msg');
            if (emptyMsg) emptyMsg.style.display = 'none';
        }

        fetch("{{ route('production.update-stage') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                order_id: draggedOrderId,
                stage_id: stageId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && typeof notifier !== 'undefined') {
                notifier.show('Stage Updated', data.message, 'success', '{{ asset("assets/images/notification/ok-48.png") }}', 3000);
            }
        })
        .catch(err => console.error(err));
    }
</script>
@endpush
@endsection
