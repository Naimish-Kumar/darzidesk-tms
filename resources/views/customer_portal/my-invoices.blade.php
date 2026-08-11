@extends('layouts.app')

@section('page-title')
    {{ __('My Invoices') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('My Invoices') }}</li>
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
        }
        .dd-badge-paid { background: #DCFCE7; color: #166534; }
        .dd-badge-unpaid { background: #FEE2E2; color: #991B1B; }
        .dd-badge-partial_paid { background: #FEF3C7; color: #92400E; }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="dd-card p-4">
                {{-- Header & Filters --}}
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">{{ __('Billing & Invoices') }}</h4>
                        <p class="text-muted mb-0 small">{{ __('View payment receipts and outstanding balances for your tailored items') }}</p>
                    </div>

                    <form method="GET" action="{{ route('customer.invoices') }}" class="d-flex align-items-center gap-2">
                        <select name="status" class="form-select form-select-sm" style="width: 160px;" onchange="this.form.submit()">
                            <option value="">{{ __('All Statuses') }}</option>
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $selectedStatus == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if(request('status'))
                            <a href="{{ route('customer.invoices') }}" class="btn btn-sm btn-light-danger" title="{{ __('Clear') }}">
                                <i class="ti ti-x"></i>
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Invoices Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Invoice #') }}</th>
                                <th>{{ __('Invoice Date') }}</th>
                                <th>{{ __('Due Date') }}</th>
                                <th>{{ __('Total Amount') }}</th>
                                <th>{{ __('Paid') }}</th>
                                <th>{{ __('Balance Due') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                @php
                                    $total = $invoice->getInvoiceTotalAmount();
                                    $paid = $invoice->getPaidAmount();
                                    $due = $invoice->getInvoiceDueAmount();
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fw-bold text-dark">{{ invoicePrefix() . $invoice->invoice_id }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-dark">{{ priceFormat($total) }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">{{ priceFormat($paid) }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $due > 0 ? 'text-danger fw-bold' : 'text-muted' }}">{{ priceFormat($due) }}</span>
                                    </td>
                                    <td>
                                        @php $badgeClass = 'dd-badge-' . ($invoice->status ?? 'unpaid'); @endphp
                                        <span class="dd-badge {{ $badgeClass }}">
                                            {{ $statuses[$invoice->status] ?? ucwords(str_replace('_', ' ', $invoice->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('customer.invoices.show', $invoice->id) }}" class="btn btn-sm btn-light-primary">
                                            <i class="ti ti-eye me-1"></i> {{ __('View') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ti ti-receipt-off f-36 d-block mb-2" style="color: #94A3B8;"></i>
                                            <h6 class="fw-bold mb-1">{{ __('No Invoices Found') }}</h6>
                                            <p class="small mb-0">{{ __('No invoices or receipts recorded for your account yet.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $invoices->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
