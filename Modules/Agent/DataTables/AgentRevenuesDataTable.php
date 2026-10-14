<?php

namespace Modules\Agent\DataTables;

use App\Http\Helpers\Common;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Services\DataTable;
use Modules\Agent\Services\AgentPaymentService;

class AgentRevenuesDataTable extends DataTable
{
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('created_at', function ($revenue)
            {
                return dateFormat($revenue->created_at);
            })
            ->editColumn('agent_id', function ($revenue)
            {
                $sender = getColumnValue($revenue->agent);
                $permission = Common::has_permission(auth('admin')->user()->id, 'edit_agent');
                $url = isActive('Agent') ? route('admin.agents.agents.edit', $revenue->agent_id): null;
        
                if ($sender <> '-') {
                    return $permission && $url ? '<a href="' . $url . '">'. $sender .'</a>' : $sender;
                }

                return $sender;
            })
            ->editColumn('transaction_type_id', function ($revenue)
            {
                return isset($revenue->transaction_type_id) ? str_replace('_', ' ', $revenue->transaction_type?->name) : '-';
            })
            ->editColumn('agent_percentage', function ($revenue)
            {
                return '<td><span class="text-'. (($revenue->agent_percentage > 0) ? 'green">+' : 'red">')  . formatNumber($revenue->agent_percentage, $revenue->currency_id) . '</span></td>';
            })
            ->editColumn('currency_id', function ($revenue)
            {
                return isset($revenue->currency?->code) ? $revenue->currency?->code : '-';
            })
            ->rawColumns(['agent_percentage','agent_id'])
            ->make(true);
    }

    public function query()
    {
        $from = isset(request()->from) && !empty(request()->from) ? setDateForDb(request()->from) : null;
        $to = isset(request()->to ) && !empty(request()->to) ? setDateForDb(request()->to) : null;
        $currency = isset(request()->currency) ? request()->currency : 'all';
        $type = isset(request()->type) ? request()->type : 'all';
        $agent = isset(request()->user_id) ? request()->user_id : null;

        $query = (new AgentPaymentService())->getAgentRevenuesList($from, $to, $currency, $type, $agent);

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
        ->addColumn(['data' => 'id', 'name' => 'transactions.id', 'searchable' => false, 'visible' => false])
        ->addColumn(['data' => 'created_at', 'name' => 'transactions.created_at', 'title' => __('Date')])
        ->addColumn(['data' => 'agent_id', 'name' => 'transactions.agent_id', 'title' => __('Agent Name')])
        ->addColumn(['data' => 'transaction_type_id', 'name' => 'transaction_type.name', 'title' => __('Transaction Type')])
        ->addColumn(['data' => 'agent_percentage', 'name' => 'transactions.agent_percentage', 'title' => __('Agent Revenues')])
        ->addColumn(['data' => 'currency_id', 'name' => 'transactions.currency_id', 'title' => __('Currency')])
        ->parameters(dataTableOptions());
    }
}
