@extends('layouts.app')
@section('page-title')
    {{ __('Manage Blogs') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Blogs') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Blog List') }}</h5>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                data-url="{{ route('blog.create') }}" data-title="{{ __('Create New Blog') }}">
                                <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Blog') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th width="150px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>
                                            @if($blog->image)
                                                <img src="{{ asset(Storage::url('upload/'.$blog->image)) }}" width="50px" class="rounded">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input change-status" 
                                                    data-url="{{ route('blog.status', $blog->id) }}"
                                                    {{ $blog->is_active == 1 ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="Action">
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                                                    data-bs-toggle="tooltip" data-bs-original-title="{{ __('Edit') }}"
                                                    data-url="{{ route('blog.edit', $blog->id) }}"
                                                    data-size="lg"
                                                    data-title="{{ __('Edit Blog') }}"> <i data-feather="edit"></i></a>
                                                
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $blog->id], 'id' => 'delete-form-' . $blog->id]) !!}
                                                    <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                        data-bs-toggle="tooltip" data-bs-original-title="{{ __('Delete') }}"
                                                        href="#"> <i data-feather="trash-2"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('change', '.change-status', function() {
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    show_toastr('Success', data.message, 'success');
                }
            });
        });
    </script>
@endpush
