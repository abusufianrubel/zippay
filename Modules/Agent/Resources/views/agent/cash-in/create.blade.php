@extends('agent::agent.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="cashinCreate">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('Cash In') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Step: 1 of 3') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ __('Create Cash In') }}</p>
    <div class="text-center">{!! svgIcons('stepper_create') !!}</div>

    <p class="mb-0 text-center f-14 gilroy-medium text-gray dark-p mt-20">
        {{ __('You can cash in to user wallet from your wallet balance') }}
    </p>

    @include('user.common.alert')
    <form method="post" action="{{ route('agent.cashin.confirm') }}" id="cashinCreateForm">
        @csrf

        <input type="hidden" name="percentage_fee" id="percentage_fee">
        <input type="hidden" name="fixed_fee" id="fixed_fee">
        <input type="hidden" name="total_fee" id="total_fees">

        <div class="mt-28 label-top">
            <label class="gilroy-medium text-gray-100 mb-2 f-15" for="receiver">{{ __('Recipient') }}</label>
            <input type="text" class="form-control input-form-control apply-bg focus-bgcolor" 
            name="user" id="receiver" value="" 
            placeholder="{{ __('Please enter valid :x', ['x' => __('email (ex: user@gmail.com)')])}}" 
            onkeyup="" required="" 
            data-value-missing="{{__('This field is required.')}}">
            <span class="receiverError custom-error"></span>
        </div>

        <!-- Currency -->
        <div class="mt-28 param-ref">
            <label class="gilroy-medium text-gray-100 mb-2 f-15" for="currency_id">{{ __('Currency') }}</label>
            <div class="avoid-blink">
                <select class="select2" data-minimum-results-for-search="Infinity" name="currency_id" id="currency_id">
                    @foreach ($wallets as $wallet )
                        <option value="{{ $wallet['currency_id'] }}" data-type="{{ $wallet['currency_type'] }}">{{ $wallet['currency_code'] }}</option>
                    @endforeach
                </select>
            </div>
            @if (!empty($wallets))
                <p class="mb-0 text-gray-100 dark-B87 gilroy-regular f-12 mt-2">{{ __('Fee') }} (<span class="pFees">0%</span>+<span class="fFees"> 0</span>) {{ __('Total Fee') }}: <span class="total_fees">0.00</span></p>
            @endif
        </div>

        <!-- Amount -->
        <div class="mt-20 label-top">
            <label class="gilroy-medium text-gray-100 mb-2 f-15" for="amount">{{ __('Amount') }}</label>
            <input type="text" class="form-control input-form-control apply-bg l-s2" name="amount" id="amount" placeholder="{{ __('Enter amount') }}" onkeypress="return isNumberOrDecimalPointKey(this, event);" oninput="restrictNumberToPrefdecimalOnInput(this)" value="{{ session('paymentData')['amount'] ?? old('amount') }}" required data-value-missing="{{ __('This field is required.') }}">
            <span class="amountLimit custom-error"></span>
        </div>

        @if (empty($wallets))
            <div class="row">
                <div class="col-12">
                    <div class="mt-20 param-ref" id="paymentMethodEmpty">
                        <p class="gilroy-medium text-warning mb-2 f-15">
                            {{ __('Fees Limits are inactive for Cashin') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif 

        <!-- Submit -->
        @if(!empty($wallets))
        <div class="d-grid">
            <button type="submit" class="btn btn-lg btn-primary mt-4" id="cashinCreateSubmitBtn">
                <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none">
                    <span class="visually-hidden"></span>
                </div>
                <span class="px-1" id="cashinCreateSubmitBtnText">{{ __('Proceed') }}</span>
                <span id="rightAngleSvgIcon">{!! svgIcons('right_angle') !!}</span>
            </button>
        </div>
        @endif
    </form>
</div>
@endsection

@push('js')
    @include('common.restrict_number_to_pref_decimal')
    @include('common.restrict_character_decimal_point')

    <script src="{{ asset('public/dist/plugins/html5-validation/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/debounce/jquery.ba-throttle-debounce.min.js') }}"></script>

    <script type="text/javascript">
        'use strict';
        var token = $('[name="_token"]').val();
        var transactionTypeId = "{{ Cashin }}";
        var submitBtnText = "{{ __('Processing...') }}";
        var cashinamountLimitUrl = "{{ route('agent.cashin.manage-fees') }}";
        var cashinUserCheckUrl = "{{ route('agent.cashin.check_user') }}";
        var userNotFoundText = "{{ __('User Not Found') }}";
        var type = "fiat";
    </script>

    <script src="{{ asset('Modules/Agent/Resources/assets/js/agent/agent.min.js') }}"></script>
@endpush
