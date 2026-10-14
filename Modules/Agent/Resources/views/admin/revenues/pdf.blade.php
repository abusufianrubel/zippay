@extends('admin.pdf.app')

@section('title', __('Revenue List pdf'))

@section('content')
    <div class="mt-30">
        <table class="table">
            <tr class="table-header">
                <td>{{ __('Date') }}</td>
                <td>{{ __('Transaction Type') }}</td>
                <td>{{ __('User') }}</td>
                <td>{{ __('Amount') }}</td>
                <td>{{ __('Fees') }}</td>
                <td>{{ __('Agent Comission') }}</td>
                <td>{{ __('Total') }}</td>
                <td>{{ __('Currency') }}</td>
                <td>{{ __('Payment Method') }}</td>
                <td>{{ __('Status') }}</td>
            </tr>
            

            @foreach ($revenues as $revenue)
                <tr class="table-body">
                    <td>{{ dateFormat($revenue->created_at) }}</td>
                    <td>
                        {{ isset($revenue->transaction_type?->name) ? 
                            str_replace('_', ' ', $revenue->transaction_type?->name) : '' }}
                    </td>
                    <td>{{ getColumnValue($revenue->user) }}</td>
                    <td>{{ formatNumber($revenue->subtotal, $revenue->currency_id) }}</td>
                    <td>{{ getFormatFee($revenue) }}</td>
                    <td>{{ formatNumber($revenue->agent_percentage, $revenue->currency_id) }}</td>
                    <td>{{ '+' . formatNumber($revenue->subtotal + totalFees($revenue), $revenue->currency_id) }}</td>
                    <td>{{ optional($revenue->currency)->code }}</td>
                    <td>{{ __('Cash') }}</td>
                    <td>{{ getStatus($revenue->status) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
