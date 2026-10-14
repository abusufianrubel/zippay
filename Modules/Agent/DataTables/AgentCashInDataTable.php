<?php

namespace Modules\Agent\DataTables;

use App\Http\Helpers\Common;
use Illuminate\Http\JsonResponse;
use Modules\Agent\Entities\Cashin;
use Yajra\DataTables\Services\DataTable;

class AgentCashInDataTable extends DataTable
{
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('created_at', function ($cashin) {
                return dateFormat($cashin->created_at);
            })
            ->addColumn('user_id', function ($cashin) {
                $sender = getColumnValue($cashin->user);
                $permission = Common::has_permission(auth('admin')->user()->id, 'edit_user');
                $url = url(config('adminPrefix') . '/users/edit/' . $cashin->user_id) ?? null;

                if ($sender <> '-') {
                    return  $permission && $url ? '<a href="' . $url . '">' . $sender . '</a>' : $sender;
                }

                return $sender;
            })
            ->addColumn('agent_id', function ($cashin) {
                $sender = getColumnValue($cashin->agent);
                $permission = Common::has_permission(auth('admin')->id(), 'edit_agent');
                $url = isActive('Agent') ? route('admin.agents.agents.edit', $cashin->agent->id) : null;
                
                if ($sender <> '-') {
                    return $permission && $url ? '<a href="' . $url . '">' . $sender . '</a>' : $sender;
                }

                return $sender;
            })
            ->editColumn('amount', function ($cashin) {
                return formatNumber($cashin->amount, $cashin->currency_id);
            })
            ->addColumn('fees', function ($cashin) {
                return totalFeesWithoutAgentFees($cashin) == 0 ? '-' : formatNumber(totalFeesWithoutAgentFees($cashin), $cashin->currency_id);
            })
            ->addColumn('commission', function ($cashin) {
                return formatNumber($cashin->agent_percentage, $cashin->currency_id);
            })
            ->addColumn('total', function ($cashin) {
                return '<td><span class="text-'. (($cashin->total > 0) ? 'green">+' : 'red">')  . formatNumber($cashin->total, $cashin->currency_id) . '</span></td>';
            })
            ->editColumn('currency_id', function ($cashin) {
                return isset($cashin->currency?->code) ? $cashin->currency?->code : '-';
            })
            ->editColumn('status', function ($cashin) {
                return getStatusLabel($cashin->status);
            })
            ->addColumn('action', function ($cashin) {
                $permission = Common::has_permission(auth('admin')->user()->id, 'edit_cashin');
                $url = route('admin.agents.cashin.edit', $cashin->id) ?? null;
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

        $query = Cashin::filterTransactions($from, $to, $currency, $status, $user, $agent);

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
        ->addColumn(['data' => 'id', 'name' => 'cashins.id', 'searchable' => false, 'visible' => false])
        ->addColumn(['data' => 'created_at', 'name' => 'cashins.created_at', 'title' => __('Date')])
        ->addColumn(['data' => 'uuid', 'name' => 'cashins.uuid', 'title' => __('Unique ID'), 'visible' => false])
        ->addColumn(['data' => 'user_id', 'name' => 'user.first_name', 'visible' => false])
        ->addColumn(['data' => 'user_id', 'name' => 'user.last_name', 'title' => __('User')])
        ->addColumn(['data' => 'agent_id', 'name' => 'agent.first_name', 'visible' => false])
        ->addColumn(['data' => 'agent_id', 'name' => 'agent.last_name', 'title' => __('Agent')])
        ->addColumn(['data' => 'amount', 'name' => 'cashins.amount', 'title' => __('Amount')])
        ->addColumn(['data' => 'fees', 'name' => 'fees', 'title' => __('Fees')])
        ->addColumn(['data' => 'agent_percentage', 'name' => 'cashins.agent_percentage', 'title' => __('Commission')])
        ->addColumn(['data' => 'total', 'name' => 'total', 'title' => __('Total')])
        ->addColumn(['data' => 'currency_id', 'name' => 'currency.code', 'title' => __('Currency')])
        ->addColumn(['data' => 'status', 'name' => 'cashins.status', 'title' => __('Status')])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
