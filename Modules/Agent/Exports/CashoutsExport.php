<?php

namespace Modules\Agent\Exports;

use Modules\Agent\Entities\Cashout;
use Maatwebsite\Excel\Concerns\{FromQuery, 
    WithStyles, 
    WithMapping, 
    WithHeadings, 
    ShouldAutoSize
};

class CashoutsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function query()
    {
        $from     = (isset(request()->startfrom) && !empty(request()->startfrom)) ? setDateForDb(request()->startfrom) : null;
        $to       = (isset(request()->endto) && !empty(request()->endto)) ? setDateForDb(request()->endto) : null;
        $currency = isset(request()->currency) ? request()->currency : null;
        $status   = isset(request()->status) ? request()->status : null;
        $user     = isset(request()->user_id) ? request()->user_id : null;

        return Cashout::filterTransactions($from, $to, $currency, $status, $user, $user)->orderBy('id', 'desc');
    }

    public function headings(): array
    {
        return [
            __('Date'),
            __('User'),
            __('Amount'),
            __('Fees'),
            __('Total'),
            __('Currency'),
            __('Payment Method'),
            __('Status'),
        ];
    }

    public function map($cashins): array
    {
        return [
            dateFormat($cashins->created_at),
            getColumnValue($cashins->user),
            formatNumber($cashins->amount, $cashins->currency_id),
            ($cashins->charge_percentage == 0) && ($cashins->charge_fixed == 0) ? '-' : formatNumber($cashins->charge_percentage + $cashins->charge_fixed, $cashins->currency_id),
            "+" . formatNumber($cashins->amount + ($cashins->charge_percentage + $cashins->charge_fixed), $cashins->currency_id),
            $cashins->currency?->code,
            "Cash",
            getStatus($cashins->status)
        ];
    }

    public function styles($cashins)
    {
        $cashins->getStyle('A:B')->getAlignment()->setHorizontal('center');
        $cashins->getStyle('C:D')->getAlignment()->setHorizontal('center');
        $cashins->getStyle('E:F')->getAlignment()->setHorizontal('center');
        $cashins->getStyle('G:H')->getAlignment()->setHorizontal('center');
        $cashins->getStyle('1')->getFont()->setBold(true);
    }
}
