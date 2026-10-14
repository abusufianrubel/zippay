@extends('admin.pdf.app')

@section('title', __('Cashout List pdf'))

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

            @foreach ($cashouts as $cashout)
                <tr class="table-body">
                    <td>{{ dateFormat($cashout->created_at) }}</td>
                    <td>{{ getColumnValue($cashout->user) }}</td>
                    <td>{{ formatNumber($cashout->amount, $cashout->currency_id) }}</td>
                    <td>{{ getFormatFee($cashout) }}</td>
                    <td>{{ '+' . formatNumber($cashout->amount + calculateFee($cashout), $cashout->currency_id) }}</td>
                    <td>{{ optional($cashout->currency)->code }}</td>
                    <td>{{ __('Cash') }}</td>
                    <td>{{ getStatus($cashout->status) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
