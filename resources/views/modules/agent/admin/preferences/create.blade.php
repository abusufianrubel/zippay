@extends('admin.layouts.master')

@section('title', __('Agent Preferences'))

@section('page_content')
    <!-- Main content -->
    <div class="row">

        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Agent Preferences') }}</h3>
                </div>
                <form method="post" action="{{ route('admin.agents.preferences.store') }}" id="preference-form" class="form-horizontal">
                    @csrf
                    <div class="box-body">

                        <!-- Send/Request Via -->
                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 control-label f-14 fw-bold text-sm-end" for="agent_login_via">{{ __('Agent Login Via') }}</label>
                            <div class="col-sm-6">
                                <select name="agent_login_via" class="select2" id="agent_login_via">
                                    <option value='email_only' {{ isset($prefData['preference']['agent_login_via']) && $prefData['preference']['agent_login_via'] == 'email_only' ? 'selected' : ""}}>{{ __('Email Only') }}</option>
                                    <option value='phone_only' {{ isset($prefData['preference']['agent_login_via']) && $prefData['preference']['agent_login_via'] == 'phone_only' ? 'selected' : ""}}>{{ __('Phone Only') }}</option>
                                    <option value='email_or_phone' {{ isset($prefData['preference']['agent_login_via']) && $prefData['preference']['agent_login_via'] == 'email_or_phone' ? 'selected' : ""}}>{{ __('Email or Phone') }}</option>
                                </select>
                                <span id="sms-error"></span>
                            </div>
                        </div>

                        <!-- Email Verification -->
                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 control-label f-14 fw-bold text-sm-end" for="agent_verification_mail">{{ __('Email Verification') }}</label>
                            <div class="col-sm-6">
                                <select name="agent_verification_mail" class="select2" id="agent_verification_mail">
                                    <option value="Enabled" {{ isset($prefData['preference']['agent_verification_mail']) && $prefData['preference']['agent_verification_mail'] == 'Enabled' ? 'selected' : '' }}>{{ __('Enabled') }}</option>
                                    <option value="Disabled" {{ isset($prefData['preference']['agent_verification_mail']) && $prefData['preference']['agent_verification_mail'] == 'Disabled' ? 'selected' : '' }}>{{ __('Disabled') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Phone Verification -->
                        <div class="form-group row align-items-center">
                            <label class="col-sm-4 control-label f-14 fw-bold text-sm-end" for="agent_phone_verification">{{ __('Phone Verification') }}</label>
                            <div class="col-sm-6">
                                <select name="agent_phone_verification" class="select2" id="agent_phone_verification">
                                    <option value="Enabled" {{ isset($prefData['preference']['agent_phone_verification']) && $prefData['preference']['agent_phone_verification'] == 'Enabled' ? 'selected' : '' }}>{{ __('Enabled') }}</option>
                                    <option value="Disabled" {{ isset($prefData['preference']['agent_phone_verification']) && $prefData['preference']['agent_phone_verification'] == 'Disabled' ? 'selected' : '' }}>{{ __('Disabled') }}</option>
                                </select>
                                <span id="agent_phone_verification-error"></span>
                            </div>
                        </div>

                        @if (Common::has_permission(auth('admin')->user()->id, 'edit_preference'))
                            <div class="row">
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-theme pull-right f-14" id="preference-submit">
                                        <i class="fa fa-spinner fa-spin d-none"></i> <span
                                            id="preference-submit-text">{{ __('Submit') }}</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.box -->
@endsection

@push('extra_body_scripts')
    <!-- jquery.validate -->
    <script type="text/javascript" src="{{ asset('dist/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script type="text/javascript">
        var checkSmsSettingsUrl = "{{ url(config('adminPrefix').'/settings/check-sms-settings') }}";
    </script>
@endpush
