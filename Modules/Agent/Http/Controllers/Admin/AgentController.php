<?php

namespace Modules\Agent\Http\Controllers\Admin;

use Exception;
use App\Models\Country;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Agent\Entities\AgentPackage;
use Modules\Agent\Services\AgentService;
use Modules\Agent\Events\AgentRegistered;
use Modules\Agent\Services\WalletService;
use Illuminate\Contracts\Support\Renderable;
use Modules\Agent\DataTables\AgentsDataTable;
use Modules\Agent\Http\Requests\StoreAgentRequest;
use Modules\Agent\Http\Requests\UpdateAgentRequest;

class AgentController extends Controller
{
    protected $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AgentsDataTable $dataTable)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'agents';
        return $dataTable->render('agent::admin.agents.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'agents';
        $data['agentPackages'] = AgentPackage::get();
        $data['countries'] = Country::get();
        $data['timezones'] = phpDefaultTimeZones();

        // Retrieve the default agent package
        $data['defaultPackage'] = AgentPackage::where('is_default', 'Yes')->first();
        $data['defaultCountry'] = getCountryByIP() ?? Country::where('is_default', 'Yes')->value('name');

        return view('agent::admin.agents.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreAgentRequest $request, WalletService $walletService)
    {
        try {
            $data = $request->all();

            DB::beginTransaction();
            // Create New Agent
            $agent = $this->agentService->createAgent($data);

            // Create Agent's default wallet
            $walletService->createAgentDefaultWallet($agent->id);

            // Create wallets that are allowed by admin
            if (settings('allowed_wallets') != 'none') {
                $walletService->createAgentAllowedWallets($agent->id);
            }

            event(new AgentRegistered($agent));

            DB::commit();

            Common::one_time_message('success', __('The :x has been successfully saved.', ['x' => __('agent')]));
            return redirect()->route('admin.agents.agents.index');

        } catch (Exception $e) {
            DB::rollBack();
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('admin.agents.agents.index');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'agents';
        try {
            $data['agent'] = $this->agentService->getAgentById($id);
            if (empty($data['agent'])) {
                Common::one_time_message('error', __('The :x does not exist.', ['x' => __('agent')]));
                return redirect()->route('admin.agents.index');
            }

            $data['agentWallet'] = $this->agentService->getAgentWallets($id);

            $bg = array('e-bg', 'g-bg', 'a-bg');
            
            $output = [];
            foreach ($data['agentWallet'] as $value) {
                $transaction = \App\Models\Transaction::where([
                    'agent_id' => $id,
                    'currency_id' => $value->currency_id,
                    'payment_method_id' => Cash 
                ])->get(); 
            
                $output[$value->currency->code] = [
                    'color' => $bg[array_rand($bg, 1)],
                    'symbol' => $value->currency->symbol,
                    'logo' => $value->currency->logo,
                    'currency_id' => $value->currency_id,
                    'balance' => $value->balance,
                    'default' => $value->is_default,
                    'cashin' => $transaction->where('transaction_type_id', Cashin)->sum('subtotal'),
                    'cashout' => $transaction->where('transaction_type_id', Cashout)->sum('subtotal'),
                    'revenue' => $transaction->sum('agent_percentage')
                ];
            }
            $data['walletLists'] = $output;
            return view('agent::admin.agents.show', $data);
        } catch (Exception $ex) {
            Common::one_time_message('error',  $ex->getMessage());
            return redirect()->route('admin.agents.agents.index');
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
            return view('agent::admin.agents.edit', [
                'menu' => 'agents',
                'sub_menu' => 'agents',
                'agent' => $this->agentService->getAgentById($id),
                'countries' => Country::orderBy('name', 'asc')->get(),
                'timezones' => phpDefaultTimeZones()
            ]);
        }  catch (Exception $ex) {
            Common::one_time_message('error',  $ex->getMessage());
            return redirect()->route('admin.agents.agents.index');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAgentRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            // Update Agent
            $this->agentService->updateAgent($id, $data);

            DB::commit();

            Common::one_time_message('success', __('The :x has been successfully saved.', ['x' => __('agent')]));
            return redirect()->route('admin.agents.agents.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Common::one_time_message('error',  $ex->getMessage());
            return redirect()->route('admin.agents.agents.index');
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
            $this->agentService->deleteAgent($id);
            
            Common::one_time_message('success', __('The :x has been successfully deleted.', ['x' => __('agent')]));
            return redirect()->route('admin.agents.agents.index');
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('admin.agents.agents.index');
        }
    }

    public function duplicatePhoneCheck()
    {
        $phone = preg_replace("/[\s-]+/", "", request()->phone);
        $dialCode = request()->dial_code;
        $agentId = request()->agent_id;
        
        if ($this->agentService->phoneNumberIsAvailable($phone, $dialCode, $agentId)) {
            $data = [
                'status' => false,
                'success' => __('The :x is available.', ['x' => __('phone number')])
            ];
        } else {
            $data = [
                'status' => true,
                'fail' => __('The :x is already exist.', ['x' => __('phone number')])
            ];
        }
        
        return json_encode($data);
    }

    public function duplicateEmailCheck()
    {
        $data = [
            'status' => false,
            'success' => __('The :x is available.', ['x' => __('email')])
        ];
        
        $agentId = request('agent_id');
        $email = request()->email;
        if ($this->agentService->emailExists($email, $agentId)) {
            $data = [
                'status' => true,
                'fail' => __('The :x is already exist.', ['x' => __('email')])
            ];
        }
        
        return json_encode($data);
    }
}
