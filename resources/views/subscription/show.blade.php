@extends('layouts.app')
@section('page-title')
    {{ __('Subscription') }}
@endsection
@push('script-page')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).on('click', '.have_coupon', function() {
            var element = $(this).parent().parent().parent().parent().parent().parent().find('.coupon_div');
            console.log(element);

            if ($(this).is(":checked")) {
                $(element).removeClass('d-none');
            } else {
                $(element).addClass('d-none');
            }
        });

        $(document).on('click', '.packageCouponApplyBtn', function() {
            var element = $(this);
            var couponCode = element.closest('.row').find('.packageCouponCodeInput').val();
            $.ajax({
                url: '{{ route('coupons.apply') }}',
                datType: 'json',
                data: {
                    package: '{{ \Illuminate\Support\Facades\Crypt::encrypt($subscription->id) }}',
                    coupon: couponCode
                },
                success: function(result) {
                    $('.discoutedPrice').text(result.discoutedPrice);
                    if (result != '') {
                        if (result.status == true) {
                            toastrs('success', result.msg, 'success');
                        } else {
                            toastrs('Error', result.msg, 'error');
                        }
                    } else {
                        toastrs('Error', "{{ __('Please enter coupon code.') }}", 'error');
                    }
                }
            })
        });
    </script>

    <script>
        @if ($settings['STRIPE_PAYMENT'] == 'on' && !empty($settings['STRIPE_KEY']) && !empty($settings['STRIPE_SECRET']))
            var stripe_key = Stripe('{{ $settings['STRIPE_KEY'] }}');
            var stripe_elements = stripe_key.elements();
            var strip_css = {
                base: {
                    fontSize: '14px',
                    color: '#32325d',
                },
            };
            var stripe_card = stripe_elements.create('card', {
            
                style: strip_css
            });
            stripe_card.mount('#card-element');

            var stripe_form = document.getElementById('stripe-payment-form');
            if (stripe_form) {
                stripe_form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    var billingDetails = {
                        line1: document.querySelector('[name="state"]')?.value || '',
                        city: document.querySelector('[name="city"]')?.value || '',
                        postal_code: document.querySelector('[name="zipcode"]')?.value || '',
                        country: document.querySelector('[name="country"]')?.value || ''
                    };

                    stripe_key.createToken(stripe_card).then(function(result) {
                        if (result.error) {
                            $("#stripe_card_errors").html(result.error.message);
                            $.NotificationApp.send("Error", result.error.message, "top-right",
                                "rgba(0,0,0,0.2)", "error");
                        } else {
                            var token = result.token;
                            var stripeForm = document.getElementById('stripe-payment-form');
                            var stripeHiddenData = document.createElement('input');
                            stripeHiddenData.setAttribute('type', 'hidden');
                            stripeHiddenData.setAttribute('name', 'stripeToken');
                            stripeHiddenData.setAttribute('value', token.id);
                            stripeForm.appendChild(stripeHiddenData);
                            stripeForm.submit();
                        }
                    });
                });
            }
        @endif
    </script>

    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>

    <script>
        $(document).ready(function() {
            // Payment method selection
            $('.payment-tile').on('click', function() {
                var target = $(this).data('target');
                $('.payment-tile').removeClass('active');
                $(this).addClass('active');
                $('.payment-form-section').addClass('d-none');
                $(target).removeClass('d-none');
            });

            // Coupon synchronization
            $(document).on('keyup change', '.packageCouponCodeInput', function() {
                var code = $(this).val();
                $('.packageCouponCodeHidden').val(code);
            });

            // Initialize first available payment method
            $('.payment-tile').first().trigger('click');
        });
    </script>

    <script>
        @if (
            $settings['flutterwave_payment'] == 'on' &&
                !empty($settings['flutterwave_public_key']) &&
                !empty($settings['flutterwave_secret_key']))

            $(document).on("click", "#flutterwavePaymentBtn", function() {
                var discoutedPrice = $('.discoutedPrice').text();
                var currency_symbol = '{{ $settings['CURRENCY_SYMBOL'] }}';
                var amount = discoutedPrice.replace(currency_symbol, "");
                var flutterwaveCallbackURL = "{{ url('subscription/flutterwave/') }}";
                var tx_ref = "RX1_" + Math.floor((Math.random() * 1000000000) + 1);
                var customer_email = '{{ \Auth::user()->email }}';
                var customer_name = '{{ \Auth::user()->name }}';
                var flutterwave_public_key = '{{ $settings['flutterwave_public_key'] }}';
                var currency = '{{ $settings['CURRENCY'] }}';

                if (amount) {
                    var flutterwavePayment = getpaidSetup({
                        txref: tx_ref,
                        PBFPubKey: flutterwave_public_key,
                        amount: amount,
                        currency: currency,
                        customer_name: customer_name,
                        customer_email: customer_email,
                        meta: [{
                            consumer_id: "23",
                            consumer_mac: "92a3-912ba-1192a"
                        }],
                        onclose: function() {},
                        callback: function(result) {
                            var txRef = result.tx.txRef;
                            var redirectUrl = flutterwaveCallbackURL + '/' +
                                '{{ \Illuminate\Support\Facades\Crypt::encrypt($subscription->id) }}' +
                                '/' + txRef;
                            if (result.tx.chargeResponseCode == "00" || result.tx.chargeResponseCode ==
                                "0") {
                                window.location.href = redirectUrl;
                            } else {
                                alert('Payment failed');
                            }
                            flutterwavePayment.close();
                        }
                    });
                } else {
                    alert('Please enter a valid amount');
                }
            });
        @endif
    </script>

    {{-- Paystack --}}
    <script src="https://js.paystack.co/v1/inline.js"></script>
    @if (!empty($settings['paystack_payment']) && $settings['paystack_payment'] === 'on')
        <script>
            $(document).ready(function() {
                $(document).on("click", "#subscription_pay_with_paystack", function(e) {
                    e.preventDefault();

                    const $button = $(this);
                    const $paymentForm = $('#paystack-payment-form');
                    const formActionUrl = $paymentForm.attr('action');
                    const formMethod = $paymentForm.attr('method');
                    const formSerializedData = $paymentForm.serialize();

                    const paystackPublicKey = "{{ $settings['paystack_public_key'] }}";
                    const redirectBaseUrl = "{{ url('/subscription/paystack') }}";
                    const encryptedSubscriptionId = "{{ encrypt($subscription->id) }}";

                    $button.prop('disabled', true).text('Processing...');

                    $.ajax({
                        url: formActionUrl,
                        method: formMethod,
                        data: formSerializedData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.flag === 1) {
                                const transactionReference = 'txn_' + Math.floor(Math.random() *
                                    1000000000 + 1);

                                const paystackOptions = {
                                    key: paystackPublicKey,
                                    email: response.email,
                                    amount: response.total_price * 100,
                                    currency: response.currency,
                                    ref: transactionReference,
                                    metadata: {
                                        custom_fields: [{
                                            display_name: "Customer Email",
                                            variable_name: "customer_email",
                                            value: response.email
                                        }]
                                    },
                                    callback: function(paystackResponse) {
                                        window.location.href =
                                            `${redirectBaseUrl}/${paystackResponse.reference}/${encryptedSubscriptionId}?coupon_id=${response.coupon}`;
                                    },
                                    onClose: function() {
                                        alert(
                                            'Payment popup was closed without completing.'
                                        );
                                        $button.prop('disabled', false).text('Pay Now');
                                    }
                                };

                                const paymentHandler = PaystackPop.setup(paystackOptions);
                                paymentHandler.openIframe();
                            } else if (response.flag === 2) {
                                show_toastr('Success', response.msg, 'success');
                                setTimeout(function() {
                                    window.location.href = response.redirect;
                                }, 1000);
                            } else {
                                show_toastr('Error', response.message || response.msg, 'error');
                                $button.prop('disabled', false).text('Pay Now');
                            }
                        },
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr.responseText);
                            show_toastr('Error', 'An unexpected error occurred. Please try again.',
                                'msg');
                            $button.prop('disabled', false).text("{{ __('Pay Now') }}");
                        }
                    });
                });
            });
        </script>
    @endif

    {{-- Razorpay --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @if (!empty($settings['razorpay_payment'] ?? 'off') && $settings['razorpay_payment'] == 'on')
        <script>
            $(document).on("click", "#subscription_pay_with_razorpay", function(e) {
                e.preventDefault();

                const $button = $(this);
                const $paymentForm = $('#razorpay-payment-form');
                const formActionUrl = $paymentForm.attr('action');
                const formMethod = $paymentForm.attr('method');
                const formSerializedData = $paymentForm.serialize();

                $button.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: formActionUrl,
                    method: formMethod,
                    data: formSerializedData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.flag === 1) {
                            var options = {
                                "key": response.razorpay_key,
                                "amount": (response.total_price * 100),
                                "currency": response.currency,
                                "name": "{{ config('app.name') }}",
                                "description": "Subscription Payment",
                                "image": "{{ asset(Storage::url('upload/logo/logo.png')) }}",
                                "handler": function (razorpayResponse){
                                    window.location.href = "{{ url('/subscription/razorpay') }}/" + razorpayResponse.razorpay_payment_id + "?plan_id=" + encodeURIComponent("{{ encrypt($subscription->id) }}") + "&coupon_id=" + response.coupon;
                                },
                                "prefill": {
                                    "name": "{{ \Auth::user()->name }}",
                                    "email": response.email,
                                    "contact": ""
                                },
                                "theme": {
                                    "color": "#00796B"
                                }
                            };
                            var rzp1 = new Razorpay(options);
                            rzp1.open();
                        } else if (response.flag === 2) {
                            show_toastr('Success', response.msg, 'success');
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1000);
                        } else {
                            show_toastr('Error', response.message || response.msg, 'error');
                            $button.prop('disabled', false).text('Pay Now');
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.responseText);
                        show_toastr('Error', 'An unexpected error occurred. Please try again.', 'msg');
                        $button.prop('disabled', false).text("{{ __('Pay Now') }}");
                    }
                });
            });
        </script>
    @endif
