@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Production Stage Workflow') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Production Board') }}</li>
@endsection

@push('css-page')
    <style>
        .dd-kanban-banner {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .dd-kanban-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #E6F4F1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dd-kanban-icon i {
            font-size: 24px;
            color: #00796B;
        }
        .dd-kanban-title {
            font-size: 22px;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 2px;
        }
        .dd-kanban-subtitle {
            font-size: 13.5px;
            color: #64748B;
            margin-bottom: 0;
        }
        .dd-stage-flow {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 12px;
        }
        .dd-flow-pill {
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            background: #F1F5F9;
            color: #475569;
        }
        .dd-flow-arrow {
            color: #94A3B8;
            font-size: 12px;
        }
        
        /* Column styling */
        .dd-kanban-col {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease;
        }
        .dd-kanban-col.drag-over {
            background: #E6F4F1 !important;
            border-color: #00796B !important;
            box-shadow: inset 0 0 0 2px #00796B !important;
        }
        .dd-col-header {
            padding: 16px 18px;
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            border-top-left-radius: 13px;
            border-top-right-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dd-col-title {
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dd-col-count {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 12px;
            background: #F1F5F9;
            color: #334155;
        }
        
        /* Card styling */
        .dd-order-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            cursor: grab;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .dd-order-card:active {
            cursor: grabbing;
            opacity: 0.7;
            transform: scale(0.98);
        }
        .dd-order-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-color: #CBD5E1;
        }
        .dd-card-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            color: #00796B;
            background: #E6F4F1;
            padding: 3px 8px;
            border-radius: 6px;
        }
        
        /* Warning pills */
        .dd-warning-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .dd-warning-overdue {
            background: #FEE2E2;
            color: #DC2626;
        }
        .dd-warning-today {
            background: #FEF3C7;
            color: #D97706;
        }
        .dd-warning-ontrack {
            background: #DCFCE7;
            color: #16A34A;
        }

        .dd-tailor-chip {
            font-size: 11.5px;
            font-weight: 600;
            color: #0F172A;
            background: #F1F5F9;
            padding: 3px 8px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .dd-btn-assign {
            font-size: 11.5px;
            font-weight: 600;
            color: #00796B;
            background: transparent;
            border: 1px dashed #00796B;
            border-radius: 8px;
            padding: 4px 10px;
            transition: all 0.2s ease;
        }
        .dd-btn-assign:hover {
            background: #00796B;
            color: #FFFFFF;
        }
    </style>
@endpush

@section('content')
    <div class="dd-dashboard">
        {{-- Banner Card --}}
        <div class="dd-kanban-banner">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="dd-kanban-icon">
                        <i class="ti ti-layout-kanban"></i>
                    </div>
                    <div>
                        <h4 class="dd-kanban-title">{{ __('Production Stage Workflow') }}</h4>
                        <p class="dd-kanban-subtitle">{{ __('Drag and drop tailoring orders across shop floor production stages with due date warnings') }}</p>
                        
                        <div class="dd-stage-flow">
                            <span class="dd-flow-pill"><i class="ti ti-circle-number-1 me-1"></i>New Order</span>
                            <span class="dd-flow-arrow">➔</span>
                            <span class="dd-flow-pill"><i class="ti ti-scissors me-1"></i>Cutting</span>
                            <span class="dd-flow-arrow">➔</span>
                            <span class="dd-flow-pill"><i class="ti ti-needle me-1"></i>Stitching / Embroidery</span>
                            <span class="dd-flow-arrow">➔</span>
                            <span class="dd-flow-pill"><i class="ti ti-shirt me-1"></i>Trial Fitting</span>
                            <span class="dd-flow-arrow">➔</span>
                            <span class="dd-flow-pill" style="background:#E6F4F1; color:#00796B;"><i class="ti ti-check me-1"></i>Ready for Delivery</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('production-stages.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="ti ti-settings me-1"></i> {{ __('Stages') }}
                    </a>
                    <a href="{{ route('worker-assignments.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="ti ti-user-check me-1"></i> {{ __('Tailor Payroll') }}
                    </a>
                    <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="ti ti-box me-1"></i> {{ __('Fabric Stock') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Kanban Board Columns --}}
        <div class="row flex-nowrap overflow-auto pb-4">
            @foreach ($stages as $stage)
                @php
                    $stageOrders = $kanbanData[$stage->id]['orders'] ?? collect();
                @endphp
                <div class="col-md-4 col-lg-3 col-12 flex-shrink-0">
                    <div class="dd-kanban-col" data-stage-id="{{ $stage->id }}" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event, {{ $stage->id }})">
                        
                        {{-- Column Header --}}
                        <div class="dd-col-header" style="border-top: 4px solid {{ $stage->color_code }}; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                            <div class="dd-col-title" style="color: {{ $stage->color_code }}">
                                <i class="ti ti-point-filled"></i>
                                <span>{{ $stage->name }}</span>
                            </div>
                            <span class="dd-col-count" id="count-stage-{{ $stage->id }}">{{ $stageOrders->count() }}</span>
                        </div>

                        {{-- Cards Container --}}
                        <div class="p-3 overflow-auto flex-grow-1" id="stage-body-{{ $stage->id }}" style="max-height: 700px;">
                            @forelse ($stageOrders as $order)
                                @php
                                    // Calculate Due Date Warning
                                    $dueDate = \Carbon\Carbon::parse($order->deadline_date);
                                    $today = \Carbon\Carbon::today();
                                    $diffDays = $today->diffInDays($dueDate, false);
                                    
                                    if ($dueDate->isPast() && !$dueDate->isToday()) {
                                        $warningClass = 'dd-warning-overdue';
                                        $warningText = '🚨 Overdue by ' . abs((int)$diffDays) . ' day' . (abs((int)$diffDays) > 1 ? 's' : '');
                                    } elseif ($dueDate->isToday()) {
                                        $warningClass = 'dd-warning-today';
                                        $warningText = '⚠️ Due Today';
                                    } else {
                                        $warningClass = 'dd-warning-ontrack';
                                        $warningText = '✅ ' . (int)$diffDays . ' day' . ((int)$diffDays > 1 ? 's' : '') . ' left';
                                    }
                                @endphp

                                <div class="dd-order-card" draggable="true" ondragstart="handleDragStart(event, {{ $order->id }}, {{ $stage->id }})" id="order-card-{{ $order->id }}">
                                    
                                    {{-- Order Code & Due Date Badge --}}
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="dd-card-code">{{ orderPrefix() . $order->order_id }}</span>
                                        <span class="dd-warning-pill {{ $warningClass }}">
                                            {{ $warningText }}
                                        </span>
                                    </div>

                                    {{-- Customer Name --}}
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">
                                        {{ !empty($order->customers) ? $order->customers->name : __('Walk-in Customer') }}
                                    </h6>

                                    {{-- Garment Type & Qty --}}
                                    <div class="d-flex align-items-center gap-2 mb-2 text-secondary" style="font-size: 13px;">
                                        <i class="ti ti-shirt" style="color: #00796B;"></i>
                                        <span>{{ !empty($order->clothTypes) ? $order->clothTypes->title : __('Garment') }}</span>
                                        <span class="badge bg-light text-dark border">Qty: {{ $order->quantity }}</span>
                                    </div>

                                    {{-- Fabric Swatch details if present --}}
                                    @if (!empty($order->febric))
                                        <div class="mb-2">
                                            <span class="badge" style="background: #F1F5F9; color: #475569; font-weight: 600; font-size: 11px;">
                                                🧵 {{ $order->febric }} {{ !empty($order->febric_color) ? '(' . $order->febric_color . ')' : '' }}
                                            </span>
                                        </div>
                                    @endif

                                    <hr class="my-2" style="border-color: #F1F5F9;">

                                    @php
                                        $waPhone = $order->customers->phone_number ?? '';
                                        $waMsg = \App\Helper\WhatsAppService::getStatusUpdateMessage($order);
                                        $waUrl = \App\Helper\WhatsAppService::generateClickToChatUrl($waPhone, $waMsg);
                                    @endphp

                                    {{-- Tailor Assignments & WhatsApp Alert --}}
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-1 flex-wrap">
                                            @if ($order->assignments->count() > 0)
                                                @foreach ($order->assignments as $assign)
                                                    <span class="dd-tailor-chip" title="{{ __('Piece Rate Pay: ') . priceFormat($assign->piece_rate_pay) }}">
                                                        <i class="ti ti-user-check text-success"></i>
                                                        {{ $assign->worker ? $assign->worker->name : __('Tailor') }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted" style="font-size: 12px; font-style: italic;">{{ __('Unassigned') }}</span>
                                            @endif
                                        </div>

                                        <button type="button" class="dd-btn-assign" onclick="openAssignModal({{ $order->id }}, '{{ orderPrefix() . $order->order_id }}')">
                                            <i class="ti ti-user-plus me-1"></i>{{ __('Assign') }}
                                        </button>
                                    </div>

                                    <div class="pt-2 border-top d-flex justify-content-end">
                                        <a href="{{ $waUrl }}" target="_blank" class="btn btn-sm btn-light-success text-success p-1 px-2" style="font-size: 11.5px; font-weight: 700; border-radius: 6px;">
                                            <i class="ti ti-brand-whatsapp me-1"></i>{{ __('WhatsApp Alert') }}
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-5 empty-placeholder">
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

    {{-- Tailor Assignment Modal --}}
    <div class="modal fade" id="assignTailorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="assignModalTitle">{{ __('Assign Tailor to Order') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('production.assign.worker') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="assign_order_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Select Tailor / Worker') }}</label>
                            <select name="worker_id" class="form-select" required style="border-radius: 10px;">
                                <option value="">-- {{ __('Choose Tailor') }} --</option>
                                @foreach ($tailors as $tailor)
                                    <option value="{{ $tailor->id }}">{{ $tailor->name }} ({{ ucfirst($tailor->type) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Piece Rate / Tailoring Commission Pay') }}</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#F8FAFC;">{{ getCurrencySymbol() }}</span>
                                <input type="number" step="0.01" name="piece_rate_pay" class="form-control" placeholder="0.00" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 13.5px;">{{ __('Special Stitching Notes / Instructions') }}</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="{{ __('e.g., Double stitching on lapel, extra 2 inch margin') }}" style="border-radius: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn text-white fw-bold" style="background: #00796B; border-radius: 10px;">{{ __('Save Assignment') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        let draggedOrderId = null;
        let draggedFromStageId = null;

        function handleDragStart(e, orderId, stageId) {
            draggedOrderId = orderId;
            draggedFromStageId = stageId;
            e.dataTransfer.setData('text/plain', orderId);
            e.dataTransfer.effectAllowed = 'move';
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const col = e.currentTarget;
            col.classList.add('drag-over');
        }

        function handleDragLeave(e) {
            const col = e.currentTarget;
            col.classList.remove('drag-over');
        }

        function handleDrop(e, targetStageId) {
            e.preventDefault();
            const col = e.currentTarget;
            col.classList.remove('drag-over');

            if (!draggedOrderId || draggedFromStageId === targetStageId) return;

            const orderCard = document.getElementById('order-card-' + draggedOrderId);
            const targetBody = document.getElementById('stage-body-' + targetStageId);
            
            if (orderCard && targetBody) {
                // Remove empty placeholder if exists
                const placeholder = targetBody.querySelector('.empty-placeholder');
                if (placeholder) placeholder.remove();

                // Append card visually right away
                targetBody.appendChild(orderCard);

                // Update counter numbers
                updateStageCount(draggedFromStageId, -1);
                updateStageCount(targetStageId, 1);

                // Send AJAX update request
                fetch("{{ route('production.stage.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: draggedOrderId,
                        stage_id: targetStageId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (window.notifier) {
                            notifier.show('Success', data.message, 'success', '', 3000);
                        }
                    } else {
                        location.reload();
                    }
                })
                .catch(err => {
                    console.error('Failed to update stage', err);
                    location.reload();
                });
            }

            draggedOrderId = null;
            draggedFromStageId = null;
        }

        function updateStageCount(stageId, delta) {
            const countEl = document.getElementById('count-stage-' + stageId);
            if (countEl) {
                let current = parseInt(countEl.innerText) || 0;
                countEl.innerText = Math.max(0, current + delta);
            }
        }

        function openAssignModal(orderId, orderCode) {
            document.getElementById('assign_order_id').value = orderId;
            document.getElementById('assignModalTitle').innerText = '{{ __("Assign Tailor to Order ") }}' + orderCode;
            const modal = new bootstrap.Modal(document.getElementById('assignTailorModal'));
            modal.show();
        }
    </script>
@endpush
