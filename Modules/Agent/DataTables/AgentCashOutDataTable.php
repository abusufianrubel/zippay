<?php

namespace Modules\Agent\DataTables;

use App\Http\Helpers\Common;
use Illuminate\Http\JsonResponse;
use Modules\Agent\Entities\Cashout;
use Yajra\DataTables\Services\DataTable;

class AgentCashOutDataTable extends DataTable
{
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('created_at', function ($cashout) {
                return dateFormat($cashout->created_at);
            })
            ->addColumn('user_id', function ($cashout) {
                $sender = getColumnValue($cashout->user);
                $permission = Common::has_permission(auth('admin')->user()->id, 'edit_user');
                $url = url(config('adminPrefix') . '/users/edit/' . $cashout->user_id) ?? null;

                if ($sender <> '-') {
                    return  $permission && $url ? '<a href="' . $url . '">' . $sender . '</a>' : $sender;
                }

                return $sender;
            })
            ->addColumn('agent_id', function ($cashout) {
                $sender = getColumnValue($cashout->agent);
                $permission = Common::has_permission(auth('admin')->id(), 'edit_agent');
                $url = isActive('Agent') ? route('admin.agents.agents.edit', $cashout->agent->id) : null;
                
                if ($sender <> '-') {
                    return $permission && $url ? '<a href="' . $url . '">' . $sender . '</a>' : $sender;
                }

                return $sender;
            })
            ->editColumn('amount', function ($cashout) {
                return formatNumber($cashout->amount, $cashout->currency_id);
            })
            ->addColumn('fees', function ($cashout) {
                return totalFeesWithoutAgentFees($cashout) == 0 ? '-' : formatNumber(totalFeesWithoutAgentFees($cashout), $cashout->currency_id);
            })
            ->addColumn('commission', function ($cashout) {
                return formatNumber($cashout->agent_percentage, $cashout->currency_id);
            })
            ->addColumn('total', function ($cashout) {
                $total = totalFeesWithoutAgentFees($cashout) + $cashout->amount - $cashout->agent_percentage;
                return '<td><span class="text-'. (($total > 0) ? 'green">+' : 'red">')  . formatNumber($total, $cashout->currency_id) . '</span></td>';
            })
            ->editColumn('currency_id', function ($cashout) {
                return isset($cashout->currency?->code) ? $cashout->currency?->code : '-';
            })
            ->editColumn('status', function ($cashout) {
                return getStatusLabel($cashout->status);
            })
            ->addColumn('action', function ($cashout) {
                $permission = Common::has_permission(auth('admin')->user()->id, 'edit_cashout');
                $url = route('admin.agents.cashout.edit', $cashout->id) ?? null;
                return $permission && $url ? '<a href="' . $url . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>&nbsp;' : '';
            })
            ->rawColumns(['user_id', 'agent_id', 'total', 'status', 'action'])
            ->make(true);
    }

    public function query()
    {
        $from     = !empty(request()->from) ? setDateForDb(request()->from) : null;
        $to       = !empty(request()->to) ? setDateForDb(request()->to) : null;
        $currency = isset(request()->currency) ? request()->currency : 'all';
        $status   = isset(request()->status) ? request()->status : 'all';
        $user     = isset(request()->user_id) ? request()->user_id : null;
        $agent    = isset(request()->agent_id) ? request()->agent_id : null;

        $query = Cashout::filterTransactions($from, $to, $currency, $status, $user, $agent);

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
        ->addColumn(['data' => 'id', 'name' => 'cashouts.id', 'searchable' => false, 'visible' => false])
        ->addColumn(['data' => 'created_at', 'name' => 'cashouts.created_at', 'title' => __('Date')])
        ->addColumn(['data' => 'uuid', 'name' => 'cashouts.uuid', 'title' => __('Unique ID'), 'visible' => false])
        ->addColumn(['data' => 'user_id', 'name' => 'user.first_name', 'visible' => false])
        ->addColumn(['data' => 'user_id', 'name' => 'user.last_name', 'title' => __('User')])
        ->addColumn(['data' => 'agent_id', 'name' => 'agent.first_name', 'visible' => false])
        ->addColumn(['data' => 'agent_id', 'name' => 'agent.last_name', 'title' => __('Agent')])
        ->addColumn(['data' => 'amount', 'name' => 'cashouts.amount', 'title' => __('Amount')])
        ->addColumn(['data' => 'fees', 'name' => 'fees', 'title' => __('Fees')])
        ->addColumn(['data' => 'agent_percentage', 'name' => 'cashouts.agent_percentage', 'title' => __('Commission')])
        ->addColumn(['data' => 'total', 'name' => 'total', 'title' => __('Total')])
        ->addColumn(['data' => 'currency_id', 'name' => 'currency.code', 'title' => __('Currency')])
        ->addColumn(['data' => 'status', 'name' => 'cashouts.status', 'title' => __('Status')])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
