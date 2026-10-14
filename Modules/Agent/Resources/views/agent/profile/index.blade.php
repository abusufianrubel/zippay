@extends('agent::agent.layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/intl-tel-input/css/intlTelInput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Agent/Resources/assets/css/profile.min.css') }}">
@endpush

@section('content')
    <!-- main-containt -->
    <div class="text-center">
        <p class="mb-0 gilroy-Semibold f-26 text-dark theme-tran r-f-20 text-uppercase">{{ __('Your Profile') }}</p>
        <p class="mb-0 gilroy-medium text-gray-100 f-16 r-f-12 profile-header mt-2 tran-title">
            {{ __('You have full control to manage your own account setting') }}
        </p>
    </div>

    @include('user.common.alert')
    
    <div class="row" id="agentProfile">
        <div class="col-xl-12 col-xxl-6">
            <!-- Profile Image Div -->
            <div class="avatar-left-div bg-white mt-32">
                <div class="d-flex justify-content-between">
                    <div class="left-avatar-desc">
                        <p class="mb-0 f-20 leading-25 gilroy-Semibold text-dark">{{ getColumnValue(auth('agent')->user('agent')) }}</p>
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
                        @if (File::exists(base_path(\Modules\Agent\Entities\Agent::$directory . auth('agent')->user()->photo)) && !empty(auth('agent')->user()->photo))
                            <img src="{{ asset(\Modules\Agent\Entities\Agent::$directory . auth('agent')->user()->photo) }}" alt="{{ __('Profile') }}" id="profileImage">
                        @else
                            <img src="{{ image(null, 'profile') }}" alt="{{ __('Profile') }}" id="profileImage">
                        @endif
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
                                        <form method="post" action="{{ route('agent.profile.wallet.default') }}" id="defaultCurrencyForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="settingId"></div>
                                                    <div class="col-md-12">
                                                        <div class="param-ref param-ref-withdraw  money-ref r-mt-11">
                                                            <label class="gilroy-medium text-gray-100 mb-7 f-14 leading-17 r-mt-0" for="default_wallet">{{ __('Select Wallet') }}
                                                            </label>
                                                            <select class="select2 withdraw-type" data-minimum-results-for-search="Infinity" name="default_wallet" id="default_wallet">
                                                                @foreach($wallets as $wallet)
                                                                    <option value="{{ $wallet['currency_id'] }}" {{ $wallet['is_default'] == 'Yes' ? 'Selected' : ''}}>{{ $wallet['currency_code'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-20">
                                                <div class="col-md-12 pd-bottom pb-2">
                                                    <button type="submit" class="btn bg-primary add-option-btn w-100 setting-btn f-16 leading-20 gilroy-medium" id="defaultCurrencySubmitBtn">
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
                <p class="mb-0 f-20 leading-25 gilroy-Semibold text-uppercase text-primary">{{ $defaultWallet['currency']['code'] ?? 'N/A'}}</p>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-xl-12 col-xxl-6">
            <div class="bg-white profile-qr-code mt-32">
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
                                        <form method="post" action="{{ route('agent.profile.password.update') }}" id="profileResetPasswordForm">
                                            @csrf
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="label-top mt-withdraw">
                                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 r-mt-amount r-mt-6" for="current_password">{{ __('Current password') }}</label>
                                                            <input type="password" class="form-control input-form-control input-form-control-withdraw apply-bg" name="current_password" id="current_password" placeholder="{{ __('Current password') }}" required data-value-missing="{{ __('This field is required.') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="label-top mt-withdraw position-r">
                                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" for="password">{{ __('New Password') }}</label>
                                                            <div id="show_hide_password">
                                                                <input type="password" class="form-control input-form-control input-form-control-withdraw apply-bg" name="password" id="password" placeholder="{{ __('New Password') }}" required data-value-missing="{{ __('This field is required.') }}">
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
                                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" for="password_confirmation"> {{ __('Confirm Password') }}</label>
                                                            <input type="password" class="form-control input-form-control input-form-control-withdraw apply-bg" name="password_confirmation" id="password_confirmation" placeholder="{{ __('Confirm Password') }}" required data-value-missing="{{ __('This field is required.') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-20">
                                                <div class="col-md-12 pd-bottom pb-2">
                                                    <button type="submit" class="btn bg-primary add-option-btn w-100 setting-btn f-16 leading-20 gilroy-medium" id="profileResetPasswordSubmitBtn">
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
                <!-- Email Div -->
                <div class="profile-qr-bootom d-flex justify-content-between align-items-center mt-27">
                    <div class="d-flex align-items-center">
                        {!! svgIcons('envalop') !!}
                        <p class="ml-12 mb-0 f-16 leading-20 gilroy-medium text-dark">{{ __('Email Address') }}</p>
                    </div>
                    <p class="mb-0 f-15 leading-18 gilroy-medium d-flex align-items-center text-gray-100 responsive-mail-text">{{ $agent['email'] }}</p>
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
                            <form method="post" action="{{ route('agent.profile.update') }}" id="profileUpdateForm">
                                @csrf
                                <input type="hidden" value="{{ $agent['id'] }}" name="id" id="id"/>
                                <input type="hidden" value="{{ $agent['status'] }}" name="status" id="status"/>
                                <input type="hidden" name="iso2" id="iso2">
                                <input type="hidden" name="dial_code" id="dial_code">
                                <input type="hidden" name="formatted_phone" id="formatted_phone">
                                
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-6 column-pr-unset2">
                                        <div class="label-top mt-withdraw">
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 r-mt-amount r-mt-6" for="first_name">{{ __('First Name') }} <span class="f-16 text-danger">*</span></label>
                                            <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="first_name" id="first_name" value="{{ $agent['first_name'] }}" required data-value-missing="{{ __('This field is required.') }}">
                                            @if($errors->has('first_name'))
                                                <span class="error">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Last Name -->
                                    <div class="col-6 column-pl-unset2">
                                        <div class="label-top mt-withdraw position-r">
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 r-mt-amount r-mt-6" for="last_name">{{ __('Last Name') }} <span class="f-16 text-danger">*</span></label>
                                            <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="last_name" id="last_name" value="{{ $agent['last_name'] }}" required data-value-missing="{{ __('This field is required.') }}">
                                            @if($errors->has('last_name'))
                                                <span class="error">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Phone -->
                                <div class="row">
                                    <div class="col-6 column-pr-unset2">
                                        <div class="label-top mt-withdraw intlTel-phone">
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" for="phone">{{ __('Phone') }} <span class="f-16 text-danger">*</span></label>
                                            <input type="tel" class="form-control apply-bg" id="phone" name="phone" required>
                                            @if ($errors->has('phone'))
                                                <span class="error">{{ $errors->first('phone') }}</span>
                                            @endif
                                            <span id="phone-error"></span>
                                            <span id="tel-error"></span>
                                        </div>
                                    </div>

                                    <!-- Adress 1 -->
                                    <div class="col-6 column-pl-unset2">
                                        <div class="label-top mt-withdraw">
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" for="address">{{ __('Adress 1') }} <span class="f-16 text-danger">*</span></label>
                                            <textarea class="form-control input-form-control input-form-control-withdraw apply-bg" name="address" id="address" rows="2" required>{{ $agent['address'] }}</textarea>
                                            @if($errors->has('address'))
                                                <span class="error">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- City -->
                                    <div class="col-6 column-pr-unset2">
                                        <div class="label-top mt-withdraw">
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" for="city">{{ __('City') }} <span class="f-16 text-danger">*</span></label>
                                            <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="city" id="city" value="{{ $agent['city'] }}" required>
                                            @if($errors->has('city'))
                                                <span class="error">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- State -->
                                    <div class="col-6 column-pl-unset2">
                                        <div class="label-top mt-withdraw position-r">
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-amount r-mt-6" for="state">{{ __('State') }} <span class="f-16 text-danger">*</span></label>
                                            <input type="text" class="form-control input-form-control input-form-control-withdraw apply-bg" name="state" id="state" value="{{ $agent['state'] }}" required>
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
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-0" for="country_id">{{ __('Country') }}</label>
                                            <select class="select2" name="country_id" id="country_id">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country['id'] }}" {{ $country['name'] == $agent['country'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
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
                                            <label class="gilroy-medium text-gray-100 mb-2 f-14 leading-17 mt-20 r-mt-0" for="timezone">{{ __('Time Zone') }}</label>
                                            <select class="select2" name="timezone" id="timezone">
                                                @forelse ($timezones as $timezone)
                                                    <option value="{{ $timezone['zone'] }}" {{ $agent['timezone'] == $timezone['zone'] ? 'selected' : '' }} >{{ $timezone['diff_from_GMT'] . $timezone['zone'] }}</option>
                                                @empty
                                                    <option>{{ __('No timezones available') }}</option>
                                                @endforelse
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
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Business Name') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['business_name'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('First Name') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['first_name'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Last Name') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['last_name'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Phone') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['formatted_phone'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-bottom b-unset">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Package') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['package_name'] }}</p>
                </div>
            </div>
            <div class="ml-76 left-profile-info w-50">
                <div class="d-flex gap-3 justify-content-between profile-borders-bottom responsive-mtop">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Address') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['address'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-borders-bottom responsive-mtop">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('City') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['city'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('State') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['state'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-borders-bottom">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Country') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['country'] }}</p>
                </div>
                <div class="d-flex gap-3 justify-content-between profile-bottom b-unset">
                    <p class="mb-0 f-15 leading-18 text-dark gilroy-medium text-align-initial">{{ __('Time Zone') }}</p>
                    <p class="mb-0 f-15 leading-18 text-gray-100 gilroy-medium text-align-end">{{ $agent['timezone'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- main-containt -->
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
        var utilsScriptLoadingPath = "{{ asset('public/dist/plugins/intl-tel-input/js/utils.min.js') }}";
        var validPhoneNumberErrorText = "{{ __('Please enter a valid international phone number.') }}";
        var phone = "{{ !empty($agent['phone']) ? $agent['phone'] : null }}";
        var formattedPhoneNumber = "{{ !empty($agent['formatted_phone']) ? $agent['formatted_phone'] : null }}";
        var defaultCountry = "{{ !empty($agent['iso2']) ? $agent['iso2'] : null }}";
        var carrierCode = "{{ !empty($agent['dial_code']) ? $agent['dial_code'] : null }}";
        var profileImageUploadUrl = "{{ route('agent.profile.image.update') }}";
        var pleaseWaitText = "{{ __('Please Wait') }}";
        var loadingText = "{{ __('Loading...') }}";
        var errorText = "{{ __('Error!') }}";
        var updateQrCodeText = "{{ __('Update QR Code') }}";
        var submitButtonText = "{{ __('Submitting...') }}";
        var duplicatePhoneCheckUrl  = "{{ route('agent.profile.duplicate_check.phone') }}";
    </script>

    <script type="text/javascript" src="{{ asset('Modules/Agent/Resources/assets/js/agent/phone.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Modules/Agent/Resources/assets/js/agent/agent.min.js') }}"></script>
@endpush
