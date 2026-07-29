@extends('layouts.app')
@section('page-title')
    {{ __('Fabric & Trim Inventory') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Inventory') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <!-- Summary Cards -->
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase fw-semibold mb-1">{{ __('Total Materials') }}</h6>
                            <h3 class="text-white fw-bold mb-0">{{ $materials->count() }}</h3>
                        </div>
                        <div class="fs-1 text-white-50"><i class="ti ti-box"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase fw-semibold mb-1">{{ __('Low Stock Alerts') }}</h6>
                            <h3 class="text-white fw-bold mb-0">{{ $lowStockMaterials->count() }}</h3>
                        </div>
                        <div class="fs-1 text-white-50"><i class="ti ti-alert-triangle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase fw-semibold mb-1">{{ __('Total Inventory Value') }}</h6>
                            <h3 class="text-white fw-bold mb-0">${{ number_format($materials->sum(fn($m) => $m->quantity * $m->unit_cost), 2) }}</h3>
                        </div>
                        <div class="fs-1 text-white-50"><i class="ti ti-currency-dollar"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material Table & Add Form -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Material Stock List') }}</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                        <i class="ti ti-plus me-1"></i> {{ __('Add Material') }}
                    </button>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Item Code / Name') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('In Stock') }}</th>
                                    <th>{{ __('Reorder Threshold') }}</th>
                                    <th>{{ __('Unit Cost') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materials as $material)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $material->name }}</div>
                                            <small class="text-muted">{{ $material->code ?? 'No Code' }}</small>
                                        </td>
                                        <td><span class="badge bg-light-primary text-primary">{{ $material->category }}</span></td>
                                        <td>
                                            <span class="fw-bold fs-6 {{ $material->isLowStock() ? 'text-danger' : 'text-dark' }}">
                                                {{ number_format($material->quantity, 2) }} {{ $material->unit }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($material->reorder_level, 2) }} {{ $material->unit }}</td>
                                        <td>${{ number_format($material->unit_cost, 2) }}</td>
                                        <td>
                                            @if($material->isLowStock())
                                                <span class="badge bg-light-danger text-danger"><i class="ti ti-alert-circle me-1"></i>Low Stock</span>
                                            @else
                                                <span class="badge bg-light-success text-success"><i class="ti ti-check me-1"></i>In Stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success me-1" data-bs-toggle="modal" data-bs-target="#restockModal{{ $material->id }}">
                                                <i class="ti ti-plus"></i> Restock
                                            </button>
                                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this material?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Restock Modal -->
                                    <div class="modal fade" id="restockModal{{ $material->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="{{ route('materials.restock', $material->id) }}" method="POST" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Restock {{ $material->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Add Quantity ({{ $material->unit }})</label>
                                                        <input type="number" step="0.01" min="0.01" name="add_quantity" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Restock Stock</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            {{ __('No materials found in inventory. Add your first fabric or trim stock!') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Material Modal -->
    <div class="modal fade" id="addMaterialModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('materials.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add Material to Inventory') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Material Name') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Italian Linen, Brass Buttons" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">{{ __('Item Code') }}</label>
                            <input type="text" name="code" class="form-control" placeholder="e.g., FAB-001">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">{{ __('Category') }}</label>
                            <select name="category" class="form-select" required>
                                <option value="Fabric">Fabric</option>
                                <option value="Trim">Trim</option>
                                <option value="Button">Button</option>
                                <option value="Zipper">Zipper</option>
                                <option value="Thread">Thread</option>
                                <option value="Accessory">Accessory</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">{{ __('Unit') }}</label>
                            <input type="text" name="unit" class="form-control" placeholder="meters, yards, pcs" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">{{ __('Initial Quantity') }}</label>
                            <input type="number" step="0.01" min="0" name="quantity" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">{{ __('Reorder Alert Level') }}</label>
                            <input type="number" step="0.01" min="0" name="reorder_level" class="form-control" value="5.00" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">{{ __('Unit Cost ($)') }}</label>
                            <input type="number" step="0.01" min="0" name="unit_cost" class="form-control" value="0.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save Material') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
