<?php

namespace Modules\Agent\DataTables;

use App\Http\Helpers\Common;
use Illuminate\Http\JsonResponse;
use Modules\Agent\Entities\AgentPackage;
use Yajra\DataTables\Services\DataTable;

class AgentPackagesDataTable extends DataTable
{
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('name', function ($agentPackage) {
                return $agentPackage->name;
            })
            ->editColumn('description', function ($agentPackage) {
                return ucfirst($agentPackage->description);
            })
            ->editColumn('commission', function ($agentPackage) {
                return formatNumber($agentPackage->commission);
            })
            ->editColumn('is_default', function ($agentPackage) {
                return ($agentPackage->is_default == 'Yes') ? isDefault('yes') : isDefault('no');
            })
            ->addColumn('action', function ($agentPackage) {
                $editPermission = Common::has_permission(auth('admin')->id(), 'edit_package');
                $editUrl = route('admin.agents.packages.edit', $agentPackage->id) ?? null;
                
                $deletePermission = Common::has_permission(auth('admin')->id(), 'delete_package');
                $deleteUrl = route('admin.agents.packages.destroy', $agentPackage->id) ?? null;
                
                $edit = $editPermission && $editUrl ? '<a href="' . $editUrl . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;' : '';
                $delete = $deletePermission && $deleteUrl ? '<a href="' . $deleteUrl . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>' : '';

                return $edit . $delete;
            })
            ->rawColumns(['action', 'is_default'])
            ->make(true);
    }

    public function query()
    {
        $query = AgentPackage::select('id','name','description','commission','is_default');
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'agent_packages.id', 'title' => __('ID'), 'searchable' => false, 'visible' => false])
            ->addColumn(['data' => 'name', 'name' => 'agent_packages.name', 'title' => __('Name')])
            ->addColumn(['data' => 'description', 'name' => 'agent_packages.description', 'title' => __('Description')])
            ->addColumn(['data' => 'commission', 'name' => 'agent_packages.commission', 'title' => __('Commission (%)')])
            ->addColumn(['data' => 'is_default', 'name' => 'agent_packages.is_default', 'title' => __('Default')])
            ->addColumn(['data'  => 'action', 'name'  => 'action', 'title' => __('Action'), 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }
}
