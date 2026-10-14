@extends('agent::agent.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="cashoutConfirm">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('Cash Out') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Step: 2 of 3') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ __('Confirm Your Cashout') }}</p>
    <div class="text-center">{!! svgIcons('stepper_confirm') !!}</div>
    <p class="mb-0 text-center f-14 gilroy-medium text-gray dark-p mt-20">
        {{ __('Check your cashout information before confirmation.') }}
    </p>
    <form method="post"  action="{{ route('agent.cashout.success') }}" 
    id="cashoutConfirmForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="currency_id" id="method" value="{{ $transInfo['currencyId'] }}">
        <input type="hidden" name="amount" id="amount" value="{{ $transInfo['amount'] }}" >
        <input type="hidden" name="user" id="user" value="{{ $user->email }}" >
        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}" >
        <input type="hidden" name="agent_id" id="agent_id" value="{{ auth('agent')->user()->id }}" >

        <!-- Confirm Details -->
        <div class="mt-32 param-ref text-center">
            <p class="mb-0 gilroy-medium text-primary dark-A0 f-16 sm-font-14 recipent-top-margin">
                {{ __('Recipient') }}
            </p>
            <p class="mb-0 text-center f-20 gilroy-medium text-dark dark-5B mt-10 recipent-top-margin">
                {{ getColumnValue($user) ?? '-'}}
            </p>

            <p class="mb-0 gilroy-medium text-gray-100 sm-font-14 mt-10">{{ __('Through') }} {{ __('Cash') }}</p>

            <div class="mt-40 transaction-box">
                <!-- Amount -->
                <div class="d-flex justify-content-between border-b-EF pb-13">
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">{{ __('Cashout')}} {{ __('Amount') }}</p>
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">
                        {{ moneyFormat($transInfo['currencyCode'], $transInfo['formattedAmount']) }}
                    </p>
                </div>

                <!-- Fee -->
                <div class="d-flex justify-content-between border-b-EF pb-13 mt-3">
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">
                        {{ __('Transaction Fee') }}
                    </p> 
                    
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">
                        {{ moneyFormat($transInfo['currencyCode'], $transInfo['formattedTotalFees']) }}
                        </p>
                </div>

                <!-- Commission -->
                <div class="d-flex justify-content-between border-b-EF pb-13 mt-3">
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">{{ __('Agent Commission') }}</p>
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">
                        {{ moneyFormat($transInfo['currencyCode'], $transInfo['agentCommissionHtml']) }}
                    </p>
                </div>

                <!-- User -->
                <div class="d-flex justify-content-between mt-3 total">
                    <p class="mb-0 f-16 gilroy-medium text-dark">{{ __('Deduct from User') }}</p>
                    <p class="mb-0 f-16 gilroy-medium text-dark">
                        {{ moneyFormat($transInfo['currencyCode'], 
                        ($transInfo['formattedAmount'] + $transInfo['formattedTotalFees'])) }}
                    </p>
                </div>

                <!-- Total -->
                <div class="d-flex justify-content-between mt-3 total">
                    <p class="mb-0 f-16 gilroy-medium text-dark">{{ __('Added on Agent') }}</p>
                    <p class="mb-0 f-16 gilroy-medium text-dark">
                        {{ moneyFormat($transInfo['currencyCode'], 
                        ($transInfo['formattedAmount'] + $transInfo['agentCommissionHtml'])) }}
                    </p>
                </div>
            </div>
        </div>

          <!-- Timer -->
        <div class="d-flex justify-content-between mt-32">
            <span class="f-16 gilroy-medium text-gray-100">
                {{ __('Time Remaining')}} : </span><span class="f-16 gilroy-medium text-danger" id="timer"></span>
        </div>

        <!-- Progressbar -->
        <div class="custom-progress mt-15" id="demo1">
            <div class="progress mx-auto w-100">
                <div class="progress-bar bg-warning" 
                role="progressbar" id="progressBar" style="width: 100%" 
                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div class="mt-28 label-top">
            <label class="gilroy-medium text-gray-100 mb-2 f-15" for="otp_code">
                {{ __('OTP code') }}: 
            </label>


            <input type="text" class="form-control input-form-control apply-bg focus-bgcolor" 
            name="otp_code" id="otp_code" placeholder="{{ __('Enter the 6-digit OTP') }}"  
            data-value-missing="{{ __('This field is required.')}}" required>
            <span class="custom-error" id="errorMessage"></span>
            <span class="successMessage" id="successMessage"></span>
        </div>

        <!-- Confirm Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-lg btn-primary mt-4" id="cashoutConfirmBtn">
                <div class="spinner spinner-confirm spinner-border text-white spinner-border-sm mx-2 d-none">
                    <span class="visually-hidden"></span>
                </div>
                <span class="px-1" id="cashoutConfirmBtnText">{{ __('Confirm') }}</span>
                <span id="rightAngleSvgIcon">{!! svgIcons('right_angle') !!}</span>
            </button>
        </div>

        <!-- Back Button -->
        <div class="d-flex justify-content-center align-items-center mt-4 back-direction">
            <a href="{{ route('agent.cashout.create') }}" 
            class="text-gray gilroy-medium d-inline-flex align-items-center position-relative back-btn" 
            id="cashoutConfirmBackBtn">
                {!! svgIcons('left_angle') !!}
                <span class="ms-1 back-btn ns cashoutConfirmBackBtnText">{{ __('Back') }}</span>
            </a>
        </div>
    </form>
</div>
@endsection

@push('js')
    <script src="{{ asset('dist/plugins/html5-validation/validation.min.js') }}"></script>

    <script type="text/javascript">
        'use strict';
        var csrfToken = $('[name="_token"]').val();
        var cashoutAmountLimit = "{{ route('agent.cashout.otp.resend') }}";
        var userId = $('#user_id').val().trim();
        var confirmBtnText = "{{ __('Confirming...') }}";
        var expireText = "{{ __('Expired') }}";
    </script>

    <script src="{{ asset('Modules/Agent/Resources/assets/js/agent/agent.min.js') }}"></script>
    <script src="{{ asset('Modules/Agent/Resources/assets/js/agent/countdown.min.js') }}"></script>
@endpush
