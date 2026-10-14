@extends('admin.layouts.master')

@section('title', __('Edit Agent'))

@section('head_style')
    <link rel="stylesheet" href="{{ asset('dist/plugins/intl-tel-input/css/intlTelInput.min.css') }}">
@endsection

@section('page_content')
    <div class="row" id="agent-edit">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Edit Agent') }}</h3>
                </div>
                <form method="post" action="{{ route('admin.agents.agents.update', $agent->id) }}" class="form-horizontal" id="agentEditForm">
                    @csrf
                    @method('put')
                    <input type="hidden" name="agent_id" id="id" value="{{ $agent->id }}">
                    <input type="hidden" name="iso2" id="iso2" value="{{ $agent->iso2 }}">
                    <input type="hidden" name="dial_code" id="dialCode" value="{{ $agent->dial_code }}">
                    <input type="hidden" name="formatted_phone" id="formattedPhone" value="{{ $agent->formatted_phone }}">

                    <div class="box-body">

                        <!-- Business Name -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="business_name">{{ __('Business Name') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" name="business_name" type="text" id="business_name" value="{{ $agent->business_name }}" required data-value-missing="{{ __('This field is required.') }}" placeholder="{{ __('Enter :x', ['x' => __('Business Name')]) }}">
                                @if ($errors->has('business_name'))
                                    <span class="error">{{ $errors->first('business_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- FirstName -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="first_name">{{ __('First Name') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" placeholder="{{ __('Enter :x', ['x' => __('first name')]) }}" name="first_name" type="text" id="first_name" value="{{ $agent->first_name }}" required data-value-missing="{{ __('This field is required.') }}" maxlength="30" data-max-length="{{ __(':x length should be maximum :y charcters.', ['x' => __('First name'), 'y' => __('30')]) }}">
                                @if ($errors->has('first_name'))
                                    <span class="error">
                                        {{ $errors->first('first_name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- LastName -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="last_name">{{ __('Last Name') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" name="last_name" type="text" id="last_name" value="{{ $agent->last_name }}" required data-value-missing="{{ __('This field is required.') }}" maxlength="30" data-max-length="{{ __(':x length should be maximum :y character.', ['x' => __('Last name'), 'y' => __('30')]) }}" placeholder="{{ __('Enter :x', ['x' => __('last name')]) }}">
                                @if ($errors->has('last_name'))
                                    <span class="error">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="email">{{ __('Email') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" placeholder="{{ __('Enter a valid :x.', ['x' => __('email')]) }}" name="email" type="email" id="email" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('email'))]) }}" value="{{ $agent->email }}">
                                @if ($errors->has('email'))
                                <span class="error">{{ $errors->first('email') }}</span>
                                @endif
                                <span id="emailError"></span>
                                <span id="email-ok" class="text-success"></span>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="phone">{{ __('Phone') }}</label>
                            <div class="col-sm-6 intlTelInput-phone">
                                <input type="tel" class="form-control f-14" id="phone" name="phone">
                                @if ($errors->has('phone'))
                                    <span class="error">{{ $errors->first('phone') }}</span>
                                @endif
                                <span id="duplicate-phone-error"></span>
                                <span id="tel-error"></span>
                            </div>
                        </div>

                        <!-- New password -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="password">{{ __('Password') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" placeholder="{{ __('Enter new Password') }}" name="password" type="password" id="password">
                                @if ($errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Confirm new password -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" placeholder="{{ __('Confirm password') }}" name="password_confirmation" type="password" id="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Agent Package -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="agent_package_id">{{ __('Agent Package') }}</label>
                            <div class="col-sm-6">
                                <select class="select2 f-14" name="agent_package_id" id="agent_package_id">
                                    @foreach (\Modules\Agent\Services\AgentPackageService::getAllPackages() as $package)
                                        <option value="{{ $package->id }}" {{ $agent->agent_package_id == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="address">{{ __('Address') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" name="address" type="text" id="address" value="{{ $agent->address }}" required data-value-missing="{{ __('This field is required.') }}" placeholder="{{ __('Enter :x', ['x' => __('last name')]) }}">
                                @if ($errors->has('address'))
                                    <span class="error">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="country_id">{{ __('Country') }}</label>
                            <div class="col-sm-6">
                                <select class="select2 f-14" name="country_id" id="country_id">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ ($agent->country_id == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('country_id'))
                                    <span class="error">{{ $errors->first('country_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- State -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="state">{{ __('State') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" name="state" type="text" id="state" value="{{ $agent->state }}" required data-value-missing="{{ __('This field is required.') }}" placeholder="{{ __('Enter :x', ['x' => __('last name')]) }}">
                                @if ($errors->has('state'))
                                    <span class="error">{{ $errors->first('state') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- City -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="city">{{ __('City') }}</label>
                            <div class="col-sm-6">
                                <input class="form-control f-14" name="city" type="text" id="city" value="{{ $agent->city }}" required data-value-missing="{{ __('This field is required.') }}" placeholder="{{ __('Enter :x', ['x' => __('last name')]) }}">
                                @if ($errors->has('city'))
                                    <span class="error">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Time Zone -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label require text-sm-end f-14 fw-bold" for="timezone">{{ __('Time Zone') }}</label>
                            <div class="col-sm-6 col-md-6">
                                <select class="select2 f-14" name="timezone" id="timezone" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    @foreach ($timezones as $timezone)
                                        <option value="{{ $timezone['zone'] }}" {{ ($agent->timezone == $timezone['zone']) ? 'selected' : '' }}>{{  $timezone['diff_from_GMT'] . ' - ' . $timezone['zone'] }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('timezone'))
                                    <span class="error">{{ $errors->first('timezone') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group row">
                            <label class="col-sm-3 mt-11 control-label text-sm-end f-14 fw-bold require" for="status">{{ __('Status') }}</label>
                            <div class="col-sm-6">
                                <select class="select2 f-14" name="status" id="status" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <option value='Active' {{ $agent->status == 'Active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value='Suspended' {{ $agent->status == 'Suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                                    <option value='Inactive' {{ $agent->status == 'Inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="row">
                            <div class="col-sm-6 offset-md-3">
                                <a class="btn btn-theme-danger f-14 me-1" href="{{ route('admin.agents.agents.index') }}" id="agentEditCancel">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-theme f-14 float-right" id="agentUpdateSubmitBtn">
                                    <i class="fa fa-spinner fa-spin d-none"></i>
                                    <span id="agentUpdateSubmitBtnText">{{ __('Update') }}</span>
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
    <script type="text/javascript" src="{{ asset('dist/plugins/html5-validation/validation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/plugins/intl-tel-input/js/intlTelInput-jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/js/isValidPhoneNumber.min.js') }}"></script>
    
    <script type="text/javascript">
        'use strict';
        var countryShortCode = "{{ getDefaultCountry() }}";
        var emailCheckUrl = "{{ route('admin.agents.agents.email_check') }}";
        var phoneCheckUrl = "{{ route('admin.agents.agents.phone_check') }}";
        var passErrorMgs = "{{ __('Please enter the same value as the password field.') }}";
        var validPhoneNumberErrorText = "{{ __('Please enter a valid International phone number.') }}";
        var formattedPhoneNumber = "{{ !empty($agent->formatted_phone) ? $agent->formatted_phone : null }}";
        var dialCode = "{{ !empty($agent->dial_code) ? $agent->dial_code : null }}";
        var iso2 = "{{ !empty($agent->iso2) ? $agent->iso2 : null }}";
        var utilsScriptLoadingPath = "{{ asset('dist/plugins/intl-tel-input/js/utils.min.js') }}";
        var inactiveWarning = "{!! __('Warning! User would not be able to login.') !!}";
        var suspendWarning = "{!! __('Warning! User would not be able to do any transaction.') !!}";
        var phnErrorMgs = "{{ __('Please enter a valid International phone number.') }}";
        var submitButtonText = "{{ __('Submitting...') }}";
    </script>
    <script type="text/javascript" src="{{ asset('Modules/Agent/Resources/assets/js/admin/admin_agent.min.js') }}"></script>
@endpush
