@extends('admin.layouts.master')

@section('title', __('Fees & Limits'))

@section('page_content')
<div id="feesLimits">
    <div class="box box-default">
        <div class="box-body ps-2">
            <div class="row">
                <div class="col-md-8">
                    <div class="top-bar-title padding-bottom">{{ __('Fees Limits') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border ps-3">
                    <h3 class="box-title underline">{{ __('Transaction Type') }} </h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked flex-column">
                        <li class="{{ $transactionType->id == Cashin ? 'active' : '' }}">
                            <a href="{{ route('admin.agents.feeslimits.index', ['type' => 'cashin']) }}">{{ __('Cash In') }}</a>
                        </li>
                        <li class="{{ $transactionType->id == Cashout ? 'active' : '' }}">
                            <a href="{{ route('admin.agents.feeslimits.index', ['type' => 'cashout']) }}">{{ __('Cash Out') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">{{ __('Fees & Limits Settings') }}</h3>
                </div>

                <form action="{{ route('admin.agents.feeslimits.store') }}" method="post" id="agentFeesLimitForm">
                    @csrf
                    <input type="hidden" value="{{ $transactionType->id }}" name="transaction_type" id="transaction_type">
                    <input type="hidden" value="{{ strtolower($transactionType->name) }}" name="type" id="type">

                    <div class="box-body">
                        <div class="panel-group" id="accordion">
                            @foreach ($currencies as $key => $currency)
                                <input type="hidden" name="currency_id[]" value="{{ $currency->id }}">
                                @php
                                    $feesLimits = $currency->fees_limit[0] ?? null;
                                @endphp

                                <div class="panel panel-default">
                                    <div class="panel-heading" data-bs-toggle="collapse" data-bs-target="#collapse{{ $currency->id }}" aria-expanded="false" aria-controls="collapse{{ $currency->id }}">
                                        <h4 class="panel-title">
                                            <a href="javascript:void(0)">{{ $currency->code }}</a>
                                            <span class="float-end">{!! $currency->default == 1 ? '<span class="label label-warning">Default Currency</span>' : ''  !!}</span>
                                        </h4>
                                    </div>
                                    <div id="collapse{{ $currency->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <!-- has_transaction -->
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label f-14 fw-bold text-sm-end default_currency_label" for="has_transaction_{{ $currency->id }}">{{ __('Is Activated') }}</label>
                                                <div class="col-sm-5">
                                                    <label class="checkbox-container">
                                                        <input type="checkbox" class="has_transaction f-14" data-currency_id="{{ $currency->id }}" name="has_transaction[{{ $currency->id }}]" value="Yes" {{ isset($feesLimits->has_transaction) && $feesLimits->has_transaction == 'Yes' ? 'checked' : '' }} id="has_transaction_{{ $currency->id }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="mb-0 default_currency_side_text f-14">{{ __('Default currency is always active') }}</p>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <!-- Minimum Limit -->
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label f-14 fw-bold text-sm-end mt-11" for="min_limit_{{ $currency->id }}">{{ __('Minimum Limit') }}</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control f-14 min_limit" name="min_limit[{{ $currency->id }}]" type="text" value="{{ isset($feesLimits->min_limit) ? number_format((float) $feesLimits->min_limit, $preference, '.', '') : number_format((float) 1.00, $preference, '.', '') }}" id="min_limit_{{ $currency->id }}" onkeypress="return isNumberOrDecimalPointKey(this, event);" oninput="restrictNumberToPrefdecimalOnInput(this)" {{ isset($feesLimits->has_transaction) && $feesLimits->has_transaction == 'Yes' ? '' : 'readonly' }}>
                                                    <small class="form-text text-muted f-12"><strong>*{{ __('Allowed upto 2 decimal places.') }}</strong></small>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="mb-0 f-14 mt-11">{{ __('If not set, minimum limit is 1.00') }}</p>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <!-- Maximum Limit -->
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label f-14 fw-bold text-sm-end mt-11" for="max_limit_{{ $currency->id }}">{{ __('Maximum Limit') }}</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control f-14 max_limit" name="max_limit[{{ $currency->id }}]" type="text" value="{{ isset($feesLimits->max_limit) ? number_format((float) $feesLimits->max_limit, $preference, '.', '') : '' }}" id="max_limit_{{ $currency->id }}" onkeypress="return isNumberOrDecimalPointKey(this, event);" oninput="restrictNumberToPrefdecimalOnInput(this)" {{ isset($feesLimits->has_transaction) && $feesLimits->has_transaction == 'Yes' ? '' : 'readonly' }}>
                                                    <small class="form-text text-muted f-12"><strong>*{{ __('Allowed upto 2 decimal places.') }}</strong></small>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="mb-0 f-14 mt-11">{{ __('If not set, maximum limit is infinity') }}</p>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <!-- Charge Percentage -->
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label f-14 fw-bold text-sm-end mt-11" for="charge_percentage_{{ $currency->id }}">{{ __('Charge Percentage') }}</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control f-14 charge_percentage" name="charge_percentage[{{ $currency->id }}]" type="text" value="{{ isset($feesLimits->charge_percentage) ? number_format((float) $feesLimits->charge_percentage, $preference, '.', '') : number_format((float) 0.0, $preference, '.', '') }}" id="charge_percentage_{{ $currency->id }}" onkeypress="return isNumberOrDecimalPointKey(this, event);" oninput="restrictNumberToPrefdecimalOnInput(this)" {{ isset($feesLimits->has_transaction) && $feesLimits->has_transaction == 'Yes' ? '' : 'readonly' }}>
                                                    <small class="form-text text-muted f-12"><strong>*{{ __('Allowed upto 2 decimal places.') }}</strong></small>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="mb-0 f-14 mt-11">{{ __('If not set, charge percentage is 0.00') }}</p>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <!-- Charge Fixed -->
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label f-14 fw-bold text-sm-end mt-11" for="charge_fixed_{{ $currency->id }}">{{ __('Charge Fixed') }}</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control f-14 charge_fixed" name="charge_fixed[{{ $currency->id }}]" type="text" value="{{ isset($feesLimits->charge_fixed) ? number_format((float) $feesLimits->charge_fixed, $preference, '.', '') : number_format((float) 0.0, $preference, '.', '') }}" id="charge_fixed_{{ $currency->id }}" onkeypress="return isNumberOrDecimalPointKey(this, event);" oninput="restrictNumberToPrefdecimalOnInput(this)" {{ isset($feesLimits->has_transaction) && $feesLimits->has_transaction == 'Yes' ? '' : 'readonly' }}>
                                                    <small class="form-text text-muted f-12"><strong>*{{ __('Allowed upto 2 decimal places.') }}</strong></small>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="mb-0 f-14 mt-11">{{ __('If not set, charge fixed is 0.00') }}</p>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-theme f-14" id="agentFeesLimitsUpdate">
                                <i class="fa fa-spinner fa-spin d-none"></i> <span id="agentFeesLimitsUpdateText">{{ __('Update') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('extra_body_scripts')
    @include('common.restrict_number_to_pref_decimal')
    @include('common.restrict_character_decimal_point')

    <script>
        "use strict";
        var type = $('#type').val();
        var decimal_format = "{{ preference('decimal_format_amount', 2) }}";
        var updatingText = "{{ __('Updating...') }}";
    </script>
    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/feeslimit.min.js') }}"></script>
@endpush
