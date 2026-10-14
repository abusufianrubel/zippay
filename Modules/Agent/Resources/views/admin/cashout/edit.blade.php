@extends('admin.layouts.master')

@section('title', __('Edit Cashout'))

@section('page_content')
<div id="cashoutEdit">
    <div class="box box-default">
        <div class="box-body">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="top-bar-title padding-bottom pull-left">{{ __('Cashout Details') }}</div>
                </div>
                <div>
                    <p class="text-left mb-0 f-18">{{ __('Status') }}: {!! getStatusText($cashout->status) !!}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="my-30">
        <div class="row">
            <!-- Page title start -->
            <div class="col-md-8">
                <div class="box">
                    <div class="box-body">
                        <div class="panel">
                            <div>
                                <div class="p-4">
                                    <!-- User -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="user">{{ __('User') }}</label>
                                        <div class="col-sm-6">
                                            <p id="user" class="form-control-static f-14">{{ getColumnValue($cashout->user) }}</p>
                                        </div>
                                    </div>

                                    <!-- Agent -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="agent">{{ __('Agent') }}</label>
                                        <div class="col-sm-6">
                                            <p id="agent" class="form-control-static f-14">{{ getColumnValue($cashout->agent) }}</p>
                                        </div>
                                    </div>

                                    <!-- TrxID -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="trans-id">{{ __('Transaction ID') }}</label>
                                        <div class="col-sm-6">
                                            <p id="trans-id" class="form-control-static f-14">{{ $cashout->uuid }}</p>
                                        </div>
                                    </div>

                                    <!-- Currency -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="currency">{{ __('Currency') }}</label>
                                        <div class="col-sm-6">
                                            <p id="currency" class="form-control-static f-14">{{ $cashout->currency?->code }}</p>
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="payment-method">{{ __('Payment Method') }}</label>
                                        <div class="col-sm-6">
                                            <p id="payment-method" class="form-control-static f-14">{{ ($cashout->paymentMethod?->name == "Mts") ? settings('name') : $cashout->paymentMethod?->name }}</p>
                                        </div>
                                    </div>

                                    <!-- Created At -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="created-at">{{ __('Date') }}</label>
                                        <div class="col-sm-6">
                                            <p id="created-at" class="form-control-static f-14">{{ dateFormat($cashout->created_at) }}</p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="status">{{ __('Status') }}</label>
                                        <div class="col-sm-6">
                                            <p id="status" class="form-control-static f-14">{{ getStatus($cashout->status) }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <a id="cancel_anchor" class="btn btn-theme-danger me-1 f-14" href="{{ route('admin.agents.cashout.index') }}">{{ __('Back') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <div class="panel">
                            <div>
                                <div class="pt-4">
                                    
                                    <!-- Amount -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-6" for="amount">{{ __('Amount') }}</label>
                                        <div class="col-sm-6">
                                            <p id="amount" class="form-control-static f-14">{{ moneyFormat(optional($cashout->currency)->symbol, formatNumber($cashout->amount, $cashout->currency?->id)) }}</p>
                                        </div>
                                    </div>
                                
                                    @php
                                        $feesTotal = totalFeesWithoutAgentFees($cashout);
                                        $total = $feesTotal + $cashout->amount;
                                    @endphp

                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-6 d-flex justify-content-end" for="feesTotal">{{ __('Fees') }}
                                            <span>
                                                <small class="transactions-edit-fee">
                                                    @if (isset($cashout))
                                                    ({{(formatNumber($cashout->charge_percentage, $cashout->currency?->id))}}% + {{ formatNumber($cashout->charge_fixed, $cashout->currency?->id) }})
                                                    @else
                                                        ({{0}}%+{{0}})
                                                    @endif
                                                </small>
                                            </span>
                                        </label>

                                        <div class="col-sm-6">
                                            <p id="feesTotal" class="form-control-static f-14">{{ moneyFormat(optional($cashout->currency)->symbol, formatNumber($feesTotal, $cashout->currency->id)) }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row total-deposit-feesTotal-space">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-6 d-flex justify-content-end" for="agent-fees">{{ __('Agent Fees') }}</label>
                                        <div class="col-sm-6">
                                            <p id="agent-fees" class="form-control-static f-14">{{ moneyFormat(optional($cashout->currency)->symbol, formatNumber($cashout->agent_percentage, $cashout->currency->id)) }}</p>
                                        </div>
                                    </div>

                                    <hr class="increase-hr-height">

                                    <!-- Total -->
                                    <div class="form-group row total-deposit-space">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-6" for="total">{{ __('Total') }}</label>
                                        <div class="col-sm-6">
                                            <p id="total" class="form-control-static f-14">{{ moneyFormat(optional($cashout->currency)->symbol, formatNumber($total - $cashout->agent_percentage, $cashout->currency?->id)) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('extra_body_scripts')
    <script type="text/javascript">
        "use strict";
        var csvExportUrl = "{{ route('admin.agents.cashout.printcsv') }}";
        var pdfPrintUrl = "{{ route('admin.agents.cashout.printpdf') }}";
    </script>

    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/cashout.min.js') }}"></script>
@endpush
