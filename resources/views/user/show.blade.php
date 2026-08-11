@extends('layouts.app')
@php
    $profile = asset(Storage::url('upload/profile/'));
    $userAvatar = asset('storage/upload/profile/avatar.png');
    if (!empty($user->profile) && file_exists(public_path('storage/upload/profile/' . $user->profile))) {
        $userAvatar = asset('storage/upload/profile/' . $user->profile);
    }
    $companyName = getSettingsValByName('company_name') ?: config('app.name', 'DarziDesk');
    $companyEmail = getSettingsValByName('company_email') ?: 'support@darzidesk.com';
    $companyPhone = getSettingsValByName('company_phone') ?: '+91 98765 43210';
    $companyLogo = getSettingsValByName('company_logo');
    $logoUrl = !empty($companyLogo) ? asset(Storage::url('upload/logo/' . $companyLogo)) : asset('assets/images/logo-dark.svg');
    $userCode = 'EMP-' . str_pad($user->id, 5, '0', STR_PAD_LEFT);
    $qrPayload = json_encode([
        'code' => $userCode,
        'name' => $user->name,
        'role' => ucfirst($user->type),
        'email' => $user->email,
        'phone' => $user->phone_number,
        'company' => $companyName,
    ]);
@endphp

@section('page-title')
    {{ __('User Details') }} & {{ __('Employee Card') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
@endsection

@push('script-page')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            var qrContainer = document.getElementById("empCardQr");
            if (qrContainer) {
                new QRCode(qrContainer, {
                    text: {!! json_encode($qrPayload) !!},
                    width: 110,
                    height: 110,
                    colorDark : "#004D40",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
            }
        });

        function printEmpCard() {
            var printContents = document.getElementById('employeeCardPrintable').innerHTML;
            var originalContents = document.body.innerHTML;
            var win = window.open('', '', 'height=700,width=800');
            win.document.write('<html><head><title>Employee ID Card - {{ $user->name }}</title>');
            win.document.write('<link rel="stylesheet" href="{{ asset("assets/css/style.css") }}"/>');
            win.document.write('<style>body{ background:#f4f6f8; display:flex; justify-content:center; align-items:center; min-height:100vh; font-family:sans-serif;} .card-id-wrapper{ width:340px; margin:auto; }</style>');
            win.document.write('</head><body>');
            win.document.write('<div class="card-id-wrapper">' + printContents + '</div>');
            win.document.write('</body></html>');
            win.document.close();
            win.focus();
            setTimeout(function() {
                win.print();
                win.close();
            }, 600);
        }
    </script>
@endpush

@section('content')
<style>
    .emp-card-container {
        background: linear-gradient(135deg, #004D40 0%, #00796B 50%, #009688 100%);
        border-radius: 20px;
        color: #ffffff;
        box-shadow: 0 15px 35px rgba(0, 77, 64, 0.25);
        position: relative;
        overflow: hidden;
    }
    .emp-card-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        pointer-events: none;
    }
    .emp-card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding-bottom: 14px;
    }
    .emp-qr-box {
        background: #ffffff;
        padding: 10px;
        border-radius: 12px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    .user-info-badge {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<div class="row">
    <!-- Left Column: User Profile Card + Digital Employee ID Card -->
    <div class="col-lg-5 col-xl-4">
        <!-- Quick Profile Overview Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body text-center p-4">
                <div class="position-relative d-inline-block mb-3">
                    <img src="{{ $userAvatar }}" class="rounded-circle border border-4 border-white shadow" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $user->name }}">
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2" title="Active"></span>
                </div>
                <h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
                <p class="text-muted small mb-2"><i class="ti ti-mail me-1"></i>{{ $user->email }}</p>
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-light-primary text-primary px-3 py-2 rounded-pill fw-bold text-uppercase fs-7">{{ $user->type }}</span>
                    <span class="badge bg-light-success text-success px-3 py-2 rounded-pill fs-7">{{ $userCode }}</span>
                </div>

                <div class="border-top pt-3 text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small"><i class="ti ti-phone me-1"></i>{{ __('Phone') }}</span>
                        <span class="fw-semibold small text-dark">{{ $user->phone_number ?: 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small"><i class="ti ti-package me-1"></i>{{ __('Package') }}</span>
                        <span class="fw-semibold small text-dark">{{ !empty($user->subscriptions) ? $user->subscriptions->title : 'Standard' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small"><i class="ti ti-clock me-1"></i>{{ __('Remaining') }}</span>
                        <span class="fw-semibold small text-primary">{!! $user->SubscriptionLeftDay() !!}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Official Employee Digital Pass Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-transparent d-flex align-items-center justify-content-between pt-3 pb-2 border-0">
                <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-id-badge me-2 text-teal"></i>{{ __('Official Employee ID Card') }}</h5>
                <button type="button" class="btn btn-sm btn-outline-teal rounded-pill" onclick="printEmpCard()">
                    <i class="ti ti-printer me-1"></i>{{ __('Print Pass') }}
                </button>
            </div>
            <div class="card-body p-3">
                <div id="employeeCardPrintable">
                    <div class="emp-card-container p-4">
                        <!-- Card Header -->
                        <div class="emp-card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-white rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="ti ti-scissors text-teal fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-white fw-bold tracking-wide text-uppercase" style="font-size: 13px;">{{ $companyName }}</h6>
                                    <small class="text-white-50" style="font-size: 9px; letter-spacing: 1px;">DIGITAL STAFF PASS</small>
                                </div>
                            </div>
                            <span class="badge bg-amber text-dark fw-bold text-uppercase px-2 py-1 fs-8" style="background: #FFD54F; color: #004D40 !important;">VERIFIED</span>
                        </div>

                        <!-- Card Body -->
                        <div class="row align-items-center mt-3 g-3">
                            <div class="col-7">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ $userAvatar }}" class="rounded-circle border border-2 border-white" style="width: 48px; height: 48px; object-fit: cover;" alt="">
                                    <div>
                                        <h5 class="mb-0 text-white fw-bold text-truncate" style="max-width: 130px; font-size: 15px;">{{ $user->name }}</h5>
                                        <span class="badge user-info-badge text-white px-2 py-1 rounded-pill mt-1" style="font-size: 10px;">{{ ucfirst($user->type) }}</span>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <p class="mb-1 text-white-50" style="font-size: 10px;"><i class="ti ti-barcode me-1"></i>ID: <strong class="text-white">{{ $userCode }}</strong></p>
                                    <p class="mb-1 text-white-50 text-truncate" style="font-size: 10px;"><i class="ti ti-mail me-1"></i>{{ $user->email }}</p>
                                    <p class="mb-0 text-white-50" style="font-size: 10px;"><i class="ti ti-phone me-1"></i>{{ $user->phone_number ?: 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="col-5 text-center">
                                <div class="emp-qr-box">
                                    <div id="empCardQr"></div>
                                </div>
                                <small class="d-block text-white-50 mt-1" style="font-size: 8px;">Scan to Verify Staff</small>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="mt-3 pt-2 border-top border-white-10 d-flex justify-content-between align-items-center">
                            <span class="text-white-50" style="font-size: 8px;">DarziDesk Boutique TMS</span>
                            <span class="text-white-50" style="font-size: 8px;">Secured Pass</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Tabs (Transactions History & Package Settings) -->
    <div class="col-lg-7 col-xl-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-bottom">
                <ul class="nav nav-pills card-header-pills" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold px-4 py-2" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true">
                            <i class="ti ti-receipt-2 me-2"></i>{{ __('Transactions History') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold px-4 py-2" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab" aria-selected="false">
                            <i class="ti ti-package me-2"></i>{{ __('Package Subscription') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">
                    <!-- Tab 1: Transactions -->
                    <div class="tab-pane fade show active" id="profile-1" role="tabpanel">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold text-dark mb-0">{{ __('Package Transaction Logs') }}</h5>
                            <span class="badge bg-light-primary text-primary">{{ count($transactions) }} {{ __('Record(s)') }}</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle advance-datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('User') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Subscription') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Payment Type') }}</th>
                                        <th>{{ __('Payment Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <span class="fw-bold text-dark">{{ !empty($transaction->users) ? $transaction->users->name : $user->name }}</span>
                                            </td>
                                            <td><span class="text-muted">{{ dateFormat($transaction->created_at) }}</span></td>
                                            <td>
                                                <span class="badge bg-light-info text-info fw-bold">{{ !empty($transaction->subscriptions) ? $transaction->subscriptions->title : '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-dark">{{ $settings['CURRENCY_SYMBOL'] . $transaction->amount }}</span>
                                            </td>
                                            <td><span class="text-capitalize">{{ $transaction->payment_type }}</span></td>
                                            <td>
                                                @if ($transaction->payment_status == 'Pending')
                                                    <span class="badge bg-light-warning text-warning px-3 py-2 rounded-pill">{{ $transaction->payment_status }}</span>
                                                @elseif($transaction->payment_status == 'succeeded' || $transaction->payment_status == 'Success')
                                                    <span class="badge bg-light-success text-success px-3 py-2 rounded-pill">{{ $transaction->payment_status }}</span>
                                                @else
                                                    <span class="badge bg-light-danger text-danger px-3 py-2 rounded-pill">{{ $transaction->payment_status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="ti ti-receipt-off fs-1 d-block mb-2 text-muted"></i>
                                                {{ __('No transaction history records found for this user.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 2: Packages -->
                    <div class="tab-pane fade" id="profile-2" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-5">
                                <div class="p-4 bg-light rounded-4 border">
                                    <h6 class="fw-bold text-dark mb-3"><i class="ti ti-info-circle me-2 text-teal"></i>{{ __('Current Package Limits') }}</h6>
                                    @foreach ($subscriptions as $subscription_key => $subscription)
                                        <ul class="list-unstyled gap-2 plan_change_info mb-0 customCheckdef{{ $subscription_key }}" style="display:{{ $subscription->id == $user->subscription ? 'block' : 'none' }}">
                                            <li class="d-flex justify-content-between py-2 border-bottom">
                                                <span class="text-muted">{{ __('User Limit') }}</span>
                                                <span class="fw-bold text-dark">{{ $subscription->user_limit == 0 ? __('Unlimited') : $subscription->user_limit }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between py-2 border-bottom">
                                                <span class="text-muted">{{ __('Customer Limit') }}</span>
                                                <span class="fw-bold text-dark">{{ $subscription->customer_limit == 0 ? __('Unlimited') : $subscription->customer_limit }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between py-2 border-bottom">
                                                <span class="text-muted">{{ __('Cloth Type Limit') }}</span>
                                                <span class="fw-bold text-dark">{{ $subscription->cloth_type_limit == 0 ? __('Unlimited') : $subscription->cloth_type_limit }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between py-2 pt-3">
                                                <span class="text-muted">{{ __('Logged History') }}</span>
                                                @if ($subscription->enabled_logged_history)
                                                    <span class="badge bg-light-success text-success">{{ __('Enabled') }}</span>
                                                @else
                                                    <span class="badge bg-light-danger text-danger">{{ __('Disabled') }}</span>
                                                @endif
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-7">
                                <h6 class="fw-bold text-dark mb-3">{{ __('Assign Package Plan') }}</h6>
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($subscriptions as $sitem_key => $item)
                                        <div class="card border mb-0 p-3 rounded-3 shadow-none {{ $item->id == $user->subscription ? 'border-teal bg-light-teal' : '' }}">
                                            <div class="form-check p-0">
                                                <input type="radio" name="radio1" class="form-check-input input-primary plan_change d-none" {{ $item->id == $user->subscription ? 'checked' : '' }} id="customCheckdef{{ $sitem_key }}" />
                                                <label class="form-check-label d-block w-100 cursor-pointer" for="customCheckdef{{ $sitem_key }}">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <h6 class="fw-bold text-dark mb-1">{{ $item->title }}</h6>
                                                            <small class="text-muted">{{ $item->package_amount }}{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }} / {{ $item->interval }}</small>
                                                        </div>
                                                        <div>
                                                            @if ($item->id == $user->subscription)
                                                                <span class="badge bg-teal text-white px-3 py-2 rounded-pill">{{ __('Current Active Plan') }}</span>
                                                            @else
                                                                {!! Form::open([
                                                                    'method' => 'POST',
                                                                    'route' => [
                                                                        'subscription.manual_assign_package',
                                                                        [\Illuminate\Support\Facades\Crypt::encrypt($item->id), $user->id],
                                                                    ],
                                                                ]) !!}
                                                                <button type="submit" class="btn btn-sm btn-outline-teal rounded-pill px-3">
                                                                    {{ __('Switch Plan') }}
                                                                </button>
                                                                {!! Form::close() !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
