<?php

namespace Modules\Agent\Http\Controllers\Agent;

use Modules\Agent\Entities\Agent;
use App\Http\Controllers\Users\EmailController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Common;
use App\Models\{
    Transaction,
    Currency,
    Setting,
    User
};
use Exception;
use Modules\Agent\Http\Requests\CashinRequest;

class AgentCashInController extends Controller
{
    protected $helper;
    protected $email;
    protected $agent;

    public function __construct()
    {
        $this->helper       = new Common();
        $this->agent        = new Agent();
        $this->email        = new EmailController();
    }

    public function create(Request $request)
    {
        setActionSession();
        $data = executeAgentApi('deposit-currency-list');
        $data['menu']               = 'cashin';
        $data['content_title']      = 'cashin';

        return view('agent::agent.cash-in.create', $data);
    }

    public function confirm(CashinRequest $request)
    {
        $data['menu']               = 'cashin';
        $data['content_title']      = 'cashin';

        try {
            $status = checkAgentBalance($request, auth()->guard('agent')->user()->id);

            if (!$status) {
                Common::one_time_message('error', __('Agent have not enough balance'));
                return redirect()->route('agent.cashin.create');
            }
            $currencyId = $request->currency_id;
            $currency = Currency::find($currencyId);
            $request['currSymbol'] = $currency->symbol;
            $request['payment_method_id'] = Cash;

            $response = executeAgentPostApi("deposit-amount-limit", $request);

            $user  = User::where('email', $request->user)->first();

            if (empty( $user)) {
                Common::one_time_message('error', __('User not found'));
                return redirect()->route('agent.cashin.create');
            }

            $response['user'] = $data['user'] = $user;

            $request->session()->put('transInfo', $response);
            $data['transInfo'] = $response;
            return view('agent::agent.cash-in.confirm', $data);
        } catch (Exception $th) {
            Common::one_time_message('error', $th->getMessage());
            return back()->withInput();
        }
    }

    public function currencyList($activeCurrency, $agentWalletList)
    {
        $selectedCurrency = [];
        foreach ($activeCurrency as $aCurrency) {
            foreach ($agentWalletList as $wallet) {
                if ($aCurrency->id == $wallet->currency_id && $aCurrency->status == 'Active') {
                    $selectedCurrency[$aCurrency->id]['id']   = $aCurrency->id;
                    $selectedCurrency[$aCurrency->id]['code'] = $aCurrency->code;
                }
            }
        }
        return $selectedCurrency;
    }

    public function success(Request $request)
    {
        try {
            $response = executeAgentPostApi("deposit-confirm", $request);
            setPaymentData($response);
            return redirect()->route('agent.cashin.success_url');
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('agent.cashin.create');
        }
        
    }

    public function successUrl()
    {
        $data['menu']               = 'cashin';
        $data['content_title']      = 'cashin';
        
        try {
            $data = getPaymentData();

            if (empty($data)) {
                return redirect()->route('agent.cashin.create');
            }

            getPaymentData('forget');

            return view('agent::agent.cash-in.success', $data);
        } catch (Exception $th) {
            Common::one_time_message('error', $th->getMessage());
            return redirect()->route('agent.cashin.create');
        }
    }

    public function manageFees(Request $request)
    {
        try {
            $success = executeAgentPostApi("deposit-amount-limit", $request);
            return response()->json([
                'success' => $success,
                'status' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function checkUser(Request $request)
    {
        try {
            $success = executeAgentPostApi("get-user", $request);
            return response()->json([
                'success' => $success,
                'status' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function printPdf($trans_id)
    {
        $data['companyInfo'] = Setting::where(['type' => 'general', 'name' => 'logo'])->first(['value']);

        $data['transactionDetails'] = Transaction::with([
            'payment_method:id,name',
            'currency:id,symbol,code',
            'user:id,first_name,last_name,email,phone',
            'agent:id,first_name,last_name,email,phone'
        ])->where('id', $trans_id)->first();

        generatePDF('agent::agent.cash-in.pdf', 'agent_cashin_', $data);
    }
}
