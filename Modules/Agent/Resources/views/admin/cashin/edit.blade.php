@extends('admin.layouts.master')

@section('title', __('Edit Cashin'))

@section('page_content')
<div id="cashinEdit">
    <div class="box box-default">
        <div class="box-body">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="top-bar-title padding-bottom pull-left">{{ __('Cashin Details') }}</div>
                </div>
                <div>
                    <p class="text-left mb-0 f-18">{{ __('Status') }} : {!! getStatusText($cashin->status) !!}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="my-30">
        <div class="form-horizontal row">

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
                                            <p id="user" class="form-control-static f-14">{{ getColumnValue($cashin->user) }}</p>
                                        </div>
                                    </div>

                                    <!-- Agent -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="agent">{{ __('Agent') }}</label>
                                        <div class="col-sm-6">
                                            <p id="agent" class="form-control-static f-14">{{ getColumnValue($cashin->agent) }}</p>
                                        </div>
                                    </div>

                                    <!-- TrxID -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="trans-id">{{ __('Transaction ID') }}</label>
                                        <div class="col-sm-6">
                                            <p id="trans-id" class="form-control-static f-14">{{ $cashin->uuid }}</p>
                                        </div>
                                    </div>

                                    <!-- Currency -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="currency">{{ __('Currency') }}</label>
                                        <div class="col-sm-6">
                                            <p id="currency" class="form-control-static f-14">{{ $cashin->currency?->code }}</p>
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="payment-method">{{ __('Payment Method') }}</label>
                                        <div class="col-sm-6">
                                            <p id="payment-method" class="form-control-static f-14">{{ ($cashin->paymentMethod?->name == "Mts") ? settings('name') : $cashin->paymentMethod?->name }}</p>
                                        </div>
                                    </div>

                                    <!-- Created At -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="created-at">{{ __('Date') }}</label>
                                        <div class="col-sm-6">
                                            <p id="created-at" class="form-control-static f-14">{{ dateFormat($cashin->created_at) }}</p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-3" for="status">{{ __('Status') }}</label>
                                        <div class="col-sm-6">
                                            <p id="status" class="form-control-static f-14">{{ getStatus($cashin->status) }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <a id="cancel_anchor" class="btn btn-theme-danger me-1 f-14" href="{{ route('admin.agents.cashin.index') }}">{{ __('Back') }}</a>
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
                                            <p id="amount" class="form-control-static f-14">{{ moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->amount, $cashin->currency?->id)) }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-6 d-flex justify-content-end" for="feesTotal">{{ __('Agent Fees') }}</label>
                                        <div class="col-sm-6">
                                            <p id="feesTotal" class="form-control-static f-14">{{ moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->agent_percentage, $cashin->currency->id)) }}</p>
                                        </div>
                                    </div>
                                
                                    @php
                                        $feesTotal = totalFees($cashin);
                                        $total = $feesTotal + $cashin->amount;
                                    @endphp

                                    <div class="form-group row total-deposit-feesTotal-space">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-6 d-flex justify-content-end" for="charge">{{ __('Fees') }}
                                            <span>
                                                <small class="transactions-edit-fee">
                                                    @if (isset($cashin))
                                                    ({{(formatNumber($cashin->charge_percentage, $cashin->currency?->id))}}% + {{ formatNumber($cashin->charge_fixed, $cashin->currency?->id) }})
                                                    @else
                                                        ({{0}}%+{{0}})
                                                    @endif
                                                </small>
                                            </span>
                                        </label>

                                        <div class="col-sm-6">
                                            <p id="charge" class="form-control-static f-14">{{ moneyFormat(optional($cashin->currency)->symbol, formatNumber($feesTotal  - $cashin->agent_percentage, $cashin->currency->id)) }}</p>
                                        </div>
                                    </div>

                                    <hr class="increase-hr-height">

                                    <!-- Total -->
                                    <div class="form-group row total-deposit-space">
                                        <label class="control-label fw-bold f-14 text-sm-end col-sm-6" for="total">{{ __('Total') }}</label>
                                        <div class="col-sm-6">
                                            <p id="total" class="form-control-static f-14">{{ moneyFormat(optional($cashin->currency)->symbol, formatNumber($cashin->total, $cashin->currency?->id)) }}</p>
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
    <script>
        "use strict";
        var csvExportUrl = "{{ route('admin.agents.cashin.printcsv') }}";
        var pdfPrintUrl = "{{ route('admin.agents.cashin.printpdf') }}";
    </script>
    <script src="{{ asset('Modules/Agent/Resources/assets/js/admin/cashin.min.js') }}"></script>
@endpush
