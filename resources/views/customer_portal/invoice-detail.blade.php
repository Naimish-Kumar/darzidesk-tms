@extends('layouts.app')

@section('page-title')
    {{ __('Invoice Details') }} - {{ invoicePrefix() . $invoice->invoice_id }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('customer.invoices') }}">{{ __('My Invoices') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ invoicePrefix() . $invoice->invoice_id }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --dd-gold: #D9A441;
            --dd-gold-hover: #F4C861;
            --dd-gold-light: rgba(217, 164, 65, 0.12);
            --dd-card-bg: #FFFFFF;
            --dd-card-border: #E2E8F0;
            --dd-inner-bg: #F8FAFC;
            --dd-text-title: #0F172A;
            --dd-text-sub: #64748B;
            --dd-table-header-bg: #F8FAFC;
            --dd-table-row-hover: #F8FAFC;
        }

        [data-pc-theme="dark"] {
            --dd-card-bg: #0B2239;
            --dd-card-border: #29435D;
            --dd-inner-bg: #102B45;
            --dd-text-title: #FFFFFF;
            --dd-text-sub: #8FA1B5;
            --dd-table-header-bg: #102B45;
            --dd-table-row-hover: rgba(255, 255, 255, 0.04);
        }

        .dd-portal-card {
            background: var(--dd-card-bg);
            border: 1px solid var(--dd-card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
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

        .dd-status-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .dd-badge-paid { background: rgba(34, 197, 94, 0.15); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.4); }
        .dd-badge-unpaid { background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.4); }
        .dd-badge-partial_paid { background: rgba(217, 164, 65, 0.15); color: #F4C861; border: 1px solid rgba(217, 164, 65, 0.4); }

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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="dd-portal-card p-4 p-md-5">
                {{-- Header --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between border-bottom pb-4 mb-4 gap-3" style="border-color: var(--dd-card-border) !important;">
                    <div>
                        <h4 class="fw-bold mb-1 dd-portal-title">{{ $invoice->shop->shop_name ?? __('DarziDesk Tailoring Studio') }}</h4>
                        <p class="dd-portal-sub mb-0">{{ $invoice->shop->address ?? __('Master Custom Fitting & Tailoring') }}</p>
                    </div>
                    <div class="text-md-end">
                        <span class="dd-portal-sub small d-block mb-1 font-monospace">{{ __('INVOICE RECEIPT') }}</span>
                        <h3 class="fw-bold mb-2 dd-portal-title" style="font-family: 'JetBrains Mono', monospace; color: var(--dd-gold);">{{ invoicePrefix() . $invoice->invoice_id }}</h3>
                        @php $badgeClass = 'dd-badge-' . ($invoice->status ?? 'unpaid'); @endphp
                        <span class="dd-status-badge {{ $badgeClass }}">
                            {{ \App\Models\Invoice::$status[$invoice->status] ?? ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>

                {{-- Customer & Dates Info --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <small class="dd-portal-sub text-uppercase fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.8px;">{{ __('Billed To:') }}</small>
                        <h6 class="fw-bold mb-0 dd-portal-title">{{ $invoice->customers->name ?? Auth::user()->name }}</h6>
                        <span class="dd-portal-sub small d-block">{{ $invoice->customers->email ?? Auth::user()->email }}</span>
                        <span class="dd-portal-sub small d-block">{{ $invoice->customers->phone_number ?? Auth::user()->phone_number }}</span>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <div class="mb-2">
                            <span class="dd-portal-sub small d-block">{{ __('Invoice Date:') }}</span>
                            <strong class="dd-portal-title">{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : '-' }}</strong>
                        </div>
                        <div>
                            <span class="dd-portal-sub small d-block">{{ __('Payment Due Date:') }}</span>
                            <strong class="dd-portal-title" style="color: var(--dd-gold);">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Line Items Table --}}
                <div class="table-responsive mb-4">
                    <table class="table dd-portal-table align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Description / Garment Item') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Qty') }}</th>
                                <th class="text-end">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $items = $invoice->items ?? [];
                                $subtotal = 0;
                            @endphp
                            @if(count($items) > 0)
                                @foreach ($items as $index => $item)
                                    @php
                                        $itemTotal = ($item->price ?? 0) * ($item->quantity ?? 1);
                                        $subtotal += $itemTotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->title ?? $item->description ?? __('Tailoring Service') }}</div>
                                        </td>
                                        <td>{{ priceFormat($item->price ?? 0) }}</td>
                                        <td>{{ $item->quantity ?? 1 }}</td>
                                        <td class="text-end fw-bold">{{ priceFormat($itemTotal) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="fw-semibold">{{ __('Custom Bespoke Tailoring Services') }}</div>
                                        <small class="dd-portal-sub">{{ __('Stitching & fittings as per order #') . ($invoice->orders->id ?? $invoice->order_id) }}</small>
                                    </td>
                                    <td>{{ priceFormat($invoice->getInvoiceTotalAmount()) }}</td>
                                    <td>1</td>
                                    <td class="text-end fw-bold">{{ priceFormat($invoice->getInvoiceTotalAmount()) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Summary Calculation --}}
                <div class="row justify-content-end">
                    <div class="col-md-5 col-sm-6">
                        <div class="p-3 rounded-3" style="background: var(--dd-inner-bg); border: 1px solid var(--dd-card-border);">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="dd-portal-sub small">{{ __('Subtotal:') }}</span>
                                <strong class="dd-portal-title">{{ priceFormat($invoice->getInvoiceTotalAmount()) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="dd-portal-sub small">{{ __('Amount Paid:') }}</span>
                                <strong class="text-success">{{ priceFormat($invoice->getPaidAmount()) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top" style="border-color: var(--dd-card-border) !important;">
                                <span class="dd-portal-title fw-bold">{{ __('Balance Due:') }}</span>
                                <strong class="fw-bold fs-5" style="color: var(--dd-gold);">{{ priceFormat($invoice->getInvoiceDueAmount()) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action / Back --}}
                <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-4" style="border-color: var(--dd-card-border) !important;">
                    <a href="{{ route('customer.invoices') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="ti ti-arrow-left me-1"></i> {{ __('Back to Invoices') }}
                    </a>
                    <button onclick="window.print()" class="btn btn-sm" style="background: var(--dd-gold); color: #03111F; font-weight: 700; border-radius: 8px;">
                        <i class="ti ti-printer me-1"></i> {{ __('Print Receipt') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
