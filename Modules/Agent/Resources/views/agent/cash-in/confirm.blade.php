@extends('agent::agent.layouts.app')

@section('content')
<div class="bg-white pxy-62 shadow" id="cashinConfirm">
    <p class="mb-0 f-26 gilroy-Semibold text-uppercase text-center">{{ __('Cash In') }}</p>
    <p class="mb-0 text-center f-13 gilroy-medium text-gray mt-4 dark-A0">{{ __('Step: 2 of 3') }}</p>
    <p class="mb-0 text-center f-18 gilroy-medium text-dark dark-5B mt-2">{{ __('Confirm Your Cashin') }}</p>
    <div class="text-center">{!! svgIcons('stepper_confirm') !!}</div>
    <p class="mb-0 text-center f-14 gilroy-medium text-gray dark-p mt-20">
        {{ __('Check your cashin information before confirmation.') }}
    </p>

    <form method="post"  action="{{ route('agent.cashin.success') }}" 
    id="cashinConfirmForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="currency_id" id="method" value="{{ $transInfo['currencyId'] }}">
        <input type="hidden" name="amount" id="amount" value="{{ $transInfo['amount'] }}" >
        <input type="hidden" name="user" id="user" value="{{ $user->email }}" >

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
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">{{ __('Cashin') }} {{ __('Amount') }}</p>
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">
                        {{  moneyFormat($transInfo['currencyCode'], $transInfo['formattedAmount']) }}
                    </p>
                </div>


                <!-- Fee -->
                <div class="d-flex justify-content-between border-b-EF pb-13 mt-3">
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">{{ __('Transaction Fee') }}</p>
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">
                        {{ moneyFormat($transInfo['currencyCode'], $transInfo['formattedTotalFees']) }}
                    </p>
                </div>

                 <!-- Commission -->
                 <div class="d-flex justify-content-between border-b-EF pb-13 mt-3">
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">{{ __('Agent Commission') }}</p>
                    <p class="mb-0 f-16 gilroy-regular text-gray-100">
                        {{ moneyFormat($transInfo['currencyCode'], $transInfo['formattedAgentFees']) }}
                    </p>
                </div>

                <!-- User -->
                <div class="d-flex justify-content-between mt-3 total">
                    <p class="mb-0 f-16 gilroy-medium text-dark">{{ __('Added on User') }}</p>
                    <p class="mb-0 f-16 gilroy-medium text-dark">
                        {{ moneyFormat($transInfo['currencyCode'], $transInfo['formattedAmount']) }}
                    </p>
                </div>

                <!-- Total -->
                <div class="d-flex justify-content-between mt-3 total">
                    <p class="mb-0 f-16 gilroy-medium text-dark">{{ __('Deduct from Agent') }}</p>
                    <p class="mb-0 f-16 gilroy-medium text-dark">
                        {{ moneyFormat($transInfo['currencyCode'], 
                        formatNumber($transInfo['totalAmount'] - $transInfo['agent_commission'], $transInfo['currencyId'])) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Confirm Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-lg btn-primary mt-4" id="cashinConfirmBtn">
                <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none">
                    <span class="visually-hidden"></span>
                </div>
                <span class="px-1" id="cashinConfirmBtnText">{{ __('Confirm') }}</span>
                <span id="rightAngleSvgIcon">{!! svgIcons('right_angle') !!}</span>
            </button>
        </div>

        <!-- Back Button -->
        <div class="d-flex justify-content-center align-items-center mt-4 back-direction">
            <a href="{{ route('agent.cashin.create') }}" 
            class="text-gray gilroy-medium d-inline-flex align-items-center position-relative back-btn" 
            id="cashinConfirmBackBtn">
                {!! svgIcons('left_angle') !!}
                <span class="ms-1 back-btn ns cashinConfirmBackBtnText">{{ __('Back') }}</span>
            </a>
        </div>
    </form>
</div>
@endsection

@push('js')
<script type="text/javascript">
    'use strict';
    let confirmBtnText = "{{ __('Confirming...') }}";
    let pretext = "{{ __('Confirm & Cashin') }}";
</script>
<script src="{{ asset('Modules/Agent/Resources/assets/js/agent/agent.min.js') }}"></script>
@endpush
