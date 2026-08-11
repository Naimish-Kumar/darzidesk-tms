@extends('layouts.app')
@php
    $profile = asset(Storage::url('upload/profile/'));
@endphp
@section('page-title')
    {{ __('Customer Directory') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Customer Directory') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0 fw-bold">{{ __('Customer Directory') }}</h5>
                        <small class="text-muted">{{ __('Manage tailoring clients, measurements, and order history') }}</small>
                    </div>
                    @if (Gate::check('create customer'))
                        <div>
                            <a href="{{ route('customer.create') }}"
                                class="btn btn-primary" style="background: #00796B; border-color: #00796B;">
                                <i class="ti ti-user-plus me-1"></i> {{ __('New Customer') }}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Customer Profile') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone Number') }}</th>
                                    <th>{{ __('Created Date') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ !empty($customer->profile) && file_exists(public_path('storage/upload/profile/' . $customer->profile)) ? asset('storage/upload/profile/' . $customer->profile) : asset('storage/upload/profile/avatar.png') }}"
                                                    alt="user-image" class="rounded-circle border"
                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                    onerror="this.onerror=null;this.src='{{ asset('storage/upload/profile/avatar.png') }}';" />
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark">{{ $customer->name }}</h6>
                                                    <small class="text-muted">#CUST-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $customer->email ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $customer->phone_number ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $customer->created_at ? $customer->created_at->format('M d, Y') : '-' }}</span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                @if (Gate::check('edit customer'))
                                                    <a href="#" data-size="lg"
                                                        data-url="{{ route('customer.edit', \Illuminate\Support\Facades\Crypt::encrypt($customer->id)) }}"
                                                        data-title="{{ __('Edit Customer') }}"
                                                        class="btn btn-sm btn-light-primary customModal"
                                                        data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                @endif
                                                @if (Gate::check('delete customer'))
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['customer.destroy', $customer->id],
                                                        'id' => 'delete-form-' . $customer->id,
                                                        'class' => 'd-inline',
                                                    ]) !!}
                                                    <a href="#"
                                                        class="btn btn-sm btn-light-danger show_confirm"
                                                        data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($customers->isEmpty())
                                    <tr>
                                        <td class="text-center py-4 text-muted">
                                            <i class="ti ti-users f-24 d-block mb-1"></i>
                                            {{ __('No customers found.') }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
