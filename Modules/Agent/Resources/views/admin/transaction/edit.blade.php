@extends('admin.layouts.master')

@section('title', __('Edit Transaction'))

@section('page_content')
<div class="box box-default">
	<div class="box-body">
		<div class="d-flex justify-content-between">
			<div>
				@if ($transaction->status)
					<p class="text-left mb-0 f-18">{{ __('Status') }} :
                    @php
                        $transactionTypes = getPaymoneySettings('transaction_types')['web'];
                        if (in_array($transaction->transaction_type_id, $transactionTypes['all'])) {
                            echo getStatusText($transaction->status);
                        }
                    @endphp
                    </p>
				@endif
			</div>
		</div>
	</div>
</div>
<section class="min-vh-100">
    <div class="my-30">
        <form action="{{ url(\Config::get('adminPrefix').'/transactions/update/'. $transaction->id) }}" class="form-horizontal" id="transactions_form" method="POST">
            {{ csrf_field() }}
            <div class="row f-14">
                <!-- Page title start -->
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-body">
                            <div class="panel">
                                <div>
                                    <div class="p-4 rounded">

                                        <!-- User -->
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3 fw-bold text-sm-end" for="user">{{ __('User') }}</label>
                                            <div class="col-sm-9">
                                                <p id="user" class="form-control-static">{{ !empty($transaction->user_id) ? getColumnValue($transaction->user) : '' }}</p>
                                            </div>
                                        </div>

                                        <!-- Agent -->
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3 fw-bold text-sm-end" for="agent">{{ __('Agent') }}</label>
                                            <div class="col-sm-9">
                                                <p id="agent" class="form-control-static">{{ !empty($transaction->agent_id) ? getColumnValue($transaction->agent) : '' }}</p>
                                            </div>
                                        </div>

                                        <!-- Transaction ID -->
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3 fw-bold text-sm-end" for="transactions-uuid">{{ __('Transaction ID') }}</label>
                                            <div class="col-sm-9">
                                                <p id="transactions-uuid" class="form-control-static">{{ getColumnValue($transaction, 'uuid') }}</p>
                                            </div>
                                        </div>

                                        <!-- Type -->
                                        @if ($transaction->transaction_type_id)
                                            <div class="form-group row">
                                                <label class="control-label col-sm-3 fw-bold text-sm-end" for="type">{{ __('Type') }}</label>
                                                <div class="col-sm-9">
                                                    <p id="type" class="form-control-static">{{ str_replace('_', ' ', $transaction?->transaction_type?->name) }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Currency -->
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3 fw-bold text-sm-end" for="currency">{{ __('Currency') }}</label>
                                            <div class="col-sm-9">
                                                <p id="currency" class="form-control-static">{{ getColumnValue($transaction->currency, 'code') }}</p>
                                            </div>
                                        </div>

                                        <!-- Payment Method -->
                                        @if (isset($transaction->payment_method_id))
                                            <div class="form-group row">
                                                <label class="control-label col-sm-3 fw-bold text-sm-end" for="payment-method">{{ __('Payment Method') }}</label>
                                                <div class="col-sm-9">
                                                    <p id="payment-method" class="form-control-static">{{ ($transaction?->payment_method?->name == 'Mts') ? settings('name') : $transaction->payment_method?->name }}</p>
                                                </div>
                                            </div>
                                        @endif

                                         
                                        @php
                                            $transactionA = \App\Models\Transaction::where('uuid', $transaction->uuid)->first();
                                        @endphp

                                        @if (isset($transactionA->payment_status))
                                            <div class="form-group row">
                                                <label class="control-label col-sm-3 fw-bold text-sm-end" for="payment-status">{{ __('Payment Status') }}</label>
                                                <div class="col-sm-9">
                                                    <p id="payment-status" class="form-control-static">{!! getStatusText($transactionA->payment_status) !!}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Created at date -->
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3 fw-bold text-sm-end" for="created-at">{{ __('Date') }}</label>
                                            <div class="col-sm-9">
                                                <p id="created-at" class="form-control-static">{{ dateFormat(getColumnValue($transaction, 'created_at')) }}</p>
                                            </div>
                                        </div>

                                        @if ($transaction->status)
                                            <div class="form-group row">
                                                <label class="control-label col-sm-3 fw-bold text-sm-end" for="status">{{ __('Change Status') }}</label>
                                                <div class="col-sm-6">
                                                    <p class="form-control-static"><span class="label label-danger space-none" id="status">{{ str_replace('_', ' ', $transaction->transaction_type?->name) }}{{ __(' Status Cannot Be Changed') }}</span></p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3">
                                                <a id="cancel_anchor" class="btn btn-theme-danger me-1 f-14" href="{{ url(config('adminPrefix').'/transactions') }}">{{ __('Back') }}</a>
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
                                    <div class="pt-4 rounded">
                                        @if ($transaction->subtotal)
                                            <div class="form-group row">
                                                <label class="control-label col-sm-6 fw-bold text-sm-end" for="subtotal">{{ __('Amount') }}</label>
                                                <div id="subtotal" class="col-sm-6">
                                                    {{ moneyFormat(optional($transaction->currency)->symbol, formatNumber($transaction->subtotal, $transaction->currency_id)) }}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label class="control-label col-sm-6 d-flex fw-bold justify-content-end" for="fee">{{ __('Fees') }}
                                                <span>
                                                    <small class="transactions-edit-fee">
                                                        @if (isset($transaction))
                                                            ({{(formatNumber($transaction->percentage, $transaction->currency_id))}}% + {{ formatNumber($transaction->charge_fixed, $transaction->currency_id)}})
                                                        @else
                                                            ({{0}}%+{{0}})
                                                        @endif
                                                    </small>
                                                </span>
                                            </label>
                                            <div class="col-sm-6">
                                                <p id="fee" class="form-control-static">{{ moneyFormat(optional($transaction->currency)->symbol, formatNumber(calculateFee($transaction), $transaction->currency_id)) }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row total-deposit-feesTotal-space">
                                            <label class="control-label col-sm-6 d-flex fw-bold justify-content-end" for="agent-commission">{{ __('Agent Commission') }}</label>
                                            <div class="col-sm-6">
                                                <p id="agent-commission" class="form-control-static">{{ moneyFormat(optional($transaction->currency)->symbol, formatNumber($transaction->agent_percentage, $transaction->currency_id)) }}</p>
                                            </div>
                                        </div>

                                        <hr class="increase-hr-height">

                                        @if ($transaction->total)
                                            <div class="form-group row total-deposit-space">
                                                <label class="control-label col-sm-6 fw-bold text-sm-end" for="total">{{ __('Total') }}</label>
                                                <div class="col-sm-6">
                                                    <p id="total" class="form-control-static">{{ moneyFormat(optional($transaction->currency)->symbol, str_replace("-",'',formatNumber($transaction->total, $transaction->currency_id)) ) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
