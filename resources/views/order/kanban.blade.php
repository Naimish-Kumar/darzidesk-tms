@extends('layouts.app')
@section('page-title')
    {{ __('Order Kanban') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('order.index') }}">{{ __('Order') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Kanban Board') }}</li>
@endsection

@push('css-page')
    <style>
        .kanban-dashboard-header {
            background: #ffffff;
            border-radius: 12px;
            padding: 18px 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(226, 232, 240, 0.8);
            margin-bottom: 20px;
        }

        .pc-kanban-wrapper {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding-bottom: 15px;
            align-items: flex-start;
        }

        .pc-kanban-column {
            min-width: 290px;
            max-width: 320px;
            width: 100%;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .pc-kanban-header {
            padding: 14px 16px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
        }

        .pc-kanban-header-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 0.925rem;
            color: #1e293b;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        /* Column Specific Accents */
        .col-status-pending { border-top: 4px solid #f59e0b; }
        .col-status-pending .status-dot { background-color: #f59e0b; box-shadow: 0 0 8px rgba(245, 158, 11, 0.4); }

        .col-status-in_progress { border-top: 4px solid #006A67; }
        .col-status-in_progress .status-dot { background-color: #006A67; box-shadow: 0 0 8px rgba(0, 106, 103, 0.4); }

        .col-status-completed { border-top: 4px solid #10b981; }
        .col-status-completed .status-dot { background-color: #10b981; box-shadow: 0 0 8px rgba(16, 185, 129, 0.4); }

        .col-status-ready_for_delivery { border-top: 4px solid #6366f1; }
        .col-status-ready_for_delivery .status-dot { background-color: #6366f1; box-shadow: 0 0 8px rgba(99, 102, 241, 0.4); }

        .col-status-delivered { border-top: 4px solid #8b5cf6; }
        .col-status-delivered .status-dot { background-color: #8b5cf6; box-shadow: 0 0 8px rgba(139, 92, 246, 0.4); }

        .col-status-on_hold { border-top: 4px solid #ef4444; }
        .col-status-on_hold .status-dot { background-color: #ef4444; box-shadow: 0 0 8px rgba(239, 68, 68, 0.4); }

        .pc-kanban-body {
            flex: 1;
            padding: 12px;
            max-height: calc(100vh - 280px);
            min-height: 180px;
        }

        .pc-kanban-cards {
            min-height: 150px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Modern Kanban Card */
        .kanban-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: grab;
            position: relative;
        }

        .kanban-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .kanban-card.gu-mirror {
            cursor: grabbing;
            opacity: 0.95;
            transform: rotate(2deg) scale(1.02);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            border-color: #006A67;
        }

        .gu-transit {
            opacity: 0.35;
            background: #f1f5f9 !important;
            border: 2px dashed #006A67 !important;
        }

        .order-badge-id {
            font-family: monospace;
            font-weight: 700;
            font-size: 0.85rem;
            color: #006A67;
            background: #e6f4f3;
            padding: 3px 8px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .order-badge-id:hover {
            background: #006A67;
            color: #ffffff;
        }

        .cloth-pill {
            font-size: 0.725rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            background: #f1f5f9;
            color: #475569;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .customer-title {
            font-size: 0.925rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .meta-item {
            font-size: 0.785rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 5px;
        }

        .meta-item i {
            font-size: 0.95rem;
            color: #94a3b8;
        }

        .deadline-pill {
            font-size: 0.725rem;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 600;
        }

        .deadline-normal {
            background: #f1f5f9;
            color: #475569;
        }

        .deadline-overdue {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .tailor-avatar-badge {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #006A67;
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .card-footer-info {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-kanban-input {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 6px 14px 6px 36px;
            font-size: 0.875rem;
            width: 260px;
            transition: all 0.2s;
        }

        .search-kanban-input:focus {
            border-color: #006A67;
            box-shadow: 0 0 0 3px rgba(0, 106, 103, 0.12);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Header Action Bar -->
            <div class="kanban-dashboard-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avtar avtar-m bg-light-primary text-primary rounded-circle">
                        <i class="ti ti-layout-kanban f-22"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 font-weight-bold" style="color: #0f172a;">{{ __('Order Production Board') }}</h4>
                        <small class="text-muted">{{ __('Track and drag tailoring orders across workflow stages') }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <!-- Search Filter -->
                    <div class="search-wrapper">
                        <i class="ti ti-search"></i>
                        <input type="text" id="kanbanSearch" class="form-control search-kanban-input" placeholder="{{ __('Search orders, customers...') }}">
                    </div>

                    <!-- View Switcher -->
                    <div class="btn-group p-1 bg-light rounded-2" role="group">
                        <a href="{{ route('order.index') }}" class="btn btn-sm btn-link text-muted px-3" data-bs-toggle="tooltip" title="{{ __('List View') }}">
                            <i class="ti ti-list f-18"></i>
                        </a>
                        <a href="{{ route('order.kanban') }}" class="btn btn-sm btn-primary active rounded px-3" data-bs-toggle="tooltip" title="{{ __('Kanban Board') }}">
                            <i class="ti ti-layout-kanban f-18"></i>
                        </a>
                    </div>

                    @can('create order')
                        <a href="{{ route('order.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 rounded-3 shadow-sm">
                            <i class="ti ti-plus"></i> {{ __('Create Order') }}
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Kanban Columns Container -->
            <div class="pc-kanban-wrapper">
                @foreach ($statuses as $statusKey => $statusLabel)
                    @php 
                        $ordersByStatus = $kanbanData[$statusKey] ?? collect(); 
                        $columnClass = 'col-status-' . $statusKey;
                    @endphp
                    <div class="pc-kanban-column {{ $columnClass }}">
                        <div class="pc-kanban-header">
                            <div class="pc-kanban-header-status">
                                <span class="status-dot"></span>
                                <span>{{ ucfirst($statusLabel) }}</span>
                            </div>
                            <span class="badge rounded-pill bg-light-secondary text-dark font-weight-bold px-2 py-1 count-badge">
                                {{ count($ordersByStatus) }}
                            </span>
                        </div>

                        <div class="pc-kanban-body" data-simplebar>
                            <div class="pc-kanban-cards" id="status-{{ $statusKey }}" data-status="{{ $statusKey }}">
                                @foreach ($ordersByStatus as $order)
                                    @php
                                        $customerName = !empty($order->customers) ? $order->customers->name : __('Walk-in Customer');
                                        $clothType = !empty($order->clothTypes) ? $order->clothTypes->title : null;
                                        $tailorName = !empty($order->users) ? $order->users->name : null;
                                        $initials = '';
                                        if ($tailorName) {
                                            $parts = explode(' ', $tailorName);
                                            $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                                        }
                                        
                                        $isOverdue = false;
                                        if (!empty($order->deadline_date) && \Carbon\Carbon::parse($order->deadline_date)->isPast() && !in_array($order->status, ['completed', 'delivered'])) {
                                            $isOverdue = true;
                                        }
                                    @endphp
                                    <div class="kanban-card" data-orderId="{{ $order->id }}" data-search="{{ strtolower($order->order_id . ' ' . $customerName . ' ' . $clothType . ' ' . $tailorName) }}">
                                        <!-- Top Row: Order ID & Actions -->
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <a href="{{ route('order.show', encrypt($order->id)) }}" class="order-badge-id">
                                                {{ orderPrefix() . $order->order_id }}
                                            </a>
                                            
                                            <div class="d-flex align-items-center gap-1">
                                                @php
                                                    $waPhone = $order->customers->phone_number ?? '';
                                                    $waMsg = \App\Helper\WhatsAppService::getStatusUpdateMessage($order);
                                                    $waUrl = \App\Helper\WhatsAppService::generateClickToChatUrl($waPhone, $waMsg);
                                                @endphp
                                                @if(!empty($waPhone))
                                                    <a href="{{ $waUrl }}" target="_blank" class="avtar avtar-xs btn-link-success text-success" data-bs-toggle="tooltip" title="{{ __('Send WhatsApp Update') }}">
                                                        <i class="ti ti-brand-whatsapp f-16"></i>
                                                    </a>
                                                @endif

                                                <div class="dropdown">
                                                    <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical f-16"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                        <a class="dropdown-item py-2" href="{{ route('order.show', encrypt($order->id)) }}">
                                                            <i class="ti ti-eye text-primary me-2 f-16"></i>{{ __('View Details') }}
                                                        </a>
                                                        @can('edit order')
                                                            <a class="dropdown-item py-2" href="{{ route('order.edit', encrypt($order->id)) }}">
                                                                <i class="ti ti-edit text-warning me-2 f-16"></i>{{ __('Edit Order') }}
                                                            </a>
                                                        @endcan
                                                        @can('delete order')
                                                            <div class="dropdown-divider"></div>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['order.destroy', encrypt($order->id)]]) !!}
                                                            <a class="dropdown-item py-2 text-danger confirm_dialog" href="#">
                                                                <i class="ti ti-trash text-danger me-2 f-16"></i>{{ __('Delete') }}
                                                            </a>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Customer Name -->
                                        <div class="customer-title text-truncate">
                                            {{ $customerName }}
                                        </div>

                                        <!-- Cloth & Gender Badges -->
                                        <div class="d-flex align-items-center gap-2 flex-wrap my-2">
                                            @if($clothType)
                                                <span class="cloth-pill">
                                                    <i class="ti ti-shirt f-12"></i> {{ $clothType }}
                                                </span>
                                            @endif
                                            @if(!empty($order->gender))
                                                <span class="badge bg-light text-muted font-weight-normal" style="font-size: 0.7rem;">
                                                    {{ ucfirst($order->gender) }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Meta Dates -->
                                        <div class="meta-item">
                                            <i class="ti ti-calendar-event"></i>
                                            <span>{{ __('Ordered') }}: {{ dateFormat($order->order_date) }}</span>
                                        </div>

                                        @if(!empty($order->deadline_date))
                                            <div class="meta-item justify-content-between mt-2">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="ti ti-alarm"></i>
                                                    <span>{{ __('Deadline') }}:</span>
                                                </div>
                                                <span class="deadline-pill {{ $isOverdue ? 'deadline-overdue' : 'deadline-normal' }}">
                                                    @if($isOverdue)
                                                        <i class="ti ti-alert-triangle me-1"></i>
                                                    @endif
                                                    {{ dateFormat($order->deadline_date) }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Footer: Assigned Tailor -->
                                        @if($tailorName)
                                            <div class="card-footer-info">
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ __('Assigned Tailor') }}</small>
                                                <div class="d-flex align-items-center gap-1">
                                                    <span class="tailor-avatar-badge" data-bs-toggle="tooltip" title="{{ $tailorName }}">
                                                        {{ $initials }}
                                                    </span>
                                                    <span class="text-dark font-weight-bold" style="font-size: 0.785rem;">{{ $tailorName }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dragula.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live Filter Search
            const searchInput = document.getElementById('kanbanSearch');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const query = this.value.toLowerCase().trim();
                    const cards = document.querySelectorAll('.kanban-card');
                    
                    cards.forEach(card => {
                        const searchText = card.getAttribute('data-search') || '';
                        if (searchText.includes(query)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Update column count badges based on visible cards
                    document.querySelectorAll('.pc-kanban-column').forEach(col => {
                        const visibleCount = col.querySelectorAll('.kanban-card[style="display: block;"], .kanban-card:not([style*="display: none"])').length;
                        const badge = col.querySelector('.count-badge');
                        if (badge) {
                            badge.textContent = visibleCount;
                        }
                    });
                });
            }

            // Dragula Drag & Drop Setup
            var containers = Array.from(document.querySelectorAll('.pc-kanban-cards'));

            @can('update order status')
                var drake = dragula(containers, {
                    moves: function(el, source, handle, sibling) {
                        return !el.classList.contains('dragging');
                    }
                });

                drake.on('drop', function(el, target, source, sibling) {
                    if (!target || !target.classList.contains('pc-kanban-cards')) {
                        drake.cancel();
                        toastrs("Error!", "Invalid target column.", "error");
                        return;
                    }

                    el.classList.add('dragging');

                    let orderId = el.getAttribute('data-orderId');
                    let status = target.getAttribute('data-status');
                    if (orderId && status) {
                        $.ajax({
                            url: '{{ route('order.status.update') }}',
                            type: 'POST',
                            data: {
                                orderId: orderId,
                                status: status,
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if (data.error) {
                                    drake.cancel();
                                    toastrs("Error!", data.error, "error");
                                    el.classList.remove('dragging');
                                    return;
                                }
                                toastrs("Success!", "Order updated successfully.", "success");
                                el.classList.remove('dragging');

                                // Update counts on source & target columns
                                [source, target].forEach(c => {
                                    const col = c.closest('.pc-kanban-column');
                                    if (col) {
                                        const count = col.querySelectorAll('.kanban-card').length;
                                        const badge = col.querySelector('.count-badge');
                                        if (badge) badge.textContent = count;
                                    }
                                });
                            },
                            error: function(xhr) {
                                drake.cancel();
                                let message = xhr.responseJSON && xhr.responseJSON.error ?
                                    xhr.responseJSON.error :
                                    "An error occurred while updating the order.";
                                toastrs("Error!", message, "error");
                                el.classList.remove('dragging');
                            }
                        });
                    } else {
                        drake.cancel();
                        toastrs("Error!", "Invalid order or status.", "error");
                        el.classList.remove('dragging');
                    }
                });
            @endcan
        });
    </script>
@endpush
