@extends('admin.layouts.master')

@section('title', __('Agent Deposit'))

@section('page_content')
    <span id="deposit">
        <div class="row ">
            <div class="col-md-4">
                @if (!empty($agent->status))
                    <h3>{{ getColumnValue($agent) }} {!! getStatusLabel($agent->status) !!}</h3>
                @endif
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="pull-right">
                    <a href="{{ route('admin.agents.deposit.create', $agent->id) }}" type="button" class="btn btn-theme active mt-20">{{ __('Deposit') }}</a>
                </div>
            </div>
        </div>

        <div class="box mt-20">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.agents.deposit.confirm') }}" method="post" id="agentDepositForm">
                            @csrf
                            <input type="hidden" name="payment_method" value="{{ $paymentMethod->id }}">
                            <input type="hidden" name="agent_id" id="agent_id" value="{{ $agent->id }}">
                            <input type="hidden" name="percentage_fee" id="percentage_fee">
                            <input type="hidden" name="fixed_fee" id="fixed_fee">
                            <input type="hidden" name="fee" class="total_fees">

                            <div class="row">
                                <!-- Currency List -->
                                <div class="col-md-4">
                                    <div class="form-group f-14">
                                        <label class="mb-1" for="currency_id">{{ __('Currency') }}</label>
                                        <select class="form-control select2 f-14 wallet" name="currency_id" id="currency_id">
                                            @foreach ($activeCurrencyList as $currency)
                                                <option data-type="{{ $currency['type'] }}" value="{{ $currency['id'] }}">{{ $currency['code'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small id="walletlHelp" class="form-text text-muted f-12">{{ __('Fee') }}(<span class="pFees">0</span>%+<span class="fFees">0</span>), {{ __('Total Fee:') }}<span class="total_fees">0.00</span></small>
                                </div>

                                <!-- Amount -->
                                <div class="col-md-4">
                                    <div class="form-group f-14">
                                        <label class="mb-1" for="amount">{{ __('Deposit Amount') }}</label>
                                        <input type="text" class="form-control f-14 amount" name="amount" id="amount" onkeypress="return isNumberOrDecimalPointKey(this, event);" oninput="restrictNumberToPrefdecimalOnInput(this)" placeholder="{{ __('Enter Amount') }}">
                                        <span class="amountLimit limit-danger"></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <a href="{{ route('admin.agents.agents.index', $agent->id) }}" class="btn btn-theme-danger"><span class="f-14"><i class="fa fa-angle-left"></i>&nbsp;{{ __('Back') }}</span></a>
                                    <button type="submit" class="btn btn-theme float-end" id="depositCreateSubmitBtn">
                                        <i class="fa fa-spinner fa-spin d-none"></i>
                                        <span class="f-14" id="depositCreateSubmitBtnText">{{ __('Deposit') }} &nbsp;<i class="fa fa-angle-right"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </span>
@endsection

@push('extra_body_scripts')

    @include('common.restrict_number_to_pref_decimal')
    @include('common.restrict_character_decimal_point')
    
    <!-- jquery.validate -->
    <script type="text/javascript" src="{{ asset('dist/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script type="text/javascript">
        'use strict';
        var ajaxUrl = "{{ route('admin.agents.deposit.feeslimit.check') }}";
        var agentId = "{{ $agent->id }}";
        var transactionTypeId = "{{ Deposit }}";
        var submitButtonText = "{{ __('Submitting...') }}";
    </script>
    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/admin_agent.min.js') }}"></script>
@endpush
