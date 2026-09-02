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

        .dd-filter-select {
            background-color: var(--dd-input-bg) !important;
            border-color: var(--dd-input-border) !important;
            color: var(--dd-text-title) !important;
            border-radius: 10px;
            font-size: 13px;
        }

        .dd-filter-select:focus {
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

        .dd-invoice-id-badge {
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

        .dd-badge-paid { background: rgba(34, 197, 94, 0.15); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.4); }
        .dd-badge-unpaid { background: rgba(239, 68, 68, 0.15); color: #F87171; border: 1px solid rgba(239, 68, 68, 0.4); }
        .dd-badge-partial_paid { background: rgba(217, 164, 65, 0.15); color: #F4C861; border: 1px solid rgba(217, 164, 65, 0.4); }

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
                        <h4 class="mb-1 dd-portal-title">{{ __('Billing & Invoices') }}</h4>
                        <p class="dd-portal-sub mb-0">{{ __('View payment receipts, breakdown items, and outstanding balances for your tailored garments') }}</p>
                    </div>

                    <form method="GET" action="{{ route('customer.invoices') }}" class="d-flex align-items-center gap-2">
                        <select name="status" class="form-select form-select-sm dd-filter-select" style="width: 160px;" onchange="this.form.submit()">
                            <option value="">{{ __('All Statuses') }}</option>
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $selectedStatus == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if(request('status'))
                            <a href="{{ route('customer.invoices') }}" class="btn btn-sm btn-outline-danger" title="{{ __('Clear') }}">
                                <i class="ti ti-x"></i>
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Invoices Table --}}
                <div class="table-responsive">
                    <table class="table dd-portal-table align-middle w-100 mb-0">
                        <thead>
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
                                        <span class="dd-invoice-id-badge">{{ invoicePrefix() . $invoice->invoice_id }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-gold" style="color: var(--dd-gold);">{{ priceFormat($total) }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">{{ priceFormat($paid) }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $due > 0 ? 'text-danger fw-bold' : 'dd-portal-sub' }}">{{ priceFormat($due) }}</span>
                                    </td>
                                    <td>
                                        @php $badgeClass = 'dd-badge-' . ($invoice->status ?? 'unpaid'); @endphp
                                        <span class="dd-status-badge {{ $badgeClass }}">
                                            {{ $statuses[$invoice->status] ?? ucwords(str_replace('_', ' ', $invoice->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('customer.invoices.show', $invoice->id) }}" class="dd-action-btn">
                                            <i class="ti ti-eye"></i> {{ __('View') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="dd-empty-state">
                                            <div class="dd-empty-icon">
                                                <i class="ti ti-receipt-2"></i>
                                            </div>
                                            <h5 class="fw-bold dd-portal-title mb-1">{{ __('No Invoices Recorded') }}</h5>
                                            <p class="dd-portal-sub mb-0">{{ __('No invoices or receipts are currently recorded for your account.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($invoices->hasPages())
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top" style="border-color: var(--dd-card-border) !important;">
                        {{ $invoices->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
