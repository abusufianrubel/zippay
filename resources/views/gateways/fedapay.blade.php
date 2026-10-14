@extends('gateways.layouts.master')

@section('content')

<div class="col-md-12 text-center">
    <form method="POST" action="{{ route('gateway.confirm_payment') }}" id="payment-form">
        @csrf
        <input type="hidden" name="currency_id" id="currency_id" value="{{ $currency_id }}">
        <input type="hidden" name="amount" id="amount" value="{{ $total }}">
        <input type="hidden" name="uuid" id="uuid" value="{{ $uuid }}">
        <input type="hidden" name="payment_method" id="payment_method" value="{{ $payment_method }}">
        <input type="hidden" name="payment_method_id" id="payment_method_id" value="{{ $payment_method }}">
        <input type="hidden" name="verify_url" id="verify_url" value="{{ url('gateway/payment-verify/fedapay') }}">
        <input type="hidden" name="transaction_type" id="transaction_type" value="{{ $transaction_type }}">
        <input type="hidden" name="payment_type" id="payment_type" value="{{ $payment_type }}">
        <input type="hidden" name="params" id="params" value="{{ $params }}">
        <input type="hidden" name="gateway" id="gateway" value="fedapay">

        <div class="col-md-12">
            <p class="text-danger" id="fedapayError"></p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-grid mt-3p">
                    <button type="submit" class="btn btn-lg btn-primary" id="fedapay-button-submit">
                        <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none">
                            <span class="visually-hidden"></span>
                        </div>
                        <span id="fedapaySubmitBtnText" class="px-1">{{ __('Pay with :x', ['x' => ucfirst($gateway)]) }}</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
<script src="{{ asset('public/dist/plugins/jquery-validation/dist/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/dist/plugins/debounce/jquery.ba-throttle-debounce.min.js') }}" type="text/javascript"></script>

<!-- Official FedaPay Checkout JS -->
<script src="https://checkout.fedapay.com/js/checkout.js"></script>

<script type="text/javascript">
    'use strict';
    
    $(document).ready(function() {
        var submitting = "{{ __('Submitting...') }}";
        var submitBtn = $('#fedapay-button-submit');
        var spinner = submitBtn.find('.spinner');
        var btnText = $('#fedapaySubmitBtnText');
        var errorDisplay = $('#fedapayError');

        // Force safe values directly in the JS to bypass any payload crashes
        let widget = FedaPay.init({
            public_key: 'pk_sandbox_DebMm2-ipJPeTEXbJ2eS5FAX', // <--- PASTE KEY HERE DIRECTLY
            environment: 'sandbox',
            transaction: {
                amount: 2000, // Hardcoded safe integer
                description: 'Test Payment'
            },
            currency: {
                iso: 'XOF' // Force XOF to prevent currency mismatch crashes
            },
            onComplete: function(resp) {
                if (resp.reason === FedaPay.TRANSACTION_COMPLETED) {
                    let verifyUrl = $('#verify_url').val() + '?id=' + resp.transaction.id + '&params=' + $('#params').val();
                    window.location.href = verifyUrl;
                } else {
                    spinner.addClass('d-none');
                    submitBtn.prop('disabled', false);
                    btnText.text("Pay with Fedapay");
                    errorDisplay.text("Payment was cancelled or failed. Please try again.");
                }
            }
        });

        // Intercept form submission to launch the FedaPay widget
        $('#payment-form').on('submit', function(e) {
            e.preventDefault();
            errorDisplay.text('');
            
            // UI Loading state
            submitBtn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text(submitting);

            // Open the FedaPay modal
            widget.open();
        });
    });
</script>
@endsection