@endpush

@push('css-page')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --dd-gold: #D9A441;
        --dd-gold-hover: #F4C861;
        --dd-gold-light: rgba(217, 164, 65, 0.15);
        --dd-bg: #03111F;
        --dd-card-bg: #0B2239;
        --dd-card-subtle: #07192A;
        --dd-border: #29435D;
        --dd-text-title: #FFFFFF;
        --dd-text-muted: #8FA1B5;
        --dd-input-bg: #102B45;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .package-summary-card {
        background: linear-gradient(135deg, #0B2239 0%, #07192A 100%);
        color: #ffffff;
        border: 1px solid var(--dd-border);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.75rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
    }

    .package-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 1rem;
        text-align: center;
    }

    .info-item {
        background: rgba(217, 164, 65, 0.08);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(217, 164, 65, 0.2);
        border-radius: 12px;
        padding: 12px 14px;
    }

    .info-item h6 {
        color: #8FA1B5;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    .info-item p {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 0;
        color: #F4C861;
    }

    .subscription-main-card {
        background: var(--dd-card-bg);
        border: 1px solid var(--dd-border);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
        color: #FFFFFF;
    }

    .payment-tile-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .payment-tile {
        flex: 1;
        min-width: 140px;
        max-width: 180px;
        background: #102B45;
        border: 1.5px solid var(--dd-border);
        border-radius: 12px;
        padding: 1.25rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .payment-tile:hover {
        border-color: var(--dd-gold);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
    }

    .payment-tile.active {
        border-color: var(--dd-gold);
        background: var(--dd-gold-light);
        box-shadow: 0 6px 16px rgba(217, 164, 65, 0.25);
    }

    .payment-tile.active::after {
        content: '\f00c';
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        top: 8px;
        right: 8px;
        background: var(--dd-gold);
        color: #03111F;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        font-size: 10px;
        line-height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-tile i {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        color: var(--dd-gold) !important;
    }

    .payment-tile span {
        font-weight: 600;
        font-size: 0.88rem;
        color: #FFFFFF;
    }

    .payment-form-container {
        background: #07192A;
        border-radius: 14px;
        padding: 1.75rem;
        border: 1px solid var(--dd-border);
        color: #FFFFFF;
    }

    .coupon-box {
        background: #102B45;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px dashed var(--dd-border);
    }

    .btn-pay-now, .btn-primary {
        background-color: var(--dd-gold) !important;
        border-color: var(--dd-gold) !important;
        color: #03111F !important;
        padding: 12px 24px;
        font-weight: 800;
        font-size: 0.95rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-pay-now:hover, .btn-primary:hover {
        background-color: var(--dd-gold-hover) !important;
        border-color: var(--dd-gold-hover) !important;
        box-shadow: 0 4px 14px rgba(217, 164, 65, 0.35) !important;
        color: #03111F !important;
    }

    .info-box-item {
        background: #102B45;
        border: 1px solid var(--dd-border);
        border-radius: 10px;
        padding: 14px 16px;
    }

    .info-box-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: #8FA1B5;
        margin-bottom: 4px;
        display: block;
    }

    .info-box-value {
        font-size: 15px;
        font-weight: 700;
        color: #FFFFFF;
        margin-bottom: 0;
    }

    .dd-dark-input {
        background-color: #102B45 !important;
        border-color: #29435D !important;
        color: #FFFFFF !important;
        border-radius: 8px;
    }

    .dd-dark-input::placeholder {
        color: #8FA1B5 !important;
    }

    .dd-dark-input:focus {
        background-color: #102B45 !important;
        border-color: var(--dd-gold) !important;
        color: #FFFFFF !important;
        box-shadow: 0 0 0 3px var(--dd-gold-light) !important;
    }
</style>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">{{ __('Subscription') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Details') }}</li>
@endsection

@section('content')
    <!-- Package Summary Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="package-summary-card shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h3 class="text-white mb-2 fw-bold">{{ $subscription->title }}</h3>
                        <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background: var(--dd-gold-light); color: var(--dd-gold); border: 1px solid rgba(217, 164, 65, 0.3); font-size: 0.78rem;">{{ __('Active Subscription Selection') }}</span>
                    </div>
                    <div class="col-md-8 mt-3 mt-md-0">
                        <div class="package-info-grid">
                            <div class="info-item">
                                <h6>{{ __('Amount') }}</h6>
                                <p class="discoutedPrice mb-0">{{ dynamicPrice($subscription->package_amount) }}</p>
                                @if(session('geo_location') && session('geo_location')['currency'] != (subscriptionPaymentSettings()['CURRENCY'] ?? 'INR'))
                                    <small class="opacity-75 d-block mt-1" style="font-size: 0.7rem; color: #8FA1B5;">(≈ {{ priceFormat($subscription->package_amount) }})</small>
                                @endif
                            </div>
                            <div class="info-item">
                                <h6>{{ __('Interval') }}</h6>
                                <p>{{ ucfirst($subscription->interval) }}</p>
                            </div>
                            <div class="info-item">
                                <h6>{{ __('User Limit') }}</h6>
                                <p>{{ $subscription->user_limit >= 1000 ? '∞' : $subscription->user_limit }}</p>
                            </div>
                            <div class="info-item">
                                <h6>{{ __('Customer Limit') }}</h6>
                                <p>{{ $subscription->customer_limit >= 10000 ? '∞' : number_format($subscription->customer_limit) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Payment Selection Card -->
    <div class="row">
        <div class="col-12">
            <div class="subscription-main-card p-4">
                <div class="pb-3 mb-4 border-bottom" style="border-color: var(--dd-border) !important;">
                    <h5 class="fw-bold mb-1 text-white"><i class="ti ti-wallet me-2" style="color: var(--dd-gold);"></i>{{ __('Choose Payment Method') }}</h5>
                    <p class="small mb-0" style="color: #8FA1B5;">{{ __('Select your preferred gateway to complete the transaction.') }}</p>
                </div>
                <div>
                    <!-- Method Selector -->
                    <div class="payment-tile-container">
                        @if ($settings['bank_transfer_payment'] == 'on')
                            <div class="payment-tile" data-target="#bank-transfer-form">
                                <i class="ti ti-building-bank"></i>
                                <span>{{ __('Bank Transfer') }}</span>
                            </div>
                        @endif

                        @if ($settings['STRIPE_PAYMENT'] == 'on' && !empty($settings['STRIPE_KEY']) && !empty($settings['STRIPE_SECRET']))
                            <div class="payment-tile" data-target="#stripe-form">
                                <i class="ti ti-credit-card"></i>
                                <span>{{ __('Stripe') }}</span>
                            </div>
                        @endif

                        @if ($settings['paypal_payment'] == 'on' && !empty($settings['paypal_client_id']) && !empty($settings['paypal_secret_key']))
                            <div class="payment-tile" data-target="#paypal-form">
                                <i class="ti ti-brand-paypal"></i>
                                <span>{{ __('Paypal') }}</span>
                            </div>
                        @endif

                        @if (!empty($settings['flutterwave_payment']) && $settings['flutterwave_payment'] == 'on' && !empty($settings['flutterwave_public_key']) && !empty($settings['flutterwave_secret_key']))
                            <div class="payment-tile" data-target="#flutterwave-form">
                                <i class="ti ti-wave-sine"></i>
                                <span>{{ __('Flutterwave') }}</span>
                            </div>
                        @endif

                        @if ($settings['paystack_payment'] == 'on' && !empty($settings['paystack_public_key']) && !empty($settings['paystack_secret_key']))
                            <div class="payment-tile" data-target="#paystack-form">
                                <i class="ti ti-stack"></i>
                                <span>{{ __('Paystack') }}</span>
                            </div>
                        @endif

                        @if (($settings['razorpay_payment'] ?? 'off') == 'on' && !empty($settings['razorpay_key'] ?? '') && !empty($settings['razorpay_secret'] ?? ''))
                            <div class="payment-tile" data-target="#razorpay-form">
                                <i class="ti ti-rocket"></i>
                                <span>{{ __('Razorpay') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Dynamic Form Area -->
                    <div class="payment-form-container">
                        @if ($subscription->couponCheck() > 0)
                            <div class="coupon-box mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="form-check custom-option mb-0">
                                            <input class="form-check-input have_coupon" type="checkbox" value="" id="global_have_coupon">
                                            <label class="form-check-label fw-bold text-white" for="global_have_coupon">
                                                {{ __('Have a Discount Coupon?') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-7 d-none coupon_div mt-2 mt-md-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control packageCouponCodeInput dd-dark-input" placeholder="{{ __('Enter Code') }}">
                                            <button class="btn btn-primary packageCouponApplyBtn" type="button">{{ __('Apply') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Form Sections -->
                        
                        <!-- Bank Transfer -->
                        @if ($settings['bank_transfer_payment'] == 'on')
                            <div id="bank-transfer-form" class="payment-form-section d-none">
                                <form action="{{ route('subscription.bank.transfer', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="coupon" class="packageCouponCodeHidden">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-box-item">
                                                <span class="info-box-label">{{ __('Bank Name') }}</span>
                                                <h6 class="info-box-value">{{ $settings['bank_name'] }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box-item">
                                                <span class="info-box-label">{{ __('Account Holder') }}</span>
                                                <h6 class="info-box-value">{{ $settings['bank_holder_name'] }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box-item">
                                                <span class="info-box-label">{{ __('Account Number') }}</span>
                                                <h6 class="info-box-value">{{ $settings['bank_account_number'] }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box-item">
                                                <span class="info-box-label">{{ __('IFSC Code') }}</span>
                                                <h6 class="info-box-value">{{ $settings['bank_ifsc_code'] }}</h6>
                                            </div>
                                        </div>
                                        @if (!empty($settings['bank_other_details']))
                                            <div class="col-12">
                                                <div class="info-box-item">
                                                    <span class="info-box-label">{{ __('Instructions') }}</span>
                                                    <p class="mb-0 small" style="color: #8FA1B5;">{{ $settings['bank_other_details'] }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12 mt-3">
                                            <label class="form-label fw-bold text-white">{{ __('Payment Receipt (Image/PDF)') }}</label>
                                            <input type="file" name="payment_receipt" class="form-control dd-dark-input" required>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-pay-now w-100 mt-2">{{ __('Submit Bank Transfer') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <!-- Stripe -->
                        @if ($settings['STRIPE_PAYMENT'] == 'on' && !empty($settings['STRIPE_KEY']) && !empty($settings['STRIPE_SECRET']))
                            <div id="stripe-form" class="payment-form-section d-none">
                                <form action="{{ route('subscription.stripe.payment', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}" method="post" id="stripe-payment-form">
                                    @csrf
                                    <input type="hidden" name="coupon" class="packageCouponCodeHidden">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold text-white">{{ __('Card Holder Name') }}</label>
                                            <input type="text" name="name" class="form-control dd-dark-input" placeholder="Full Name" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold text-white">{{ __('Card Details') }}</label>
                                            <div id="card-element" class="form-control dd-dark-input" style="padding: 12px;"></div>
                                            <div id="stripe_card_errors" class="text-danger mt-2 small" role="alert"></div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button type="submit" class="btn btn-primary btn-pay-now w-100">{{ __('Pay Securely with Stripe') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <!-- PayPal -->
                        @if ($settings['paypal_payment'] == 'on' && !empty($settings['paypal_client_id']) && !empty($settings['paypal_secret_key']))
                            <div id="paypal-form" class="payment-form-section d-none">
                                <form action="{{ route('subscription.paypal', \Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="coupon" class="packageCouponCodeHidden">
                                    <div class="text-center py-3">
                                        <i class="ti ti-brand-paypal display-4 mb-3" style="color: var(--dd-gold);"></i>
                                        <h5 class="mb-2 fw-bold text-white">{{ __('PayPal Checkout') }}</h5>
                                        <p class="small px-md-5" style="color: #8FA1B5;">{{ __('You will be redirected to PayPal\'s secure portal to complete your payment.') }}</p>
                                        <button type="submit" class="btn btn-primary btn-pay-now w-100 mt-3">{{ __('Proceed to PayPal') }}</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <!-- Flutterwave -->
                        @if (!empty($settings['flutterwave_payment']) && $settings['flutterwave_payment'] == 'on')
                            <div id="flutterwave-form" class="payment-form-section d-none">
                                <div class="text-center py-3">
                                    <i class="ti ti-wave-sine display-4 mb-3" style="color: var(--dd-gold);"></i>
                                    <h5 class="mb-2 fw-bold text-white">{{ __('Flutterwave Payment') }}</h5>
                                    <p class="small" style="color: #8FA1B5;">{{ __('Safe and fast payment via Flutterwave gateway.') }}</p>
                                    <button type="button" id="flutterwavePaymentBtn" class="btn btn-primary btn-pay-now w-100 mt-3">{{ __('Pay with Flutterwave') }}</button>
                                </div>
                            </div>
                        @endif

                        <!-- Paystack -->
                        @if ($settings['paystack_payment'] == 'on')
                            <div id="paystack-form" class="payment-form-section d-none">
                                <form id="paystack-payment-form" method="POST" action="{{ route('subscription.pay.with.paystack') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ Crypt::encrypt($subscription->id) }}">
                                    <input type="hidden" name="coupon" class="packageCouponCodeHidden">
                                    <div class="text-center py-3">
                                        <i class="ti ti-stack display-4 mb-3" style="color: var(--dd-gold);"></i>
                                        <h5 class="mb-2 fw-bold text-white">{{ __('Paystack Checkout') }}</h5>
                                        <p class="small" style="color: #8FA1B5;">{{ __('Fast and secure payment processing via Paystack.') }}</p>
                                        <button type="button" class="btn btn-primary btn-pay-now w-100 mt-3" id="subscription_pay_with_paystack">{{ __('Pay with Paystack') }}</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <!-- Razorpay -->
                        @if (($settings['razorpay_payment'] ?? 'off') == 'on')
                            <div id="razorpay-form" class="payment-form-section d-none">
                                <form id="razorpay-payment-form" method="POST" action="{{ route('subscription.pay.with.razorpay') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ Crypt::encrypt($subscription->id) }}">
                                    <input type="hidden" name="coupon" class="packageCouponCodeHidden">
                                    <div class="text-center py-3">
                                        <i class="ti ti-rocket display-4 mb-3" style="color: var(--dd-gold);"></i>
                                        <h5 class="mb-2 fw-bold text-white">{{ __('Razorpay Secure') }}</h5>
                                        <p class="small" style="color: #8FA1B5;">{{ __('India\'s most popular and secure payment gateway.') }}</p>
                                        <button type="button" class="btn btn-primary btn-pay-now w-100 mt-3" id="subscription_pay_with_razorpay">{{ __('Pay with Razorpay') }}</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
