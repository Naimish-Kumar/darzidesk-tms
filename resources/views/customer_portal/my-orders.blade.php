@extends('layouts.app')

@section('page-title')
    {{ __('My Orders') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('My Orders') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --dd-gold: #D9A441;
            --dd-gold-hover: #F4C861;
            --dd-gold-light: rgba(217, 164, 65, 0.12);
            --dd-card-bg: #FFFFFF;
            --dd-card-border: #E2E8F0;
            --dd-text-title: #0F172A;
            --dd-text-sub: #64748B;
            --dd-table-header-bg: #F8FAFC;
            --dd-table-row-hover: #F8FAFC;
            --dd-input-bg: #FFFFFF;
            --dd-input-border: #CBD5E1;
        }

        [data-pc-theme="dark"] {
            --dd-card-bg: #0B2239;
            --dd-card-border: #29435D;
            --dd-text-title: #FFFFFF;
            --dd-text-sub: #8FA1B5;
            --dd-table-header-bg: #102B45;
            --dd-table-row-hover: rgba(255, 255, 255, 0.04);
            --dd-input-bg: #102B45;
            --dd-input-border: #29435D;
        }

        .dd-portal-card {
            background: var(--dd-card-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
        }

        .dd-portal-title {
            color: var(--dd-text-title);
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .dd-portal-sub {
            color: var(--dd-text-sub);
            font-size: 13px;
        }

        .dd-filter-input, .dd-filter-select {
            background-color: var(--dd-input-bg) !important;
            border-color: var(--dd-input-border) !important;
            color: var(--dd-text-title) !important;
            border-radius: 10px;
            font-size: 13px;
        }

        .dd-filter-input:focus, .dd-filter-select:focus {
            border-color: var(--dd-gold) !important;
            box-shadow: 0 0 0 3px var(--dd-gold-light) !important;
        }

        .dd-portal-table {
            color: var(--dd-text-title);
        }

        .dd-portal-table thead th {
            background: var(--dd-table-header-bg) !important;
            color: var(--dd-gold) !important;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid var(--dd-card-border);
            padding: 14px 16px;
        }

        .dd-portal-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--dd-card-border);
            vertical-align: middle;
            color: var(--dd-text-title);
        }

        .dd-portal-table tbody tr:hover td {
            background: var(--dd-table-row-hover);
        }

        .dd-order-id-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            color: var(--dd-gold);
            background: var(--dd-gold-light);
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid rgba(217, 164, 65, 0.3);
            display: inline-block;
        }

        .dd-status-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .dd-status-pending { background: rgba(217, 164, 65, 0.15); color: #F4C861; border: 1px solid rgba(217, 164, 65, 0.4); }
        .dd-status-in_progress { background: rgba(59, 130, 246, 0.15); color: #60A5FA; border: 1px solid rgba(59, 130, 246, 0.4); }
        .dd-status-completed { background: rgba(34, 197, 94, 0.15); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.4); }
        .dd-status-ready_for_delivery { background: rgba(168, 85, 247, 0.15); color: #C084FC; border: 1px solid rgba(168, 85, 247, 0.4); }
        .dd-status-delivered { background: rgba(99, 102, 241, 0.15); color: #818CF8; border: 1px solid rgba(99, 102, 241, 0.4); }
        .dd-status-on_hold { background: rgba(249, 115, 22, 0.15); color: #FB923C; border: 1px solid rgba(249, 115, 22, 0.4); }
        .dd-status-cancelled { background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.4); }

        .dd-action-btn {
            background: var(--dd-gold-light);
            color: var(--dd-gold) !important;
            border: 1px solid rgba(217, 164, 65, 0.3);
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dd-action-btn:hover {
            background: var(--dd-gold);
            color: #03111F !important;
            border-color: var(--dd-gold);
        }

        .dd-empty-state {
            padding: 48px 24px;
            text-align: center;
        }
        .dd-empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--dd-gold-light);
            color: var(--dd-gold);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 16px;
            border: 1px solid rgba(217, 164, 65, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="dd-portal-card p-4 p-md-5">
                {{-- Header & Filters --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--dd-card-border) !important;">
                    <div>
                        <h4 class="mb-1 dd-portal-title">{{ __('My Orders & Tailoring Status') }}</h4>
                        <p class="dd-portal-sub mb-0">{{ __('Track the real-time stitching, milestone progress, and delivery schedule of your garments') }}</p>
                    </div>

                    <form method="GET" action="{{ route('customer.orders') }}" class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <input type="text" name="search" class="form-control dd-filter-input" placeholder="{{ __('Search Order # / Fabric...') }}" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="ti ti-search"></i></button>
                        </div>

                        <select name="status" class="form-select form-select-sm dd-filter-select" style="width: 160px;" onchange="this.form.submit()">
                            <option value="">{{ __('All Statuses') }}</option>
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $selectedStatus == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>

                        @if(request('search') || request('status'))
                            <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-danger" title="{{ __('Clear Filters') }}">
                                <i class="ti ti-x"></i>
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table dd-portal-table align-middle w-100 mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Garment / Cloth Type') }}</th>
                                <th>{{ __('Fabric & Color') }}</th>
                                <th>{{ __('Order Date') }}</th>
                                <th>{{ __('Estimated Delivery') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        <span class="dd-order-id-badge">{{ orderPrefix() . $order->id }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $order->clothTypes->title ?? $order->clothTypes->name ?? '-' }}</div>
                                        @if($order->gender)
                                            <span class="badge bg-light-primary text-primary" style="font-size: 10px;">{{ ucfirst($order->gender) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $order->febric ?? '-' }}</div>
                                        @if($order->febric_color)
                                            <small class="dd-portal-sub d-block"><i class="ti ti-palette me-1"></i>{{ $order->febric_color }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $order->deadline_date ? \Carbon\Carbon::parse($order->deadline_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusKey = $order->status ?? 'pending';
                                            $badgeClass = 'dd-status-' . $statusKey;
                                        @endphp
                                        <span class="dd-status-badge {{ $badgeClass }}">
                                            {{ $statuses[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('customer.orders.show', $order->id) }}" class="dd-action-btn" title="{{ __('View Details') }}">
                                            <i class="ti ti-eye"></i> {{ __('View Details') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="dd-empty-state">
                                            <div class="dd-empty-icon">
                                                <i class="ti ti-scissors"></i>
                                            </div>
                                            <h5 class="fw-bold dd-portal-title mb-1">{{ __('No Tailoring Orders Found') }}</h5>
                                            <p class="dd-portal-sub mb-3">{{ __('You currently have no active or completed orders with our atelier.') }}</p>
                                            <a href="{{ route('track.order') }}" class="dd-action-btn py-2 px-3">
                                                <i class="ti ti-search me-1"></i> {{ __('Track an Order Code') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($orders->hasPages())
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top" style="border-color: var(--dd-card-border) !important;">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
