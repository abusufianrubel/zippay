@extends('admin.pdf.app')

@section('title', __('Cashin List pdf'))

@section('content')
    <div class="mt-30">
        <table class="table">
            <tr class="table-header">
                <td>{{ __('Date') }}</td>
                <td>{{ __('User') }}</td>
                <td>{{ __('Amount') }}</td>
                <td>{{ __('Fees') }}</td>
                <td>{{ __('Total') }}</td>
                <td>{{ __('Currency') }}</td>
                <td>{{ __('Payment Method') }}</td>
                <td>{{ __('Status') }}</td>
            </tr>

            @foreach ($cashins as $cashin)
                <tr class="table-body">
                    <td>{{ dateFormat($cashin->created_at) }}</td>
                    <td>{{ getColumnValue($cashin->user) }}</td>
                    <td>{{ formatNumber($cashin->amount, $cashin->currency_id) }}</td>
                    <td>{{ getFormatFee($cashin) }}</td>
                    <td>{{ '+' . formatNumber($cashin->amount + calculateFee($cashin), $cashin->currency_id) }}</td>
                    <td>{{ optional($cashin->currency)->code }}</td>
                    <td>{{ __('Cash') }}</td>
                    <td>{{ getStatus($cashin->status) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
