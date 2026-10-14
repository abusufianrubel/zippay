@extends('admin.layouts.master')

@section('title', __('Agent Deposit'))

@section('head_style')
    <link rel="stylesheet" type="text/css" href="{{ asset('Modules/Agent/Resources/assets/css/agent.min.css') }}">
@endsection

@section('page_content')
    <span class="section" id="deposit">
        <div class="row">
            <div class="col-md-4">
                @if (!empty($agent->status))
                    <h3>{{ getColumnValue($agent) }} {!! getStatusLabel($agent->status) !!}</h3>
                @endif
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="pull-right">
                    <a href="{{ route('admin.agents.deposit.create', $agent->id) }}" type="button" class="btn btn-theme active mt-20 f-14">{{ __('Deposit') }}</a>
                </div>
            </div>
        </div>

        <div class="box mt-20">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">
                                    <div class="confirm-btns"><i class="fa fa-check"></i></div>
                                </div>
                                <div class="text-center">
                                    <div class="f-24 text-success mt-2"> {{ __('Success') }}</div>
                                </div>
                                <div class="text-center f-14 mt-2">
                                    <p class="mb-0"><strong> {{ __('Deposit Completed Successfully') }}</strong></p>
                                </div>
                                <h5 class="text-center f-14 mt-1">{{ __('Deposit Amount') }} :{{ moneyFormat($transInfo['currSymbol'], formatNumber($transInfo['subtotal'], $transInfo['currency_id'])) }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('admin.agents.deposit.printpdf', $transInfo['id']) }}" target="_blank" class="btn btn-theme-danger"><strong class="f-14">{{ __('Print') }}</strong></a>
                            </div>
                            <a href="{{ route('admin.agents.deposit.create', $agent->id) }}" class="btn btn-theme"><strong class="f-14">{{ __('Deposit again') }}</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>
@endsection
