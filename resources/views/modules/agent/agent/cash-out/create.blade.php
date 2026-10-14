@extends('agent::agent.layouts.app')

@section('content')
    <div class="bg-white pxy-62 shadow" id="cashoutCreate">
        <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('CASHOUT MONEY') }}</p>
        <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Step: 1 of 3') }}</p>
        <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ __('Create Cashout') }}</p>
        
        <div class="text-center">{!! svgIcons('stepper_create') !!}</div>

        <p class="mb-0 text-center f-14 gilroy-medium text-gray dark-p mt-20">
            {{ __('You can cashout from the user wallet, which will be added to your wallet.') }}
        </p>
        
        @include('user.common.alert')


        <form method="post" action="{{ route('agent.cashout.confirm') }}" id="cashoutCreateForm">
            @csrf
            <input type="hidden" name="payment_method_id" id="payment_method_id" value="{{ Cash }}">
            <input type="hidden" name="percentage_fee" id="percentage_fee">
            <input type="hidden" name="fixed_fee" id="fixed_fee">
            <input type="hidden" name="total_fee" id="total_fees">

            <div class="mt-28 label-top">
                <label class="gilroy-medium text-gray-100 mb-2 f-15" for="user">{{ __('Recipient') }}</label>
                <input type="text" class="form-control input-form-control apply-bg focus-bgcolor" 
                name="user" id="user" 
                placeholder="{{ __('Enter your email') }}"  
                data-value-missing="{{ __('This field is required.') }}" required>
                <span class="receiverError custom-error"></span>
            </div>

            <!-- Currency -->
            <div class="mt-20 param-ref">
                <label class="gilroy-medium text-gray-100 mb-2 f-15" for="currency_id">{{ __('Currency') }}</label>
                <div class="avoid-blink" id="currencyList">
                    <select class="select2" data-minimum-results-for-search="Infinity" name="currency_id" id="currency_id"></select>
                </div>
                <span class="currencyError custom-error"></span>

                @error('currency_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <p class="mb-0 text-gray-100 dark-B87 gilroy-regular f-12 mt-2">{{ __('Fee') }} (<span class="pFees">0%</span>+<span class="fFees"> 0</span>) {{ __('Total Fee') }}: <span class="total_fees">0.00</span></p>

            <!-- Amount -->
            <div class="label-top mt-20">
                <label class="gilroy-medium text-gray-100 mb-2 f-15" for="amount">{{ __('Amount') }}</label>
                <input class="form-control input-form-control apply-bg l-s2" name="amount" id="amount" onkeypress="return isNumberOrDecimalPointKey(this, event);" placeholder="0.00" type="text" oninput="restrictNumberToPrefdecimalOnInput(this)" required data-value-missing="{{ __('This field is required') }}" value="{{ session('cashoutData')['amount'] ?? old('amount') }}">
            </div>
            <span class="amountLimit text-danger" id="amountLimit"></span>
            @error('amount')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="d-grid">
                <button type="submit" class="btn btn-lg btn-primary mt-4" id="cashoutCreateSubmitBtn">
                    <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                    <span class="px-1" id="cashoutCreateSubmitBtnText">{{ __('Proceed') }}</span>
                    <span id="rightAngleSvgIcon">{!! svgIcons('right_angle') !!}</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    @include('common.restrict_number_to_pref_decimal')
    @include('common.restrict_character_decimal_point')

    <script src="{{ asset('dist/plugins/html5-validation/validation.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
    <script src="{{ asset('dist/libraries/sweetalert/sweetalert-unpkg.min.js') }}"></script>

    <script type="text/javascript">
        'use strict';
        var csrfToken = $('[name="_token"]').val();
        var amount = $('#amount').val();
        var currencyId = $('#currency_id').val();
        var paymentMethodId = $('#payment_method').val();
        var transactionTypeId = "{{ Cashout }}";
        var cashoutAmountLimit = "{{ route('agent.cashout.manage-fees') }}";
        var pleaseWaitText = "{{ __('Please Wait') }}";
        var loadingText = "{{ __('Loading...') }}";
        var notEnoughBalanceText = "{{ __('Not have enough balance!') }}";
        var userNotFoundText = "{{ __('User Not Found') }}";
        var submitBtnText = "{{ __('Submitting...') }}";
        var currencyListUrl = "{{ route('agent.cashout.currency.list') }}";
        var feeLimitText = "{{ __('Fees limits are inactive for Cashout') }}";
        var sessionCurrencyId = "{{ !empty(session('cashoutData')) ? session('cashoutData')['currency_id'] : '' }}";
    </script>
    
    <script src="{{ asset('Modules/Agent/Resources/assets/js/agent/agent.min.js') }}"></script>
@endpush
