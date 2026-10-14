@extends('admin.layouts.master')

@section('title', __('Create Agent Package'))

@section('page_content')
    <div class="row" id="packageCreate">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Create New Package') }}</h3>
                </div>
                <form method="post" action="{{ route('admin.agents.packages.store') }}" class="form-horizontal" id="packageCreateForm">
                    @csrf
                    <div class="box-body">
                        <!-- Name -->
                        <div class="form-group row">
                            <label class="col-sm-3 control-label require mt-11 text-sm-end f-14 fw-bold" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control f-14" id="name" value="{{ old('name') }}" placeholder="{{ __('Enter :x', ['x' => __('name')]) }}" required>
                                @if ($errors->has('name'))
                                    <span class="error">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group row">
                            <label class="col-sm-3 control-label require mt-11 text-sm-end f-14 fw-bold" for="description">{{ __('Description') }}</label>
                            <div class="col-sm-6">
                                <textarea type="text" name="description" rows="3" class="form-control f-14" id="description" placeholder="{{ __('Enter :x', ['x' => __('description')]) }}" required>{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="error">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Commission -->
                        <div class="form-group row">
                            <label class="col-sm-3 control-label require mt-11 text-sm-end f-14 fw-bold" for="commission">{{ __('Commission') }} (%)</label>
                            <div class="col-sm-6">
                                <input type="text" name="commission" class="form-control f-14" value="{{ old('commission') }}" placeholder="{{ __('Enter new commission') }}" id="commission" onkeypress="return isNumberOrDecimalPointKey(this, event);" oninput="restrictNumberToPrefdecimalOnInput(this)" required>
                                @if ($errors->has('commission'))
                                    <span class="error">
                                        <strong class="text-danger">{{ $errors->first('commission') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Default -->
                        <div class="form-group row">
                            <label class="col-sm-3 control-label require mt-11 text-sm-end f-14 fw-bold" for="default">{{ __('Default') }}</label>
                            <div class="col-sm-6">
                                <select class="select2 form-control f-14" name="is_default" id="default" required>
                                    <option value='No'>{{ __('No') }}</option>
                                    <option value='Yes'>{{ __('Yes') }}</option>
                                </select>
                                @if ($errors->has('is_default'))
                                    <span class="error">
                                        <strong class="text-danger">{{ $errors->first('is_default') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group row">
                            <div class="col-sm-6 offset-md-3">
                                <a class="btn btn-theme-danger f-14 me-1" href="{{ route('admin.agents.packages.index') }}" id="packageCreateCancel">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-theme f-14 float-right" id="packageCreateSubmitBtn">
                                    <i class="fa fa-spinner fa-spin d-none"></i>
                                    <span id="packageCreateSubmitBtnText">{{ __('Create') }}</span>
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

    @include('common.restrict_number_to_pref_decimal')
    @include('common.restrict_character_decimal_point')

    <script type="text/javascript" src="{{ asset('public/dist/plugins/html5-validation/validation.min.js') }}"></script>

    <script>
        "use strict";
        var submitButtonText = "{{ __('Submitting...') }}";
    </script>
    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/agent_packages.min.js') }}"></script>
@endpush
