@extends('layouts.auth')
@section('tab-title')
    {{ __('Verify') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="auth-header">
                        <h2 class="text-secondary"><b>{{ __('Verify your email address') }} </b></h2>
                        @if (session('resent'))
                            <div class="alert alert-secondary" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    </div>
                    <hr />
                    <h5 class="d-flex justify-content-center flex-column align-items-center gap-2">
                        <span>{{ __('If you did not receive the email') }}</span>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-secondary p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>
                        </form>
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endsection
