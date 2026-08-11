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
            --dd-teal: #00796B;
            --dd-teal-light: #E6F4F1;
            --dd-teal-dark: #004D40;
        }
        .dd-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .dd-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 10px;
            text-transform: uppercase;
        }
        .dd-badge-paid { background: #DCFCE7; color: #166534; }
        .dd-badge-unpaid { background: #FEE2E2; color: #991B1B; }
        .dd-badge-partial_paid { background: #FEF3C7; color: #92400E; }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="dd-card p-4 p-md-5">
                {{-- Header --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between border-bottom pb-4 mb-4 gap-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">{{ $invoice->shop->shop_name ?? __('DarziDesk Tailoring Studio') }}</h4>
                        <p class="text-muted small mb-0">{{ $invoice->shop->address ?? __('Master Custom Fitting & Tailoring') }}</p>
                    </div>
                    <div class="text-md-end">
                        <span class="text-muted small d-block">{{ __('INVOICE RECEIPT') }}</span>
                        <h3 class="fw-bold mb-1 text-dark">{{ invoicePrefix() . $invoice->invoice_id }}</h3>
                        @php $badgeClass = 'dd-badge-' . ($invoice->status ?? 'unpaid'); @endphp
                        <span class="dd-badge {{ $badgeClass }}">
                            {{ \App\Models\Invoice::$status[$invoice->status] ?? ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>

                {{-- Customer & Dates Info --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1">{{ __('Billed To:') }}</small>
                        <h6 class="fw-bold mb-0 text-dark">{{ $invoice->customers->name ?? Auth::user()->name }}</h6>
                        <span class="text-muted small d-block">{{ $invoice->customers->email ?? Auth::user()->email }}</span>
                        <span class="text-muted small d-block">{{ $invoice->customers->phone_number ?? Auth::user()->phone_number }}</span>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <div class="mb-2">
                            <span class="text-muted small d-block">{{ __('Invoice Date:') }}</span>
                            <strong class="text-dark">{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : '-' }}</strong>
                        </div>
                        <div>
                            <span class="text-muted small d-block">{{ __('Payment Due Date:') }}</span>
                            <strong class="text-dark">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Line Items Table --}}
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Item / Service Description') }}</th>
                                <th class="text-center">{{ __('Qty') }}</th>
                                <th class="text-end">{{ __('Unit Price') }}</th>
                                <th class="text-end">{{ __('Tax') }}</th>
                                <th class="text-end">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoice->items as $index => $item)
                                @php
                                    $itemSub = $item->amount * $item->quantity;
                                    $taxAmt = !empty($item->tax) ? (getTaxRate($item->tax) / 100) * $itemSub : 0;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong class="text-dark">{{ $item->description ?? __('Stitching Service') }}</strong></td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ priceFormat($item->amount) }}</td>
                                    <td class="text-end">{{ priceFormat($taxAmt) }}</td>
                                    <td class="text-end fw-bold text-dark">{{ priceFormat($itemSub + $taxAmt) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">{{ __('No line items listed on this invoice.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Financial Summary Box --}}
                <div class="row justify-content-end mb-4">
                    <div class="col-sm-6 col-md-5">
                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __('Subtotal') }}:</span>
                                <strong class="text-dark">{{ priceFormat($invoice->getInvoiceSubTotalAmount()) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __('Taxes') }}:</span>
                                <strong class="text-dark">{{ priceFormat($invoice->getInvoiceTotalTax()) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 mb-2">
                                <span class="fw-bold text-dark fs-6">{{ __('Total Amount') }}:</span>
                                <span class="fw-bold text-dark fs-6">{{ priceFormat($invoice->getInvoiceTotalAmount()) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>{{ __('Total Paid') }}:</span>
                                <strong>{{ priceFormat($invoice->getPaidAmount()) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 {{ $invoice->getInvoiceDueAmount() > 0 ? 'text-danger' : 'text-muted' }}">
                                <span class="fw-bold">{{ __('Balance Due') }}:</span>
                                <span class="fw-bold fs-6">{{ priceFormat($invoice->getInvoiceDueAmount()) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment History --}}
                @if($invoice->payments->count() > 0)
                    <h6 class="fw-bold mb-3 border-top pt-4 text-dark">{{ __('Payment Records') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Payment Method') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->payments as $pmt)
                                    <tr>
                                        <td>{{ $pmt->payment_date ? \Carbon\Carbon::parse($pmt->payment_date)->format('M d, Y') : '-' }}</td>
                                        <td><span class="badge bg-light-primary text-primary">{{ ucfirst($pmt->payment_method ?? 'Cash') }}</span></td>
                                        <td class="fw-bold text-success">{{ priceFormat($pmt->amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="text-end border-top pt-4 mt-3">
                    <a href="{{ route('customer.invoices') }}" class="btn btn-light me-2">
                        <i class="ti ti-arrow-left me-1"></i> {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
