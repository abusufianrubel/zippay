<?php

namespace Modules\Agent\Http\Controllers\Admin;

use Exception;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Agent\Services\AgentPackageService;
use Modules\Agent\DataTables\AgentPackagesDataTable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Agent\Http\Requests\StoreAgentPackageRequest;
use Modules\Agent\Http\Requests\UpdateAgentPackageRequest;

class AgentPackageController extends Controller
{
    protected $agentPackageService;
    protected $helper;

    public function __construct(AgentPackageService $agentPackageService)
    {
        $this->agentPackageService = $agentPackageService;
        $this->helper = new Common();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AgentPackagesDataTable $dataTable)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'packages';
        return $dataTable->render('agent::admin.packages.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'packages';

        return view('agent::admin.packages.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreAgentPackageRequest $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $this->agentPackageService->createPackage($validatedData);

            DB::commit();

            Common::one_time_message('success', __('The :x has been successfully saved.', ['x' => __('agent package')]));
            return redirect()->route('admin.agents.packages.index');
        } catch (Exception $ex) {
            DB::rollback();
            Common::one_time_message('error', $ex->getMessage());
            return redirect()->route('admin.agents.packages.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['menu'] = 'agents';
            $data['sub_menu'] = 'packages';
            $data['agentPackage'] = $this->agentPackageService->getPackage($id);

            return view('agent::admin.packages.edit', $data);
        } catch (Exception $ex) {
            Common::one_time_message('error', __('Requested data has not been found!'));
            return redirect()->route('admin.agents.packages.index');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAgentPackageRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $this->agentPackageService->updatePackage($id, $validatedData);

            DB::commit();

            Common::one_time_message('success', __('The :x has been successfully saved.', ['x' => __('agent package')]));
            return redirect()->route('admin.agents.packages.index');
        } catch (Exception $ex) {
            DB::rollback();
            Common::one_time_message('error', $ex->getMessage());
            return redirect()->route('admin.agents.packages.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->agentPackageService->deletePackage($id);
            DB::commit();

            Common::one_time_message('success', __('The :x has been successfully deleted.', ['x' => __('agent package')]));
            return redirect()->route('admin.agents.packages.index');
        } catch (ModelNotFoundException $ex) {
            DB::rollback();
            Common::one_time_message('error', __('Requested data has not been found!'));
            return redirect()->route('admin.agents.packages.index');
        } catch (QueryException $ex) {
            DB::rollback();
            Common::one_time_message('error', __('Cannot delete this record due to a foreign key constraint.'));
            return redirect()->route('admin.agents.packages.index');
        } catch (Exception $ex) {
            DB::rollback();
            Common::one_time_message('error', $ex->getMessage());
            return redirect()->route('admin.agents.packages.index');
        }
    }
}