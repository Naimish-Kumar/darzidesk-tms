@extends('layouts.app')
@section('hide_page_header', true)
@section('page-title')
    {{ __('Fabric & Inventory Stock') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Inventory') }}</li>
@endsection

@push('css-page')
    <style>
        :root {
            --mat-banner-bg: #FFFFFF;
            --mat-banner-border: #E2E8F0;
            --mat-card-bg: #FFFFFF;
            --mat-card-border: #E2E8F0;
            --mat-inner-bg: #F8FAFC;
            --mat-text-title: #0F172A;
            --mat-text-sub: #64748B;
            --dd-gold: #D9A441;
        }

        [data-pc-theme="dark"] {
            --mat-banner-bg: #0B2239;
            --mat-banner-border: #29435D;
            --mat-card-bg: #0B2239;
            --mat-card-border: #29435D;
            --mat-inner-bg: #102B45;
            --mat-text-title: #FFFFFF;
            --mat-text-sub: #8FA1B5;
        }

        .dd-mat-banner {
            background: var(--mat-banner-bg) !important;
            border: 1px solid var(--mat-banner-border) !important;
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }
        .dd-mat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(217, 164, 65, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(217, 164, 65, 0.3);
        }
        .dd-mat-icon i {
            font-size: 24px;
            color: var(--dd-gold);
        }
        .dd-mat-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--mat-text-title);
            margin-bottom: 2px;
        }
        .dd-mat-subtitle {
            font-size: 13.5px;
            color: var(--mat-text-sub);
            margin-bottom: 0;
        }

        .dd-stat-card {
            background: var(--mat-card-bg) !important;
            border: 1px solid var(--mat-card-border) !important;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .dd-card {
            background: var(--mat-card-bg) !important;
            border: 1px solid var(--mat-card-border) !important;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }
        .dd-table th {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--dd-gold) !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: var(--mat-inner-bg) !important;
            padding: 14px 20px;
            border-bottom: 1px solid var(--mat-card-border);
        }
        .dd-table td {
            font-size: 14px;
            padding: 14px 20px;
            vertical-align: middle;
            border-bottom: 1px solid var(--mat-card-border);
            color: var(--mat-text-title);
        }
        .dd-table tr:hover td {
            background: rgba(217, 164, 65, 0.06);
        }

        .dd-code-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--dd-gold);
            background: rgba(217, 164, 65, 0.15);
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid rgba(217, 164, 65, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="dd-dashboard">
        {{-- Banner Card --}}
        <div class="dd-mat-banner">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="dd-mat-icon">
                        <i class="ti ti-box"></i>
                    </div>
                    <div>
                        <h4 class="dd-mat-title">{{ __('Fabric & Inventory Stock Tracking') }}</h4>
                        <p class="dd-mat-subtitle">{{ __('Track fabric roll quantities in meters/yards, color swatches, unit costs, and automated stock deduction') }}</p>
                    </div>
                </div>
                <div>
                    <button class="btn text-dark fw-bold px-4" data-bs-toggle="modal" data-bs-target="#addMaterialModal" style="background: var(--dd-gold); border-radius:10px;">
                        <i class="ti ti-plus me-1"></i> {{ __('Add Fabric Roll') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-12">
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-semibold" style="font-size: 11.5px; letter-spacing: 0.5px; color: var(--mat-text-sub);">{{ __('Total Fabric Items') }}</span>
                            <h3 class="fw-bold mb-0 mt-1" style="color: var(--mat-text-title);">{{ $materials->count() }}</h3>
                        </div>
                        <div class="rounded-3 p-3" style="background: rgba(217, 164, 65, 0.15); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.3);">
                            <i class="ti ti-box fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-semibold" style="font-size: 11.5px; letter-spacing: 0.5px; color: var(--mat-text-sub);">{{ __('Low Stock Alerts') }}</span>
                            <h3 class="fw-bold {{ $lowStockMaterials->count() > 0 ? 'text-danger' : '' }} mb-0 mt-1" style="{{ $lowStockMaterials->count() == 0 ? 'color: var(--mat-text-title);' : '' }}">
                                {{ $lowStockMaterials->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 p-3" style="background: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.3);">
                            <i class="ti ti-alert-triangle fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="dd-stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-semibold" style="font-size: 11.5px; letter-spacing: 0.5px; color: var(--mat-text-sub);">{{ __('Total Inventory Value') }}</span>
                            <h3 class="fw-bold mb-0 mt-1" style="color: var(--mat-text-title);">
                                {{ priceFormat($materials->sum(fn($m) => $m->quantity * $m->unit_cost)) }}
                            </h3>
                        </div>
                        <div class="rounded-3 p-3" style="background: rgba(34, 197, 94, 0.15); color: #22C55E; border: 1px solid rgba(34, 197, 94, 0.3);">
                            <i class="ti ti-coin fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock Alert Banner --}}
        @if($lowStockMaterials->count() > 0)
            <div class="alert alert-warning shadow-sm border-0 rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-alert-circle fs-3 text-warning"></i>
                    <div>
                        <strong class="text-dark">{{ __('Low Stock Warning:') }}</strong>
                        <span class="text-muted" style="font-size: 13.5px;">
                            {{ $lowStockMaterials->count() }} {{ __('fabric item(s) are below reorder threshold!') }}
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 flex-wrap">
                    @foreach($lowStockMaterials->take(4) as $lowMat)
                        <span class="badge bg-white text-danger border border-danger me-1">
                            {{ $lowMat->name }}: {{ $lowMat->quantity }} {{ $lowMat->unit }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Material Table Card --}}
        <div class="dd-card">
            <div class="table-responsive">
                <table class="table dd-table advance-datatable mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Fabric Roll / Code') }}</th>
                            <th>{{ __('Color Swatch') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('In Stock') }}</th>
                            <th>{{ __('Reorder Threshold') }}</th>
                            <th>{{ __('Unit Cost') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materials as $material)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 14px;">{{ $material->name }}</div>
                                    <span class="dd-code-badge">{{ $material->code ?? 'FAB-ROLL' }}</span>
                                </td>
                                <td>
                                    {!! $material->getColorSwatchHtml() !!}
                                </td>
                                <td>
                                    <span class="badge" style="background:#F1F5F9; color:#475569; font-weight:600;">
                                        {{ $material->category }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $material->isLowStock() ? 'text-danger' : 'text-dark' }}" style="font-size: 14px;">
                                        {{ number_format($material->quantity, 2) }} {{ $material->unit }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 13.5px;">
                                        {{ number_format($material->reorder_level, 2) }} {{ $material->unit }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    {{ priceFormat($material->unit_cost) }}
                                </td>
                                <td>
                                    @if($material->isLowStock())
                                        <span class="badge bg-danger text-white" style="font-size: 11px; font-weight: 700; border-radius: 20px;">
                                            <i class="ti ti-alert-triangle me-1"></i>Low Stock
                                        </span>
                                    @else
                                        <span class="badge bg-success text-white" style="font-size: 11px; font-weight: 700; border-radius: 20px;">
                                            <i class="ti ti-check me-1"></i>In Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        {{-- Restock Button --}}
                                        <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#restockModal{{ $material->id }}" style="border-radius: 8px; font-size: 12px; font-weight: 700;">
                                            <i class="ti ti-plus me-1"></i>{{ __('Restock') }}
                                        </button>

                                        {{-- Edit Button --}}
                                        <button class="btn btn-outline-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editMaterialModal{{ $material->id }}" style="border-radius: 8px;">
                                            <i class="ti ti-pencil"></i>
                                        </button>

                                        {{-- Delete --}}
                                        <form action="{{ route('materials.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this material?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 8px;">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Restock Modal --}}
                                    <div class="modal fade text-start" id="restockModal{{ $material->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <form action="{{ route('materials.restock', $material->id) }}" method="POST" class="modal-content" style="border-radius: 16px;">
                                                @csrf
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="modal-title fw-bold">{{ __('Restock ') . $material->name }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label class="form-label fw-semibold" style="font-size: 13px;">{{ __('Add Quantity (') . $material->unit . ')' }}</label>
                                                    <input type="number" step="0.01" name="add_quantity" class="form-control" placeholder="0.00" required style="border-radius: 10px;">
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button type="submit" class="btn btn-success btn-sm fw-bold">{{ __('Confirm Restock') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade text-start" id="editMaterialModal{{ $material->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('materials.update', $material->id) }}" method="POST" class="modal-content" style="border-radius: 16px;">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold">{{ __('Edit Fabric Roll') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">{{ __('Fabric Name') }} *</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $material->name }}" required style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">{{ __('Item Code') }}</label>
                                                        <input type="text" name="code" class="form-control" value="{{ $material->code }}" style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">{{ __('Category') }} *</label>
                                                        <select name="category" class="form-select" style="border-radius: 10px;">
                                                            <option value="Fabric Roll" {{ $material->category == 'Fabric Roll' ? 'selected' : '' }}>Fabric Roll</option>
                                                            <option value="Lining" {{ $material->category == 'Lining' ? 'selected' : '' }}>Lining</option>
                                                            <option value="Buttons & Trims" {{ $material->category == 'Buttons & Trims' ? 'selected' : '' }}>Buttons & Trims</option>
                                                            <option value="Threads & Zippers" {{ $material->category == 'Threads & Zippers' ? 'selected' : '' }}>Threads & Zippers</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">{{ __('Unit') }} *</label>
                                                        <select name="unit" class="form-select" style="border-radius: 10px;">
                                                            <option value="Meters" {{ $material->unit == 'Meters' ? 'selected' : '' }}>Meters (m)</option>
                                                            <option value="Yards" {{ $material->unit == 'Yards' ? 'selected' : '' }}>Yards (yd)</option>
                                                            <option value="Pcs" {{ $material->unit == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">{{ __('Color Name') }}</label>
                                                        <input type="text" name="color_name" class="form-control" value="{{ $material->color_name }}" placeholder="e.g. Navy Blue" style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">{{ __('Color Swatch Hex') }}</label>
                                                        <input type="color" name="color_code" class="form-control form-control-color w-100" value="{{ $material->color_code ?: '#00796B' }}" style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">{{ __('Quantity') }} *</label>
                                                        <input type="number" step="0.01" name="quantity" class="form-control" value="{{ $material->quantity }}" required style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">{{ __('Reorder Level') }} *</label>
                                                        <input type="number" step="0.01" name="reorder_level" class="form-control" value="{{ $material->reorder_level }}" required style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">{{ __('Unit Cost') }} *</label>
                                                        <input type="number" step="0.01" name="unit_cost" class="form-control" value="{{ $material->unit_cost }}" required style="border-radius: 10px;">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button type="submit" class="btn text-white fw-bold" style="background:#00796B; border-radius:10px;">{{ __('Save Changes') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="ti ti-box-x fs-1 d-block mb-2 text-secondary"></i>
                                    <small>{{ __('No fabric items found in inventory') }}</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add Material Modal --}}
    <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('materials.store') }}" method="POST" class="modal-content" style="border-radius: 16px;">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">{{ __('Add New Fabric Roll') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Fabric Name') }} *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Italian Wool 120s" required style="border-radius: 10px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Item Code') }}</label>
                        <input type="text" name="code" class="form-control" placeholder="FAB-101" style="border-radius: 10px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Category') }} *</label>
                        <select name="category" class="form-select" style="border-radius: 10px;">
                            <option value="Fabric Roll">Fabric Roll</option>
                            <option value="Lining">Lining</option>
                            <option value="Buttons & Trims">Buttons & Trims</option>
                            <option value="Threads & Zippers">Threads & Zippers</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Unit') }} *</label>
                        <select name="unit" class="form-select" style="border-radius: 10px;">
                            <option value="Meters">Meters (m)</option>
                            <option value="Yards">Yards (yd)</option>
                            <option value="Pcs">Pcs</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Color Name') }}</label>
                        <input type="text" name="color_name" class="form-control" placeholder="e.g. Midnight Blue" style="border-radius: 10px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Color Swatch Hex') }}</label>
                        <input type="color" name="color_code" class="form-control form-control-color w-100" value="#00796B" style="border-radius: 10px;">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('Initial Qty') }} *</label>
                        <input type="number" step="0.01" name="quantity" class="form-control" placeholder="100.00" required style="border-radius: 10px;">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('Reorder Level') }} *</label>
                        <input type="number" step="0.01" name="reorder_level" class="form-control" placeholder="15.00" required style="border-radius: 10px;">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('Unit Cost') }} *</label>
                        <input type="number" step="0.01" name="unit_cost" class="form-control" placeholder="25.00" required style="border-radius: 10px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn text-white fw-bold" style="background:#00796B; border-radius:10px;">{{ __('Save Fabric Roll') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
