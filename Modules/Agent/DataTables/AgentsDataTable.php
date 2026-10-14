<?php

namespace Modules\Agent\DataTables;

use App\Http\Helpers\Common;
use Illuminate\Http\JsonResponse;
use Modules\Agent\Entities\Agent;
use Yajra\DataTables\Services\DataTable;

class AgentsDataTable extends DataTable
{
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('first_name', function ($agent) {
                $sender = getColumnValue($agent, 'first_name', null);
                $permission = Common::has_permission(auth('admin')->id(), 'edit_agent');
                $url = isActive('Agent') ? route('admin.agents.agents.edit', $agent->id) : null;
                
                if ($sender <> '-') {
                    return $permission && $url ? '<a href="' . $url . '">' . $sender . '</a>' : $sender;
                }
                return $sender;
            })
            ->editColumn('last_name', function ($agent) {
                $sender = getColumnValue($agent, null, 'last_name');
                $permission = Common::has_permission(auth('admin')->id(), 'edit_agent');
                $url = isActive('Agent') ? route('admin.agents.agents.edit', $agent->id) : null;

                if ($sender <> '-') {
                    return $permission && $url ? '<a href="' . $url . '">' . $sender . '</a>' : $sender;
                }
                return $sender;
            })
            ->editColumn('business_name', function ($agent) {
                return ($agent->business_name != null) ? $agent->business_name : '-';
            })
            ->editColumn('formatted_phone', function ($agent) {
                return ($agent->formatted_phone != null) ? $agent->formatted_phone : '-';
            })
            ->editColumn('agent_package_id', function ($agent) {
                $permission = Common::has_permission(auth('admin')->id(), 'edit_package');
                $url = route('admin.agents.packages.edit', $agent->agent_package_id) ?? null;
                return $permission && $url ? '<a href="' . $url . '">' . $agent->agentPackage?->name . '</a>' : '-';
            })
            ->editColumn('status', function ($agent) {
                return getStatusLabel($agent->status);
            })
            ->editColumn('created_at', function ($agent) {
                return ($agent->created_at != null) ? dateFormat($agent->created_at) : '-';
            })
            ->addColumn('action', function ($agent) {
                $deposit = (Common::has_permission(auth('admin')->id(), 'deposit_agent')) ? '<a href="' . route('admin.agents.deposit.create', $agent->id) . '" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Deposit"><i class="fa fa-money"></i></a>&nbsp;' : '';
                $show = (Common::has_permission(auth('admin')->id(), 'view_agent')) ? '<a href="' . route('admin.agents.agents.show', $agent->id) . '" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Details"><i class="fa fa-eye"></i></a>&nbsp;' : '';
                $edit = (Common::has_permission(auth('admin')->id(), 'edit_agent')) ? '<a href="' . route('admin.agents.agents.edit', $agent->id) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;' : '';
                $url = ($agent->status == 'Inactive') ? '<a disabled class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>' : '<a href="' . route('admin.agents.agents.destroy', $agent->id) . '" class="btn btn-xs btn-danger delete-warning" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>';
                $delete = (Common::has_permission(auth('admin')->id(), 'delete_agent')) ? $url : '';

                return $deposit. $show. $edit . $delete;
            })
            ->rawColumns(['first_name', 'last_name', 'agent_package_id', 'status', 'action'])
            ->make(true);
    }

    public function query()
    {
        $query = Agent::select('*');
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
        ->addColumn(['data' => 'id', 'name' => 'agents.id', 'searchable' => false, 'visible' => false])
        ->addColumn(['data' => 'first_name', 'name' => 'agents.first_name', 'title' => __('First Name')])
        ->addColumn(['data' => 'last_name', 'name' => 'agents.last_name', 'title' => __('Last Name')])
        ->addColumn(['data' => 'business_name', 'name' => 'agents.business_name', 'title' => __('Business Name')])
        ->addColumn(['data' => 'email', 'name' => 'agents.email', 'title' => __('Email')])
        ->addColumn(['data' => 'formatted_phone', 'name' => 'agents.formatted_phone', 'title' => __('Phone')])
        ->addColumn(['data' => 'agent_package_id', 'name' => 'agents.agent_package_id', 'title' => __('Package Name')])
        ->addColumn(['data' => 'status', 'name' => 'agents.status', 'title' => __('Status')])
        ->addColumn(['data' => 'created_at', 'name' => 'agents.created_at', 'title' => __('Registered at')])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}