@php
    $methodData = isset($currencyPaymentMethod->method_data) ? json_decode($currencyPaymentMethod->method_data) : null;
@endphp

<!-- FedaPay Public Key -->
<div class="form-group row mb-3">
    <label class="col-sm-3 control-label text-end f-14 fw-bold" for="fedapay_public_key">{{ __('Public Key') }}</label>
    <div class="col-sm-6">
        <input class="form-control f-14" name="public_key" type="text" value="{{ isset($methodData->public_key) ? $methodData->public_key : '' }}" id="fedapay_public_key">
        @if ($errors->has('public_key'))
            <span class="help-block">
                <strong>{{ $errors->first('public_key') }}</strong>
            </span>
        @endif
    </div>
</div>

<!-- FedaPay Secret Key -->
<div class="form-group row mb-3">
    <label class="col-sm-3 control-label text-end f-14 fw-bold" for="fedapay_secret_key">{{ __('Secret Key') }}</label>
    <div class="col-sm-6">
        <input class="form-control f-14" name="secret_key" type="text" value="{{ isset($methodData->secret_key) ? $methodData->secret_key : '' }}" id="fedapay_secret_key">
        @if ($errors->has('secret_key'))
            <span class="help-block">
                <strong>{{ $errors->first('secret_key') }}</strong>
            </span>
        @endif
    </div>
</div>

<!-- FedaPay Mode (Sandbox/Live) -->
<div class="form-group row mb-3">
    <label class="col-sm-3 control-label text-end f-14 fw-bold" for="fedapay_mode">{{ __('Mode') }}</label>
    <div class="col-sm-6">
        <select class="form-control f-14" name="mode" id="fedapay_mode">
            <option value="sandbox" {{ isset($methodData->mode) && $methodData->mode == 'sandbox' ? 'selected' : '' }}>{{ __('Sandbox') }}</option>
            <option value="live" {{ isset($methodData->mode) && $methodData->mode == 'live' ? 'selected' : '' }}>{{ __('Live') }}</option>
        </select>
    </div>
</div>