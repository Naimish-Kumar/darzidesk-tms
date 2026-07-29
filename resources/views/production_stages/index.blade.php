@extends('layouts.app')
@section('page-title')
    {{ __('Production Stage Settings') }}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('production.kanban') }}">{{ __('Production Board') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Stage Settings') }}</a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Custom Production Stages Pipeline') }}</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStageModal">
                        <i class="ti ti-plus me-1"></i> {{ __('Add Production Stage') }}
                    </button>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('Sequence') }}</th>
                                    <th>{{ __('Stage Name') }}</th>
                                    <th>{{ __('Badge Color') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stages as $stage)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light-primary text-primary fw-bold fs-6">#{{ $stage->order_index }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark fs-6">{{ $stage->name }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle me-2" style="width: 18px; height: 18px; background-color: {{ $stage->color_code }};"></div>
                                                <code>{{ $stage->color_code }}</code>
                                            </div>
                                        </td>
                                        <td>
                                            @if($stage->is_default)
                                                <span class="badge bg-light-secondary text-secondary">Default</span>
                                            @else
                                                <span class="badge bg-light-info text-info">Custom</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editStageModal{{ $stage->id }}">
                                                <i class="ti ti-pencil"></i> Edit
                                            </button>
                                            @if(!$stage->is_default)
                                                <form action="{{ route('production-stages.destroy', $stage->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deleting stage will reassign orders to default stage. Proceed?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Edit Stage Modal -->
                                    <div class="modal fade" id="editStageModal{{ $stage->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="{{ route('production-stages.update', $stage->id) }}" method="POST" class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit {{ $stage->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Stage Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $stage->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Color Code</label>
                                                        <input type="color" name="color_code" class="form-control form-control-color w-100" value="{{ $stage->color_code }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Sequence Order Index</label>
                                                        <input type="number" name="order_index" class="form-control" value="{{ $stage->order_index }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Stage</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="ti ti-info-circle text-primary me-2"></i>Stage Pipeline Help</h5>
                    <p class="text-muted small">
                        Custom production stages allow tailor shops to align DarziDesk with their exact physical workflow.
                    </p>
                    <ul class="text-muted small ps-3">
                        <li class="mb-2"><strong>Sequence Index</strong> determines column ordering on the Kanban board.</li>
                        <li class="mb-2">Moving orders to <em>Ready for Pickup</em> or <em>Delivered</em> updates order status automatically.</li>
                        <li class="mb-2">Tailors can be assigned to individual stages with piece-rate compensation.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stage Modal -->
    <div class="modal fade" id="addStageModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('production-stages.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add Custom Production Stage') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Stage Name') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Buttoning & Embroidery" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Stage Color') }}</label>
                        <input type="color" name="color_code" class="form-control form-control-color w-100" value="#8B5CF6">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Create Stage') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
