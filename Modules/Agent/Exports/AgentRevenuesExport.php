<?php

namespace Modules\Agent\Exports;

use Maatwebsite\Excel\Concerns\{FromQuery, 
    WithStyles, 
    WithMapping, 
    WithHeadings, 
    ShouldAutoSize
};
use Modules\Agent\Services\AgentPaymentService;

class AgentRevenuesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function query()
    {
        $from     = (isset(request()->startfrom) && !empty(request()->startfrom)) ? setDateForDb(request()->startfrom) : null;
        $to       = (isset(request()->endto) && !empty(request()->endto)) ? setDateForDb(request()->endto) : null;
        $type     = isset(request()->type) ? request()->type : null;
        $currency = isset(request()->currency) ? request()->currency : null;
        $agent    = isset(request()->user_id) ? request()->user_id : null;

        return (new AgentPaymentService())->getAgentRevenuesList($from, $to, $currency, $type, $agent)->orderBy('transactions.id', 'desc');
    }

    public function headings(): array
    {
        return [
            __('Date'),
            __('Transaction Type'),
            __('Agent Comission'),
            __('Currency'),
        ];
    }

    public function map($revenue): array
    {
        return [
            dateFormat($revenue->created_at),
            isset($revenue->transaction_type?->name) ? str_replace('_', ' ', $revenue->transaction_type?->name) : '',
            formatNumber($revenue->agent_percentage, $revenue->currency_id),
            isset($revenue->currency?->code) ? $revenue->currency?->code : '',
        ];
    }

    public function styles($revenue)
    {
        $revenue->getStyle('A:B')->getAlignment()->setHorizontal('center');
        $revenue->getStyle('C:D')->getAlignment()->setHorizontal('center');
        $revenue->getStyle('E:F')->getAlignment()->setHorizontal('center');
        $revenue->getStyle('1')->getFont()->setBold(true);
    }
}
