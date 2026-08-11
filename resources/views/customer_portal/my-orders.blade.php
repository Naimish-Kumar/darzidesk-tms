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
            --dd-teal: #00796B;
            --dd-teal-light: #E6F4F1;
            --dd-teal-dark: #004D40;
        }
        .dd-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .dd-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .dd-badge-pending { background: #FEF3C7; color: #92400E; }
        .dd-badge-in_progress { background: #E0F2FE; color: #075985; }
        .dd-badge-completed { background: #DCFCE7; color: #166534; }
        .dd-badge-ready_for_delivery { background: #F3E8FF; color: #6B21A8; }
        .dd-badge-delivered { background: #E0E7FF; color: #3730A3; }
        .dd-badge-on_hold { background: #FFEDD5; color: #9A3412; }
        .dd-badge-cancelled { background: #FEE2E2; color: #991B1B; }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="dd-card p-4">
                {{-- Header & Filters --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">{{ __('My Orders & Status') }}</h4>
                        <p class="text-muted mb-0 small">{{ __('Track the real-time stitching and delivery status of your garments') }}</p>
                    </div>

                    <form method="GET" action="{{ route('customer.orders') }}" class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <input type="text" name="search" class="form-control" placeholder="{{ __('Search Order # / Fabric...') }}" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="ti ti-search"></i></button>
                        </div>

                        <select name="status" class="form-select form-select-sm" style="width: 160px;" onchange="this.form.submit()">
                            <option value="">{{ __('All Statuses') }}</option>
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $selectedStatus == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>

                        @if(request('search') || request('status'))
                            <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-light-danger" title="{{ __('Clear Filters') }}">
                                <i class="ti ti-x"></i>
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
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
                                        <span class="fw-bold text-dark">{{ orderPrefix() . $order->id }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $order->clothTypes->title ?? $order->clothTypes->name ?? '-' }}</span>
                                        @if($order->gender)
                                            <span class="badge bg-light-primary text-primary ms-1" style="font-size: 10px;">{{ ucfirst($order->gender) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $order->febric ?? '-' }}</span>
                                        @if($order->febric_color)
                                            <small class="text-muted d-block">Color: {{ $order->febric_color }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $order->deadline_date ? \Carbon\Carbon::parse($order->deadline_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'dd-badge-' . ($order->status ?? 'pending');
                                        @endphp
                                        <span class="dd-badge {{ $badgeClass }}">
                                            {{ $statuses[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-light-primary" title="{{ __('View Details') }}">
                                            <i class="ti ti-eye me-1"></i> {{ __('Details') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ti ti-shopping-cart-off f-36 d-block mb-2" style="color: #94A3B8;"></i>
                                            <h6 class="fw-bold mb-1">{{ __('No Orders Found') }}</h6>
                                            <p class="small mb-0">{{ __('You currently have no active or completed orders with our atelier.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
