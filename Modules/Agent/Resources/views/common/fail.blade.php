@extends('agent::common.app')

@section('content')

@include('frontend.layouts.common.alert')
<div class="section-payment webview-fail">
    <div class="payment-main-module">
        <div class="d-flex justify-content-center align-items-center">
            <div class="status-logo">
                <img src="{{ asset(image('', 'fail')) }}">
            </div>
        </div>
        <h3>{{ __('Sorry!') }}</h3>
        @isset($message)
            <p class="text-danger"> {{ $message }}</p>
        @endisset
        <div class="btn-tryagin d-flex justify-content-center align-items-center">
            <a href="{{ url('/agent/dashboard') }}" class="btn btn-lg btn-light">{{ __('Dashboard') }}</a>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('public/user/customs/js/reactwebview.min.js') }}"></script>
@endpush