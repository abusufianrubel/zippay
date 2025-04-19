{{-- @extends('user.layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/intl-tel-input/css/intlTelInput.min.css') }}">
@endpush

@section('content')
<div class="text-center">
    <p class="mb-0 gilroy-Semibold f-26 text-dark theme-tran r-f-20 text-uppercase">{{ __('Your Profile') }}</p>
    <p class="mb-0 gilroy-medium text-gray-100 f-16 r-f-12 profile-header mt-2 tran-title">{{ __('You have full control to manage your own account setting') }}</p>
</div>
@include('user.common.alert')
<div class="row" id="profileUpdate">
    <div class="col-xl-12 col-xxl-6">
        <!-- Profile Image Div -->
        <div class="avatar-left-div bg-white mt-32">
            <div class="d-flex justify-content-between">
                <div class="left-avatar-desc">
                    <p class="mb-0 f-20 leading-25 gilroy-Semibold text-dark">{{ getColumnValue($user) }}</p>
                    <p class="mb-0 f-14 leading-22 gilroy-medium text-gray-100 mt-8">{{ __('Please set your profile image.') }}</p>
                    <p class="mb-0 f-12 leading-18 gilroy-medium fst-italic text-gray mt-3p">{{ __('Supported format: jpeg, png, bmp, gif, or svg') }}</p>
                    <div class="d-flex mt-26 align-items-center justify-content-between">
                        <div class="camera">
                            <input id="upload" type="file">
                            <input type="hidden" id="file_name"/>
                            
                            <a class="bg-primary green-btn" href="javascript:changeProfile()" id="changeProfile">
                                {!! svgIcons('camera_icon') !!}
                            <span class="f-14 leading-20 text-white mx-2 gilroy-medium">{{ __('Change Photo') }}</span>
                            </a>
                            <span id="file-error"></span>
                        </div>
                    </div>
                </div>
                <div class="right-avatar-img">
                    <img src="{{ image(auth()->user()->picture, 'profile') }}" alt="{{ __('Profile') }}" id="profileImage">
                </div>
            </div>
        </div>
        <!-- Default Wallet Div -->
        <div class="default-wallet-div d-flex justify-content-between bg-white mt-24">
            <div class="wallet-text d-flex">
                  
                <p class="wallet-text-hover mb-0 text-dark f-20 leading-25 gilroy-Semibold">{{ __('Default Wallet') }}</p>

                <div class="cursor-pointer wallet-svg d-flex align-items-center">
                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        {!! svgIcons('edit_icon_lg') !!}
                    </a>
                </div>

                <div class="modal fade modal-overly" id="exampleModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg res-dialog">
                        <div class="modal-content">
                            <div class="modal-content">
                                <div class="modal-header w-modal-header">
                                    <p class="modal-title gilroy-Semibold text-dark">{{ __('Set Default Wallet') }}</p>
                                    <button type="button" class="cursor-pointer close-btn" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="close-div position-absolute modal-close-btn rtl-wrap-four text-gray-100 d-flex align-items-center justify-content-center">
                                            {!! svgIcons('cross_icon') !!}
                                        </span>
                                    </button>
                                </div>
                                <div class="modal-body modal-body-pxy">
                                    <form method="post" action="{{ route('user.profile.default_currency') }}" id="defaultCurrencyForm">
                                        @csrf
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="settingId"></div>
                                                <div class="col-md-12">
                                                    <div class="param-ref param-ref-withdraw  money-ref r-mt-11">
                                                        <label class="gilroy-medium text-gray-100 mb-7 f-14 leading-17 r-mt-0">{{ __('Select Wallet') }}
                                                        </label>
                                                        <select class="select2 withdraw-type"
                                                            data-minimum-results-for-search="Infinity" name="default_wallet" id="default_wallet">
                                                            @foreach($wallets as $wallet)
                                                                <option value="{{ $wallet->id }}" {{ $wallet->is_default == 'Yes' ? 'Selected' : ''}}>{{ $wallet->currency?->code }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-20">
                                            <div class="col-md-12 pd-bottom pb-2">
                                                <button type="submit"
                                                    class="btn bg-primary add-option-btn w-100 setting-btn f-16 leading-20 gilroy-medium"
                                                    id="defaultCurrencySubmitBtn">
                                                    <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none" role="status">
                                                        <span class="visually-hidden"></span>
                                                    </div>
                                                    <span id="defaultCurrencySubmitBtnText">{{ __('Save Changes') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="mb-0 f-20 leading-25 gilroy-Semibold text-uppercase text-primary">{{ $defaultWallet->currency?->code ?? 'N/A'}}</p>
        </div>
    </div>
   
    <div class="col-xl-12 col-xxl-6">
        <div class="bg-white profile-qr-code mt-32">
            <!-- Qr Code Div -->
            <div class="d-flex flex-wrap justify-content-between gap-26">
                <div class="left-qr-desc">
                    <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
                    <div class="peofile-qr-text d-flex">
                        {!! svgIcons('scanner_icon') !!}
                        <div class="peofile-qr-body-text ml-12">
                            <p class="mb-0 f-16 leading-20 gilroy-medium text-dark mt-3p">{{ __('Profile QR Code') }}</p>
                            <p class="mt-8 mb-0 f-13 leading-20 gilroy-medium text-gray-100 w-258"> {{ __('Use the QR code to easily handle your transactions.') }}</p>
                        </div>
                    </div>
                    <div class="d-flex print-update-code mt-20">
                        <a href="javascript:void(0)" class="print-code bg-primary text-white green-btn d-flex gap-2 align-items-center" id="printQrCodeBtn">
                            {!! svgIcons('printer_sm') !!}
                            <span class="print-code-text f-13 leading-20">{{ __('Print Code') }}</span>
                        </a>
                        <a href="javascript:void(0)" class="ml-12 update-code text-gray-100 d-flex justify-content-center align-items-center" id="updateQrCodeBtn">
                            <span class="print-code-text f-13 leading-20" id="updateQrCodeBtnText">{{ __('Update Code') }}</span>
                        </a>
                    </div>
                </div>
                <div class="right-qr-code">
                    <div class="profile-qr-img" id="userProfileQrCode">
                    <img class="qrCodeImage" src="{{ image($qrCode?->qr_image, 'user_qrcode') }}" alt="{{ __('QrCode') }}">
                    </div>
                </div>
            </div>
            <!-- Password Div -->
            <div class="profile-qr-bootom d-flex justify-content-between align-items-center mt-26">
                <div class="d-flex align-items-center">
                    {!! svgIcons('lock') !!}
                    <p class="ml-12 mb-0 f-16 leading-20 gilroy-medium text-dark">{{ __('Change Password') }}</p>
                </div>
                <div class="d-flex align-items-center">
                    <div class="mb-0 f-16 leading-20 gilroy-medium d-flex align-items-center text-gray-100 password-text pass-height">*************</div>
                    <div class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal-2">
                        {!! svgIcons('edit_icon_background') !!}
                    </div>
                    <div class="modal fade modal-overly" id="exampleModal-2" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg res-dialog">
                            <div class="modal-content">
                                <div class="modal-header w-modal-header">
                                    <p class="modal-title gilroy-Semibold text-dark">{{ __('Change Password') }}</p>
                                    <button type="button" class="cursor-pointer close-btn" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="close-div position-absolute modal-close-btn rtl-wrap-four text-gray-100 d-flex align-items-center justify-content-center">
                                            {!! svgIcons('cross_icon') !!}
                                        </span>
                                    </button>
                                </div>
                                <div class="modal-body modal-body-pxy">
                                    <form method="post" action="{{ route('user.profile.password.update') }}" id="profileResetPasswordForm">
                                        @csrf
                                        <div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="label-top mt-withdraw">
                                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 r-mt-amount r-mt-6">{{ __('Old Password') }}</label>
                                                        <input type="password" class="form-control input-form-control input-form-control-withdraw apply-bg" name="old_password" id="old_password" placeholder="{{ __('Old Password') }}" required data-value-missing="{{ __('This field is required.') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="label-top mt-withdraw position-r">
                                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6">{{ __('New Password') }}</label>
                                                        <div id="show_hide_password">
                                                            <input type="password" class="form-control input-form-control input-form-control-withdraw apply-bg"name="password" id="password" placeholder="{{ __('New Password') }}" required data-value-missing="{{ __('This field is required.') }}">
                                                        </div>

                                                        <span class="eye-icon-hide d-none cursor-pointer" id="eye-icon-show">
                                                            {!! svgIcons('eye_open_icon') !!}
                                                        </span>
                                                        
                                                        <span class="eye-icon cursor-pointer" id="eye-icon-hide">
                                                            {!! svgIcons('eye_cross_icon') !!}
                                                        </span>

                                                        <p class="mb-0 text-gray-100 dark-B87 gilroy-regular f-12 mt-2"><em>*{{ __('Password should contain minimum 6 characters') }}</em></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="label-top mt-withdraw">
                                                        <label
                                                            class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6"
                                                        > {{ __('Confirm Password') }}</label>
                                                        <input type="password" class="form-control input-form-control input-form-control-withdraw apply-bg" name="password_confirmation" id="password_confirmation" placeholder="{{ __('Confirm Password') }}" required data-value-missing="{{ __('This field is required.') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-20">
                                            <div class="col-md-12 pd-bottom pb-2">
                                                <button type="submit"
                                                    class="btn bg-primary add-option-btn w-100 setting-btn f-16 leading-20 gilroy-medium"
                                                    id="profileResetPasswordSubmitBtn">
                                                    <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none" role="status">
                                                        <span class="visually-hidden"></span>
                                                    </div>
                                                    <span id="profileResetPasswordSubmitBtnText">{{ __('Save Changes') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Phone Div -->
            <div class="profile-qr-bootom d-flex justify-content-between align-items-center mt-26">
                <div class="d-flex align-items-center">
                    {!! svgIcons('phone') !!}
                    <p class="ml-12 mb-0 f-16 leading-20 gilroy-medium text-dark">{{ __('Phone') }}</p>
                </div>
                <div class="d-flex align-items-center">
                    <div class="mb-0 f-16 leading-20 gilroy-medium d-flex align-items-center text-gray-100 phone-text pass-height">{{ $user->formattedPhone ?? 'N/A' }}</div>
                    <div class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal-4">
                        {!! svgIcons('edit_icon_background') !!}
                    </div>
                    <div class="modal fade modal-overly" id="exampleModal-4" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg res-dialog">
                            <div class="modal-content">
                                <div class="modal-header w-modal-header">
                                    <p class="modal-title gilroy-Semibold text-dark ">{{ $user->formattedPhone ? __('Phone Update') : __('Add Phone') }}</p>
                                    <button type="button" class="cursor-pointer close-btn" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="close-div position-absolute modal-close-btn rtl-wrap-four text-gray-100 d-flex align-items-center justify-content-center">
                                            {!! svgIcons('cross_icon') !!}
                                        </span>
                                    </button>
                                </div>
                                <div class="modal-body modal-body-pxy">
                                    <form method="post" action="{{ url('profile/complete-phone-verification')}}"
                                    id="profileResetPasswordForm">
                                        @csrf
                                        <input type="hidden" value="{{ $is_sms_env_enabled }}" 
                                        name="is_sms_env_enabled" id="is_sms_env_enabled" />
                                        <input type="hidden" value="{{ $checkPhoneVerification }}" 
                                        name="checkPhoneVerification" id="checkPhoneVerification" />
                                        <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id" />

                                        <input type="hidden" name="hasVerificationCode" id="hasVerificationCode" />
                                        <input type="hidden" name="defaultCountry" 
                                        id="defaultCountry" class="form-control">

                                        <input type="hidden" name="carrierCode" id="carrierCode" class="form-control">

                                        <input type="hidden" name="countryName" 
                                        id="countryName" class="form-control">                           
                                        
                                        <div>
                                            <!-- Phone -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="label-top mt-withdraw">
                                                        <label id="subheader_text"  
                                                        class="gilroy-medium text-gray-100 
                                                        mb-2 f-14 leading-17 r-mt-amount r-mt-6" >
                                                            {{ __('Phone') }}
                                                        </label>
                                                        <div class="phone_group">
                                                            <input type="tel" class="form-control apply-bg"
                                                                id="phone" name="phone">
                                                            <span id="phone-error"></span>
                                                            <span id="tel-error"></span>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <label id="verification-message" class="gilroy-medium text-gray-100 mb-2 f-14 
                                            leading-17 mt-20 r-mt-amount r-mt-6 success d-none">
                                                {{ __('To make sure this number is yours, we will send you a verification code.')}}
                                            </label>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="label-top mt-withdraw 
                                                    phone_verification_section d-none">
                                                        <label
                                                            class="gilroy-medium text-gray-100 mb-2 f-14 
                                                            leading-17 mt-20 r-mt-amount r-mt-6"
                                                        > 
                                                        {{ __('Verification Code') }}
                                                        </label>
                                                        <input type="text" min="6"
                                                        class="form-control input-form-control 
                                                        input-form-control-withdraw apply-bg"
                                                         name="phone_verification_code" id="phone_verification_code" 
                                                         placeholder="{{ __('Provide verification code') }}" 
                                                         required data-value-missing="{{ __('This field is required.') }}">
                                                    </div>
                                                </div>
                                
                                            </div>

                                            <span class="error d-none" id="message"></span>
                                        </div>

                                        @php
                                            $bothDisabled = ($is_sms_env_enabled == false && $checkPhoneVerification == "Disabled");
                                        @endphp
                                        <div class="row mt-20">
                                            <div class="col-md-12 pd-bottom pb-2">
                                                <button type="button"
                                                    class="btn bg-primary add-option-btn w-100 setting-btn f-16 leading-20 gilroy-medium common_button next"
                                                    id="phoneSubmitBtn">
                                                    <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none" role="status">
                                                        <span class="visually-hidden"></span>
                                                    </div>
                                                    <span id="profileResetPasswordSubmitBtnText">{{ __('Add phone') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                                                    
                    </div>
                </div>
            </div>



            


        </div>
    </div>
</div>
<!-- Personal Information Div -->
<div class="profile-personal-information bg-white mt-18">
    <div class="d-flex align-items-center">
        <p class="mb-0 f-24 leading-30 gilroy-Semibold text-dark">{{ __('Personal Information') }}</p>
        <div class="hover-qr-code cursor-pointer wallet-svg  position-r">
            <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal-3">
                {!! svgIcons('edit_icon_lg') !!}
            </a>
        </div>

        <div class="modal fade modal-overly" id="exampleModal-3" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg res-dialog">
                <div class="modal-content">
                    <div class="modal-header w-modal-header">
                        <p class="modal-title gilroy-Semibold text-dark">{{ __('Profile Information') }}</p>
                        <button type="button" class="cursor-pointer close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <span class="close-div position-absolute modal-close-btn rtl-wrap-four text-gray-100 d-flex align-items-center justify-content-center">
                                {!! svgIcons('cross_icon') !!}
                            </span>
                        </button>
                    </div>
                    <div class="modal-body modal-body-pxy">
                        <form method="post" action="{{ route('user.profile.update') }}" id="profileUpdateForm">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="id" id="id"/>
                            <input type="hidden" name="defaultCountry" id="defaultCountry">
                            <input type="hidden" name="carrierCode" id="carrierCode">
                            <input type="hidden" name="formattedPhone" id="formattedPhone">
                            <div class="row">
                                <!-- First Name -->
                                <div class="col-6 column-pr-unset2">
                                    <div class="label-top mt-withdraw">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 r-mt-amount r-mt-6">{{ __('First Name') }} <span class="f-16 text-F30">*</span></label>
                                        <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="first_name" id="first_name" value="{{ $user->first_name }}" required data-value-missing="{{ __('This field is required.') }}">
                                        @if($errors->has('first_name'))
                                            <span class="error">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Last Name -->
                                <div class="col-6 column-pl-unset2">
                                    <div class="label-top mt-withdraw position-r">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 r-mt-amount r-mt-6">{{ __('Last Name') }} <span class="f-16 text-F30">*</span></label>
                                        <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="last_name" id="last_name" value="{{ $user->last_name }}" required data-value-missing="{{ __('This field is required.') }}">
                                        @if($errors->has('last_name'))
                                            <span class="error">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Adress 1 -->
                                <div class="col-6 column-pl-unset2">
                                    <div class="label-top mt-withdraw">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" >{{ __('Adress 1') }}</label>
                                        <textarea class="form-control input-form-control input-form-control-withdraw apply-bg" name="address_1" id="address_1" rows="2">{{ $user->user_detail?->address_1 }}</textarea>
                                        @if($errors->has('address_1'))
                                            <span class="error">{{ $errors->first('address_1') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Adress 2 -->
                                <div class="col-6 column-pl-unset2">
                                    <div class="label-top mt-withdraw">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" >{{ __('Adress 2') }}</label>
                                        <textarea class="form-control input-form-control input-form-control-withdraw apply-bg" name="address_2" id="address_2" rows="2">{{ $user->user_detail?->address_1 }}</textarea>
                                        @if($errors->has('address_2'))
                                            <span class="error">{{ $errors->first('address_2') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- City -->
                                <div class="col-6 column-pr-unset2">
                                    <div class="label-top mt-withdraw">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6">{{ __('City') }}</label>
                                        <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="city" id="city" value="{{ $user->user_detail?->city }}">
                                        @if($errors->has('city'))
                                            <span class="error">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- State -->
                                <div class="col-6 column-pl-unset2">
                                    <div class="label-top mt-withdraw position-r">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6">{{ __('State') }}</label>
                                        <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="state" id="state" value="{{ $user->user_detail?->state }}">
                                        @if($errors->has('state'))
                                            <span class="error">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <!-- Country -->
                                <div class="col-6 column-pr-unset2">  
                                    <div class="param-ref param-ref-withdraw param-ref-withdraw-modal money-ref-2">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-0">{{ __('Country') }}</label>
                                        <select class="select2" name="country_id" id="country_id">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ ($user->user_detail?->country_id == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('country_id'))
                                            <span class="error">{{ $errors->first('country_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Timezone -->
                                <div class="col-6 column-pl-unset2">  
                                    <div class="param-ref param-ref-withdraw param-ref-withdraw-modal money-ref-2">
                                        <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-0">{{ __('Time Zone') }}</label>
                                        <select class="select2" name="timezone" id="timezone">
                                            @foreach($timezones as $timezone)
                                                <option value="{{ $timezone['zone'] }}" {{ ($user->user_detail?->timezone == $timezone['zone']) ? 'selected' : '' }}>{{  $timezone['diff_from_GMT'] . ' - ' . $timezone['zone'] }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('timezone'))
                                            <span class="error">{{ $errors->first('timezone') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-md-12 pd-bottom pb-2">
                                    <button type="submit" class="btn bg-primary add-option-btn w-100 setting-btn f-16 leading-20 gilroy-medium" id="profileUpdateSubmitBtn">
                                        <div class="spinner spinner-border text-white spinner-border-sm mx-2 d-none" role="status">
                                            <span class="visually-hidden"></span>
                                        </div>
                                        <span id="profileUpdateSubmitBtnText">{{ __('Save Changes') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Personal Information View Div  -->
    <div class="profile-info-body d-flex profile-wraps justify-content-between mt-36">
        <div class="left-profile-info w-50">
            <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Name') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ getColumnValue($user) }}</p>
            </div>
            <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Email') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray gilroy-medium text-align-end">{{ $user->email ?? 'N/A' }}</p>
            </div>
            <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Address 1') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $user->user_detail?->address_1 }}</p>
            </div>
            <div class="d-flex gap-3 justify-content-between profile-bottom b-unset">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Address 2') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $user->user_detail?->address_2 ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="ml-76 left-profile-info w-50">
            <div class="d-flex gap-3 justify-content-between profile-borders-bottom responsive-mtop">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('City') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $user->user_detail?->city ?? 'N/A' }}</p>
            </div>
            <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('State') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $user->user_detail?->state ?? 'N/A' }}</p>
            </div>
            <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Country') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $user->user_detail?->country?->name }}</p>
            </div>
            <div class="d-flex gap-3 justify-content-between profile-bottom b-unset">
                <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Time Zone') }}</p>
                <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $user->user_detail?->timezone }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('public/dist/plugins/html5-validation/validation.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/dist/plugins/intl-tel-input/js/intlTelInput-jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/dist/js/isValidPhoneNumber.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/dist/libraries/sweetalert/sweetalert-unpkg.min.js') }}" type="text/javascript"></script>
<script>
    'use strict';
    var csrfToken = '{{ csrf_token() }}';
    var userId = $('#id').val();
    var countryShortCode = '{{ getDefaultCountry() }}';
    var utilsScriptLoadingPath = '{{ asset("public/dist/plugins/intl-tel-input/js/utils.min.js") }}';
    var validPhoneNumberErrorText = '{{ __("Please enter a valid international phone number.") }}';
    var formattedPhoneNumber = "{{ !empty($user->formattedPhone) ? $user->formattedPhone : null }}";
    var defaultCountry = "{{ !empty($user->defaultCountry) ? $user->defaultCountry : null }}";
    var carrierCode = "{{ !empty($user->carrierCode) ? $user->carrierCode : null }}";
    var printQrCodeUrl = "{{ route('user.profile.qrcode.print', [$user->id, 'user']) }}";
    var updateQrCodeUrl = "{{ route('user.profile.qrcode.update') }}";
    var profileImageUploadUrl = "{{ route('user.profile.image_upload') }}";
    var duplicatePhoneCheckUrl = "{{ route('user.profile.duplicate_check.phone') }}";
    var pleaseWaitText = "{{ __('Please Wait') }}";
    var loadingText = '{{ __("Loading...") }}';
    var errorText = '{{ __("Error!") }}';
    var updateQrCodeText = "{{ __('Update QR Code') }}";
    var submitButtonText = "{{ __('Submitting...') }}";
    var getVerificationCodeUrl = "{{ url('profile/getVerificationCode') }}";
    var completeVerificationCodeUrl = "{{ url('profile/complete-phone-verification') }}";
    var phoneNumberAddUrl = "{{ url('profile/add-phone-number') }}";
    var phoneNumberUpdateUrl = "{{ url('profile/update-phone-number') }}";
    var nextText = '{{ __("Next") }}';
    var getCodeText = '{{ __("Get Code") }}';
    var verificationCodeText = '{{ __("To make sure this number is yours, we will send you a verification code.") }}';
    var phoneNumberText = '{{ __("Enter the number you’d like to use") }}';
    var smsCodeSentText = '{{ __("Verification code has been sent, please check your phone")}}' ;
    var smsCodeSubmitText = '{{ __("Enter it to verify your phone.") }}';
    var verifyText = '{{ __("Verify") }}';
    var verifyPhoneText = '{{ __("Verify Phone") }}'
    var minPasswordCharacterLength = '{{ __("Please enter at least :x characters.") }}';
    var passwordSameValue = '{{ __("Please enter the same value again.") }}';
    var submittingText = '{{ __("Submitting...") }}';
    var submitText = '{{ __("Submit") }}';
    var updatePhoneText = '{{ __("Phone Update") }}';
    var successText = '{{ __("Success") }}';
    var smsFailText = '{{ __("SMS not send") }}';

</script>
<script src="{{ asset('public/user/customs/js/phone.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/user/customs/js/profile.min.js')}}" type="text/javascript"></script>
@endpush --}}

@extends('user.layouts.app')

@section('content')
<section class="dashboard-section body-collapse account">
    <div class="overlay pt-120">
        <div class="container-fruid">
            <div class="main-content">
                <div class="row">
                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="owner-details">
                            <div class="profile-area">
                                <div class="profile-img">
                                    <img width="120" height="120" src="{{ image(auth()->user()->picture, 'profile') }}" alt="{{ __('profile') }}">
                                </div>
                                <div class="name-area">
                                    <h6>{{ getColumnValue($user) }}</h6>
                                    <p class="active-status">Active</p>
                                </div>
                            </div>
                            <div class="owner-info">
                                <ul>
                                    <li>
                                        <p>Account ID:</p>
                                        <span class="mdr">Rex49484</span>
                                    </li>
                                    <li>
                                        <p>Joined:</p>
                                        <span class="mdr">Aug 25,2021</span>
                                    </li>
                                    <li>
                                        <p>Confirm status:</p>
                                        <span class="mdr">80%</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="owner-action">
                                <a href="{{ route('user.logout') }}">
                                    <img src="{{ asset('public/user') }}/assets/images/icon/logout.png" alt="logout">
                                    {{ __('Logout') }}
                                </a>
                                <a href="javascript:void(0)" class="delete">
                                    <img src="{{ asset('public/user') }}/assets/images/icon/delete-2.png" alt="delete">
                                    Delete Account
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-8">
                        <div class="tab-main">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="account-tab" data-bs-toggle="tab"
                                        data-bs-target="#account" type="button" role="tab" aria-controls="account"
                                        aria-selected="true">Account</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="security-tab" data-bs-toggle="tab"
                                        data-bs-target="#security" type="button" role="tab" aria-controls="security"
                                        aria-selected="false">Security</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="payment-tab" data-bs-toggle="tab"
                                        data-bs-target="#payment" type="button" role="tab" aria-controls="payment"
                                        aria-selected="false">Payment Methods</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="notification-tab" data-bs-toggle="tab"
                                        data-bs-target="#notification" type="button" role="tab"
                                        aria-controls="notification" aria-selected="false">Notification</button>
                                </li>
                            </ul>
                            <div class="tab-content mt-40">
                                <div class="tab-pane fade show active" id="account" role="tabpanel"
                                    aria-labelledby="account-tab">
                                    <div class="upload-avatar">
                                        <div class="avatar-left d-flex align-items-center">
                                            <div class="profile-img">
                                                <img width="80" height="80" src="{{ image(auth()->user()->picture, 'profile') }}" alt="owner">
                                            </div>
                                            <div class="instraction">
                                                <h6>Your Avatar</h6>
                                                <p>Profile picture size: 400px x 400px</p>
                                            </div>
                                        </div>
                                        <div class="avatar-right">
                                            <div class="file-upload">
                                                <div class="right-area">
                                                    <label class="file">
                                                        <input type="file">
                                                        <span class="file-custom"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="#">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <label for="fName">{{ __('First Name') }}</label>
                                                    <input type="text" id="fName" placeholder="Alfred" value="{{ $user->first_name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <label for="lName">{{ __('Last Name') }}</label>
                                                    <input type="text" id="lName" placeholder="Davis" value="{{ $user->last_name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <label for="email">{{ __('Email') }}</label>
                                                    <div class="row input-status d-flex align-items-center">
                                                        <div class="col-6">
                                                            <input type="text" id="email" placeholder="alfred6598@gmail.com" value="{{ $user->email }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="pending">
                                                                <img src="{{ asset('public/user') }}/assets/images/icon/pending.png" alt="icon">
                                                                E-mail confirmation in pending
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <label for="phone">{{ __('Phone') }}</label>
                                                    <div class="row input-status d-flex align-items-center">
                                                        <div class="col-6">
                                                            <input type="text" id="phone" placeholder="(316) 555-0116" value="{{ $user->phone }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="confirm">
                                                                <img src="{{ asset('public/user') }}/assets/images/icon/confirm.png" alt="icon">
                                                                Phone number confirm
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input file">
                                                    <label>ID Confirmation documents</label>
                                                    <div class="row input-status d-flex align-items-center">
                                                        <div class="col-6">
                                                            <div class="file-upload">
                                                                <div class="right-area">
                                                                    <label class="file">
                                                                        <input type="file">
                                                                        <span class="file-custom"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="notconfirm">
                                                                <img src="{{ asset('public/user') }}/assets/images/icon/not-confirm.png" alt="icon">
                                                                Person not confirmed
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <label for="address">{{ __('Address') }}</label>
                                                    <input type="text" id="address" placeholder="2972 Westheimer Rd. Santa Ana, Illinois 85486" value="{{ $user->address }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="btn-border">
                                                    <button class="cmn-btn">Account</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="security" role="tabpanel"
                                    aria-labelledby="security-tab">
                                    <div class="single-content authentication d-flex align-items-center justify-content-between">
                                        <div class="left">
                                            <h5>Two Factor Authentication</h5>
                                            <p>Two-Factor Authentication (2FA) can be used to help protect your account</p>
                                        </div>
                                        <div class="right">
                                            <button>Enable</button>
                                        </div>
                                    </div>
                                    <div class="change-pass mb-40">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h5>Change Password</h5>
                                                <p>You can always change your password for security reasons or reset your password in case you forgot it.</p>
                                                <a href="javascript:void(0)">Forgot password?</a>
                                            </div>
                                            <div class="col-sm-6">
                                                <form action="#">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-12">
                                                            <div class="single-input">
                                                                <label for="current-password">Current password</label>
                                                                <input type="text" id="current-password" placeholder="Current password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="single-input">
                                                                <label for="new-password">New password</label>
                                                                <input type="text" id="new-password" placeholder="New password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="single-input">
                                                                <label for="confirm-password">Confirm New password</label>
                                                                <input type="text" id="confirm-password" placeholder="Confirm New password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="btn-border w-100">
                                                                <button class="cmn-btn w-100">Update password</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-content additional-security">
                                        <h5>Additional security</h5>
                                        <div class="single-setting">
                                            <div class="left">
                                                <h6>SMS recovery</h6>
                                                <p>Number ending with 1234</p>
                                            </div>
                                            <div class="right">
                                                <button class="active">Disable SMS</button>
                                            </div>
                                        </div>
                                        <div class="single-setting">
                                            <div class="left">
                                                <h6>Autheticator App</h6>
                                                <p>Google Authenticator</p>
                                            </div>
                                            <div class="right">
                                                <button>Configure</button>
                                            </div>
                                        </div>
                                        <div class="single-setting">
                                            <div class="left">
                                                <h6>SSL Certificate</h6>
                                                <p>Secure Sockets Layer</p>
                                            </div>
                                            <div class="right">
                                                <button>Configure</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-content your-devices">
                                        <div class="head-item d-flex align-items-center justify-content-between">
                                            <h5>Your devices</h5>
                                            <a href="javascript:void(0)">Log out on all devices</a>
                                        </div>
                                        <div class="single-setting">
                                            <div class="left">
                                                <div class="icon-area">
                                                    <img src="{{ asset('public/user') }}/assets/images/icon/iphone.png" alt="icon">
                                                </div>
                                                <div class="text-area">
                                                    <h6>Iphone 13 Pro Max</h6>
                                                    <p>New York City · June 20 at 14:00</p>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <button>Log out</button>
                                            </div>
                                        </div>
                                        <div class="single-setting">
                                            <div class="left">
                                                <div class="icon-area">
                                                    <img src="{{ asset('public/user') }}/assets/images/icon/ipad.png" alt="icon">
                                                </div>
                                                <div class="text-area">
                                                    <h6>iPad Pro</h6>
                                                    <p>New York City · June 20 at 14:00</p>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <button>Log out</button>
                                            </div>
                                        </div>
                                        <div class="single-setting">
                                            <div class="left">
                                                <div class="icon-area">
                                                    <img src="{{ asset('public/user') }}/assets/images/icon/imac.png" alt="icon">
                                                </div>
                                                <div class="text-area">
                                                    <h6>iMac OSX</h6>
                                                    <p>New York City · June 20 at 14:00</p>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <button>Log out</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane pb-120 fade" id="payment" role="tabpanel"
                                    aria-labelledby="payment-tab">
                                    <div class="card-area">
                                        <h6>Linked Payment system</h6>
                                        <div class="card-content d-flex flex-wrap">
                                            <div class="single-card">
                                                <button type="button" class="reg w-100" data-bs-toggle="modal" data-bs-target="#transactionsMod">
                                                    <img src="{{ asset('public/user') }}/assets/images/visa-card.png" alt="image" class="w-100">
                                                </button>
                                            </div>
                                            <div class="single-card">
                                                <button type="button" class="reg w-100" data-bs-toggle="modal" data-bs-target="#transactionsMod">
                                                    <img src="{{ asset('public/user') }}/assets/images/paylio-card.png" alt="image" class="w-100">
                                                </button>
                                            </div>
                                            <div class="single-card">
                                                <button type="button" class="reg w-100" data-bs-toggle="modal" data-bs-target="#transactionsMod">
                                                    <img src="{{ asset('public/user') }}/assets/images/paypal-card.png" alt="image" class="w-100">
                                                </button>
                                            </div>
                                            <div class="single-card">
                                                <button type="button" class="reg w-100" data-bs-toggle="modal" data-bs-target="#transactionsMod">
                                                    <img src="{{ asset('public/user') }}/assets/images/blockchain-card.png" alt="image" class="w-100">
                                                </button>
                                            </div>
                                            <div class="single-card">
                                                <button type="button" class="reg w-100" data-bs-toggle="modal" data-bs-target="#addcardMod">
                                                    <img src="{{ asset('public/user') }}/assets/images/add-new.png" alt="image" class="w-100">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="notification" role="tabpanel"
                                    aria-labelledby="notification-tab">

                                    <div class="notification-single">
                                        <h6>Announcements</h6>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="notification-single">
                                        <h6>Send payment</h6>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="notification-single">
                                        <h6>Receive a payment</h6>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="notification-single">
                                        <h6>Request payment</h6>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="notification-single">
                                        <h6>Have a problem with a payment</h6>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="notification-single">
                                        <h6>Special Offers</h6>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')

@endpush