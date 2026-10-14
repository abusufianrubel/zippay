@extends('admin.layouts.master')

@section('title', __('Agent Deposit'))

@section('head_style')
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Agent/Resources/assets/css/agent.min.css') }}">
@endsection

@section('page_content')
    <span class="section" id="depositConfirm">
        <div class="row">
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
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-body f-14">
                            <h3 class="text-center f-24"><strong>{{ __('Details') }}</strong></h3>
                            <div class="row">
                                <div class="col-md-6 pull-left">{{ __('Amount') }}</div>
                                <div class="col-md-6  text-end">
                                    <strong>{{ moneyFormat($transInfo['currSymbol'], isset($transInfo['amount']) ? formatNumber($transInfo['amount'], $transInfo['currency_id']) : 0.0) }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pull-left">{{ __('Fee') }}</div>
                                <div class="col-md-6 text-end">
                                    <strong>{{ moneyFormat($transInfo['currSymbol'], isset($transInfo['fee']) ? formatNumber($transInfo['fee'], $transInfo['currency_id']) : 0.0) }}</strong>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6 pull-left"><strong>{{ __('Total') }}</strong></div>
                                <div class="col-md-6 text-end">
                                    <strong>{{ moneyFormat($transInfo['currSymbol'], isset($transInfo['totalAmount']) ? formatNumber($transInfo['totalAmount'], $transInfo['currency_id']) : 0.0) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div>
                        <div class="float-start">
                            <a href="{{ route('admin.agents.deposit.create', $agent->id)}}" class="admin-user-deposit-confirm-back-link">
                                <button class="btn btn-theme-danger admin-user-deposit-confirm-back-btn">
                                    <strong class="f-14"><i class="fa fa-angle-left"></i>&nbsp;{{ __('Back') }}</strong>
                                </button>
                            </a>
                        </div>
                        <div class="float-end">
                            <form action="{{ route('admin.agents.deposit.store') }}" method="post" id="agentDepositConfirmForm">
                                @csrf
                                <input type="hidden" name="amount" id="amount" value="{{ $transInfo['totalAmount'] }}">
                                <input type="hidden" name="agent_id" id="agent_id" value="{{ $agent->id }}">

                                <button type="submit" class="btn btn-theme" id="agentDepositConfirmSubmitBtn">
                                    <i class="fa fa-spinner fa-spin d-none"></i>
                                    <span id="agentDepositConfirmSubmitBtnText">
                                        <strong class="f-14">{{ __('Confirm') }}&nbsp; <i class="fa fa-angle-right"></i></strong>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>

@endsection

@push('extra_body_scripts')
    <script type="text/javascript">
        'use strict';
        var ajaxUrl = "{{ route('admin.agents.deposit.feeslimit.check') }}";
        var agentId = "{{ $agent->id }}";
        var transactionTypeId = "{{ Deposit }}";
        var submitButtonText = "{{ __('Confirming...') }}";
    </script>
    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/admin_agent.min.js') }}"></script>
@endpush
