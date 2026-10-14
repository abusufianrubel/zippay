@extends('admin.layouts.master')

@section('title', __('Create agent'))

@section('head_style')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/intl-tel-input/css/intlTelInput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Agent/Resources/assets/css/agent.min.css') }}">
@endsection

@section('page_content')
<div class="row" id="agent-create">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Add new agent') }}</h3>
            </div>
            <form method="post" action="{{ route('admin.agents.agents.store') }}" class="form-horizontal" id="agent-create-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="iso2" id="iso2">
                <input type="hidden" name="dial_code" id="dialCode">
                <input type="hidden" name="formatted_phone" id="formattedPhone">
                
                <div class="box-body">

                    <div class="form-group row">
                        <!-- Business Name -->
                        <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="business_name">{{ __('Business Name') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <input class="form-control f-14" name="business_name" type="text" id="business_name" value="{{ old('business_name') }}" required data-value-missing="{{ __('This field is required.') }}"
                            maxlength="30" data-max-length="{{ __(':x length should be maximum :y charcters.', ['x' => __('Business Name'), 'y' => __('30')]) }}" placeholder="{{ __('Enter :x', ['x' => __('Business Name')]) }}">
                            @if($errors->has('business_name'))
                                <span class="error">{{ $errors->first('business_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- FirstName -->
                        <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="first_name">{{ __('First Name') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <input class="form-control f-14" placeholder="{{ __('Enter :x', ['x' => __('first name')]) }}" name="first_name" type="text" id="first_name" value="{{ old('first_name') }}"
                            required data-value-missing="{{ __('This field is required.') }}"
                            maxlength="30" data-max-length="{{ __(':x length should be maximum :y charcters.', ['x' => __('First name'), 'y' => __('30')]) }}">
                            @if($errors->has('first_name'))
                                <span class="error">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- LastName -->
                        <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="last_name">{{ __('Last Name') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <input class="form-control f-14" placeholder="{{ __('Enter :x', ['x' => __('last name')]) }}" name="last_name" type="text" id="last_name" value="{{ old('last_name') }}"
                            required data-value-missing="{{ __('This field is required.') }}"
                            maxlength="30" data-max-length="{{ __(':x length should be maximum :y character.', ['x' => __('Last name'), 'y' => __('30')]) }}">
                            @if($errors->has('last_name'))
                                <span class="error">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- Email -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="email">{{ __('Email') }}</label>
                        <div class="col-sm-6">
                            <input class="form-control f-14" name="email" type="email" id="email" value="{{ old('email') }}" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-type-mismatch="{{ __('Enter a valid :x.', [ 'x' => strtolower(__('email'))]) }}" placeholder="{{ __('Enter a valid :x.', ['x' => __('email')] )}}">
                            @if($errors->has('email'))
                                <span class="error">{{ $errors->first('email') }}</span>
                            @endif
                            <span id="email_error"></span>
                            <span id="email_ok" class="text-success"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- Phone -->
                        <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="phone">{{ __('Phone') }}</label>
                        <div class="col-sm-6 intlTelInput-phone">
                            <input type="tel" class="form-control f-14" id="phone" name="phone" required>
                            @if($errors->has('phone'))
                                <span class="error">{{ $errors->first('phone') }}</span>
                            @endif
                            <span id="duplicate-phone-error"></span>
                            <span id="tel-error"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- New password -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="password">{{ __('Password') }}</label>
                        <div class="col-sm-6">
                            <input class="form-control f-14" placeholder="{{ __('Enter new Password') }}" name="password" type="password" id="password"
                            required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                            minlength="6" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Password'), 'y' => '6']) }}">
                            @if($errors->has('password'))
                                <span class="error">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- Confirm new password -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="password_confirmation">{{ __('Confirm Password') }}</label>
                        <div class="col-sm-6">
                            <input class="form-control f-14" placeholder="{{ __('Confirm password') }}" name="password_confirmation" type="password" id="password_confirmation"
                            required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                            minlength="6" data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Password'), 'y' => '6']) }}">
                            @if($errors->has('password_confirmation'))
                                <span class="password_confirmation error">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- Agent Package -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="agent_package_id">{{ __('Agent Package') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <select class="select2 f-14" name="agent_package_id" id="agent_package_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                @foreach ($agentPackages as $package)
                                    <option value="{{ $package->id }}" {{ $defaultPackage->is_default ==  $package->is_default ? 'selected' : ''}}>{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- Address -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="address">{{ __('Address') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <input class="form-control f-14" name="address" type="text" id="address" value="{{ old('address') }}"
                            required data-value-missing="{{ __('This field is required.') }}" maxlength="30" data-max-length="{{ __(':x length should be maximum :y charcters.', ['x' => __('Address'), 'y' => __('30')]) }}" placeholder="{{ __('Enter :x', ['x' => __('Address')]) }}">
                            @if($errors->has('address'))
                                <span class="error">
                                    {{ $errors->first('address') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- Country -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="country_id">{{ __('Country') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <select class="select2 f-14" name="country_id" id="country_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ $defaultCountry == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('country_id'))
                                <span class="error">{{ $errors->first('country_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- State -->
                        <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="state">{{ __('State') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <input class="form-control f-14" name="state" type="text" id="state" value="{{ old('state') }}" required data-value-missing="{{ __('This field is required.') }}"  placeholder="{{ __('Enter :x', ['x' => __('State')]) }}">
                            @if($errors->has('state'))
                                <span class="error">{{ $errors->first('state') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- City -->
                        <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="city">{{ __('City') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <input class="form-control f-14" name="city" type="text" id="city" value="{{ old('city') }}" required data-value-missing="{{ __('This field is required.') }}" placeholder="{{ __('Enter :x', ['x' => __('City')]) }}">
                            @if($errors->has('city'))
                                <span class="error">{{ $errors->first('city') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- Time Zone -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="timezone">{{ __('Time Zone') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <select class="select2 f-14" name="timezone" id="timezone" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                @foreach ($timezones as $timezone)
                                    <option value="{{ $timezone['zone'] }}" {{ (preference('dflt_timezone') == $timezone['zone']) ? 'selected' : '' }}>{{  $timezone['diff_from_GMT'] . ' - ' . $timezone['zone'] }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('timezone'))
                                <span class="error">{{ $errors->first('timezone') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <!-- Status -->
                        <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="status">{{ __('Status') }}</label>
                        <div class="col-sm-6 col-md-6">
                            <select class="select2 f-14" name="status" id="status" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                <option value='Active'>{{ __('Active') }}</option>
                                <option value='Inactive'>{{ __('Inactive') }}</option>
                                <option value='Suspended'>{{ __('Suspended') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="row">
                        <div class="col-sm-6 offset-md-3">
                            <a class="btn btn-theme-danger f-14 me-1" href="{{ route('admin.agents.agents.index') }}" id="agent-cancel">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-theme f-14 float-right" id="agent-create-btn">
                                <i class="fa fa-spinner fa-spin d-none"></i>
                                <span id="agent-create-btn-text">{{ __('Create') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('extra_body_scripts')
    <script type="text/javascript" src="{{ asset('public/dist/plugins/html5-validation/validation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/dist/plugins/intl-tel-input/js/intlTelInput-jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/dist/js/isValidPhoneNumber.min.js') }}"></script>

    <script type="text/javascript">
        'use strict';
        var countryShortCode = "{{ getDefaultCountry() }}";
        var emailCheckUrl = "{{ route('admin.agents.agents.email_check') }}";
        var phoneCheckUrl = "{{ route('admin.agents.agents.phone_check') }}";
        var passErrorMgs = "{{ __('Please enter the same value as the password field.') }}";
        var phnErrorMgs = "{{ __('Please enter a valid International phone number.') }}";
        var submitButtonText = "{{ __('Creating...') }}";
        var validEmailErrorMgs = "{{ __('Please enter a valid email.') }}";
        var utilsScriptLoadingPath = "{{ asset('public/dist/plugins/intl-tel-input/js/utils.min.js') }}";
    </script>
    <script type="text/javascript" src="{{ asset('Modules/Agent/Resources/assets/js/admin/admin_agent.min.js') }}"></script>
@endpush
