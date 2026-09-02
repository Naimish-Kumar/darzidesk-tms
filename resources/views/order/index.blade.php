@extends('layouts.app')
@section('page-title')
    {{ __('Order List') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Order List') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --ord-header-bg: #FFFFFF;
            --ord-header-border: #E2E8F0;
            --ord-text-title: #0F172A;
            --ord-text-sub: #64748B;
            --dd-gold: #D9A441;
        }

        [data-pc-theme="dark"] {
            --ord-header-bg: #0B2239;
            --ord-header-border: #29435D;
            --ord-text-title: #FFFFFF;
            --ord-text-sub: #8FA1B5;
        }

        .order-header-bar {
            background: var(--ord-header-bg);
            border-radius: 14px;
            padding: 18px 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--ord-header-border);
            margin-bottom: 20px;
            color: var(--ord-text-title);
        }

        .order-id-badge {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            color: var(--dd-gold);
            background: rgba(217, 164, 65, 0.15);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid rgba(217, 164, 65, 0.3);
            text-decoration: none;
            transition: all 0.2s;
        }

        .order-id-badge:hover {
            background: var(--dd-gold);
            color: #03111F;
        }

        .status-badge-custom {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            text-transform: capitalize;
        }

        .status-pending { background: rgba(217, 164, 65, 0.15); color: #F4C861; border: 1px solid rgba(217, 164, 65, 0.3); }
        .status-in_progress { background: rgba(59, 130, 246, 0.15); color: #60A5FA; border: 1px solid rgba(59, 130, 246, 0.3); }
        .status-completed { background: rgba(34, 197, 94, 0.15); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.3); }
        .status-ready_for_delivery { background: rgba(168, 85, 247, 0.15); color: #C084FC; border: 1px solid rgba(168, 85, 247, 0.3); }
        .status-delivered { background: rgba(99, 102, 241, 0.15); color: #818CF8; border: 1px solid rgba(99, 102, 241, 0.3); }
        .status-on_hold { background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.3); }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Header Bar -->
            <div class="order-header-bar d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avtar avtar-m bg-light-primary text-primary rounded-circle">
                        <i class="ti ti-list f-22"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 font-weight-bold" style="color: var(--ord-text-title);">{{ __('Order Directory') }}</h4>
                        <small class="text-muted">{{ __('Manage all customer orders, status tracking, and job cards') }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- View Switcher -->
                    <div class="btn-group p-1 bg-light rounded-2" role="group">
                        <a href="{{ route('order.index') }}" class="btn btn-sm btn-primary active rounded px-3" data-bs-toggle="tooltip" title="{{ __('List View') }}">
                            <i class="ti ti-list f-18"></i>
                        </a>
                        <a href="{{ route('order.kanban') }}" class="btn btn-sm btn-link text-muted px-3" data-bs-toggle="tooltip" title="{{ __('Kanban Board') }}">
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

            <!-- Orders Table Card -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Order ID') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Order Date') }}</th>
                                    <th>{{ __('Deadline') }}</th>
                                    <th>{{ __('Cloth Type') }}</th>
                                    <th>{{ __('Gender') }}</th>
                                    <th>{{ __('Responsible Tailor') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Invoice') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    @php
                                        $statusKey = $order->status;
                                        $statusLabel = \App\Models\Order::$status[$statusKey] ?? ucfirst($statusKey);
                                        $isOverdue = !empty($order->deadline_date) && \Carbon\Carbon::parse($order->deadline_date)->isPast() && !in_array($statusKey, ['completed', 'delivered']);
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ route('order.show', encrypt($order->id)) }}" class="order-id-badge">
                                                {{ orderPrefix() . $order->order_id }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark">
                                                {{ !empty($order->customers) ? $order->customers->name : '-' }}
                                            </div>
                                        </td>
                                        <td>{{ dateFormat($order->order_date) }}</td>
                                        <td>
                                            <span class="{{ $isOverdue ? 'text-danger font-weight-bold' : '' }}">
                                                @if($isOverdue) <i class="ti ti-alert-circle text-danger me-1"></i> @endif
                                                {{ dateFormat($order->deadline_date) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(!empty($order->clothTypes))
                                                <span class="badge bg-light-secondary text-dark">
                                                    <i class="ti ti-shirt me-1"></i>{{ $order->clothTypes->title }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td><span class="text-capitalize text-muted">{{ $order->gender ?? '-' }}</span></td>
                                        <td>
                                            @if(!empty($order->users))
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="ti ti-user-check text-primary"></i>
                                                    <span>{{ $order->users->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge-custom status-{{ $statusKey }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (!empty($order->invoices))
                                                <a href="{{ route('invoice.show', encrypt($order->invoices->id)) }}" class="badge bg-light-primary text-primary">
                                                    {{ invoicePrefix() . $order->invoices->invoice_id }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-1">
                                                {{-- Send WhatsApp Status Update --}}
                                                @php
                                                    $waPhone = $order->customers->phone_number ?? '';
                                                    $waMsg = \App\Helper\WhatsAppService::getStatusUpdateMessage($order);
                                                    $waUrl = \App\Helper\WhatsAppService::generateClickToChatUrl($waPhone, $waMsg);
                                                @endphp
                                                @if(!empty($waPhone))
                                                    <a class="avtar avtar-xs btn-link-success text-success"
                                                        data-bs-toggle="tooltip" title="{{ __('Send WhatsApp Update') }}"
                                                        href="{{ $waUrl }}" target="_blank">
                                                        <i class="ti ti-brand-whatsapp f-18"></i>
                                                    </a>
                                                @endif

                                                {{-- Print Job Card --}}
                                                @can('show order')
                                                    <a class="avtar avtar-xs btn-link-info text-info"
                                                        data-bs-toggle="tooltip" title="{{ __('Print Job Card') }}"
                                                        href="{{ route('order.job_card', encrypt($order->id)) }}" target="_blank">
                                                        <i class="ti ti-printer f-18"></i>
                                                    </a>
                                                @endcan

                                                {{-- View Details --}}
                                                @can('show order')
                                                    <a class="avtar avtar-xs btn-link-primary text-primary"
                                                        data-bs-toggle="tooltip" title="{{ __('Details') }}"
                                                        href="{{ route('order.show', encrypt($order->id)) }}">
                                                        <i class="ti ti-eye f-18"></i>
                                                    </a>
                                                @endcan

                                                {{-- Edit Order --}}
                                                @can('edit order')
                                                    <a class="avtar avtar-xs btn-link-warning text-warning"
                                                        data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                        href="{{ route('order.edit', encrypt($order->id)) }}">
                                                        <i class="ti ti-edit f-18"></i>
                                                    </a>
                                                @endcan

                                                {{-- Delete Order --}}
                                                @can('delete order')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['order.destroy', encrypt($order->id)], 'class' => 'd-inline']) !!}
                                                    <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog" href="#" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-18"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
