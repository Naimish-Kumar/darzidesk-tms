@extends('layouts.app')

@section('page-title')
    {{ __('Customer Profile & Passport') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">{{ __('Customers') }}</a></li>
        <li class="breadcrumb-item active">{{ $customer->name }}</li>
    </ul>
@endsection

@section('content')
<div class="row g-4">
    <!-- Left Profile Card -->
    <div class="col-xl-4 col-lg-5">
        <div class="card p-4 text-center">
            <div class="mb-3">
                <div class="d-inline-flex align-items-center justify-content-center bg-light-primary text-primary rounded-circle" style="width: 80px; height: 80px; font-weight:800; font-size:28px;">
                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                </div>
            </div>
            <h4 class="fw-bold mb-1">{{ $customer->name }}</h4>
            <p class="text-muted mb-3 font-monospace" style="font-size:12px;">ID: #CST-{{ 1000 + $customer->id }}</p>

            <div class="border-top pt-3 text-start" style="font-size:13px;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Email</span>
                    <span class="fw-bold font-monospace">{{ $customer->email ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Phone / WhatsApp</span>
                    <span class="fw-bold font-monospace">{{ $customer->phone_number ?? $customer->phone ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Gender</span>
                    <span class="fw-bold">{{ ucfirst($customer->gender ?? 'Unspecified') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right History & Measurements Tabs -->
    <div class="col-xl-8 col-lg-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-3">{{ __('Order History & Tailoring Log') }}</h5>
            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle mb-0" style="font-size:13px;">
                    <thead>
                        <tr class="text-muted">
                            <th>ORDER ID</th>
                            <th>STATUS</th>
                            <th>AMOUNT</th>
                            <th>DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $ord)
                            <tr>
                                <td class="font-monospace fw-bold">#{{ $ord->order_id ?? 'ORD-'.$ord->id }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($ord->status) }}</span></td>
                                <td class="font-monospace fw-bold text-success">{{ priceFormat($ord->total_amount ?? 0) }}</td>
                                <td class="text-muted font-monospace">{{ $ord->created_at ? $ord->created_at->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No past order history for this customer.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <h5 class="fw-bold mb-3">{{ __('Saved Anatomical Measurements') }}</h5>
            <div class="row g-2">
                @forelse($measurements as $m)
                    <div class="col-md-4">
                        <div class="p-3 border rounded-3 text-center bg-light">
                            <div class="text-muted text-uppercase fw-bold" style="font-size:10px;">{{ $m->title ?? 'Measurement' }}</div>
                            <div class="fs-5 fw-bold font-monospace text-primary">{{ $m->value ?? 'N/A' }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-3">No custom measurements recorded.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
