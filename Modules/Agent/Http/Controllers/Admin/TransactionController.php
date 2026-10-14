<?php

namespace Modules\Agent\Http\Controllers\Admin;

use Exception;
use App\Models\Deposit;
use App\Models\Currency;
use App\Models\FeesLimit;
use App\Models\Transaction;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Modules\Agent\Entities\AgentWallet;
use Modules\Agent\Events\AgentDeposited;
use Modules\Agent\Services\AgentService;

class TransactionController extends Controller
{
    protected $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'agents';

        try {
            $data['agent'] = $this->agentService->getAgentById($id);
            
            // Fetch payment methods
            $data['paymentMethods'] = PaymentMethod::whereIn('name', ['Mts', 'FedaPay'])->active()->get();
            $defaultMethod = $data['paymentMethods']->first();
            
            $activeCurrency = Currency::active()->fiat()->get();
            $feesLimitCurrency = FeesLimit::where([
                'transaction_type_id' => Deposit, 
                'payment_method_id' => $defaultMethod?->id
            ])->hasTransaction()->get(['currency_id', 'has_transaction']);
            
            // Ensure this key matches what the view expects
            $data['activeCurrencyList'] = $this->currencyList($activeCurrency, $feesLimitCurrency);

            return view('agent::admin.deposit.create', $data);
        } catch (Exception $ex) {
            Common::one_time_message('error',  $ex->getMessage());
            return redirect()->route('admin.agents.agents.index');
        }
    }

    public function currencyList($activeCurrency, $feesLimitCurrency)
    {
        $selectedCurrency = [];
        foreach ($activeCurrency as $aCurrency) {
            foreach ($feesLimitCurrency as $flCurrency) {
                if ($aCurrency->id == $flCurrency->currency_id && $aCurrency->status == 'Active' && $flCurrency->has_transaction == 'Yes') {
                    $selectedCurrency[$aCurrency->id]['id'] = $aCurrency->id;
                    $selectedCurrency[$aCurrency->id]['code'] = $aCurrency->code;
                    $selectedCurrency[$aCurrency->id]['type'] = $aCurrency->type;
                }
            }
        }
        return $selectedCurrency;
    }

    public function confirm(Request $request)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'agents';

        try {
            $request->validate([
                'amount' => ['required', 'numeric'],
                'payment_method' => ['required']
            ]);

            $agentId = $request->agent_id;
            $amount = $request->amount;

            $data['agent'] = $this->agentService->getAgentById($agentId);
            if ($data['agent']->status == 'Inactive' || $data['agent']->status == 'Suspended') {
                Common::one_time_message('error', __('This Agent is :x', ['x' => $data['agent']->status]));
                return redirect()->route('admin.agents.deposit.create', $agentId);
            }

            $currency = Currency::where(['id' => $request->currency_id])->fiat()->active()->first();
            $request['currSymbol'] = $currency->symbol;
            $request['totalAmount'] = $amount + $request->fee;
            $data['transInfo'] = $request->all();
            session(['transInfo' => $data['transInfo']]);

            // Check amount and limit for the specific chosen payment method
            $feesDetails = FeesLimit::where([
                'transaction_type_id' => Deposit, 
                'currency_id' => $request->currency_id, 
                'payment_method_id' => $request->payment_method
            ])
            ->hasTransaction()->first(['min_limit', 'max_limit']);

            if (!$feesDetails) {
                Common::one_time_message('error', __('Fees limit not found for the selected payment method.'));
                return redirect()->back();
            }

            if ($feesDetails->max_limit == null) {
                if ($amount < $feesDetails->min_limit) {
                    Common::one_time_message('error', 
                    __('Minimum amount :x', ['x' => formatNumber($feesDetails->min_limit, $request->currency_id)]));  
                    return redirect()->back();  
                }
            } else {
                if (($amount < $feesDetails->min_limit) || ($amount > $feesDetails->max_limit)) {
                    Common::one_time_message('error', 
                    __('Minimum amount :x and Maximum amount :y', 
                    ['x'=>formatNumber($feesDetails->min_limit, $request->currency_id), 
                    'y' =>formatNumber($feesDetails->max_limit, $request->currency_id)]));
                    return redirect()->back();  
                }
            }

            $paymentMethodObj = PaymentMethod::find($request->payment_method);

            // If it's FedaPay, route directly through Zippay's gateway handler
            if ($paymentMethodObj && strtolower($paymentMethodObj->name) === 'fedapay') {
                $uuid = unique_code();
                // $gatewayData = [
                //     'gateway' => 'fedapay',
                //     'amount' => $amount,
                //     'totalAmount' => $request['totalAmount'],
                //     'currency_id' => $request->currency_id,
                //     'currency' => $currency->code,
                //     'uuid' => $uuid,
                //     'transaction_type' => 'Deposit',
                //     'payment_type' => 'deposit',
                //     'payment_method' => $paymentMethodObj->id,
                //     'redirectUrl' => route('admin.agents.deposit.success.api'), // or matching callback route
                // ];
                $gatewayData = [
                    'gateway' => 'fedapay',
                    'amount' => $amount,
                    'total' => $request['totalAmount'], // Meets 'total' requirement
                    'totalAmount' => $request['totalAmount'], 
                    'currency_id' => $request->currency_id,
                    'currencyCode' => $currency->code, // Meets 'currencyCode' requirement (camelCase)
                    'currency' => $currency->code, // Keeps legacy views happy
                    'uuid' => $uuid,
                    'transaction_type' => 'Deposit',
                    'payment_type' => 'deposit',
                    'payment_method' => $paymentMethodObj->id,
                    'redirectUrl' => route('admin.agents.agents.index'), 
                    'success_url' => route('admin.agents.agents.index'), // Meets 'success_url' requirement
                ];
                return redirect(gatewayPaymentUrl($gatewayData));
            }

            return view('agent::admin.deposit.confirmation', $data);
        } catch (Exception $ex) {
            Common::one_time_message('error',  $ex->getMessage());
            return redirect()->route('admin.agents.agents.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'agents';
        
        $agentId = $request->agent_id;
        $data['agent'] = Agent::find($agentId);

        $sessionValue = session('transInfo');
        if (empty($sessionValue)) {
            return redirect()->route('admin.agents.deposit.create', $agentId);
        }
                
        $amount = $sessionValue['amount'];
        
        $uuid = unique_code();
        $feeInfo = FeesLimit::where([
            'transaction_type_id' => Deposit, 
            'currency_id' => $sessionValue['currency_id'], 
            'payment_method_id' => $sessionValue['payment_method']
        ])->first(['charge_percentage', 'charge_fixed']);
        
        // Charge percentage calculation
        $p_calc = (($amount) * ($feeInfo->charge_percentage) / 100);
        try {
            DB::beginTransaction();
            // Deposit
            $deposit = new Deposit();
            $deposit->agent_id = $agentId;
            $deposit->currency_id = $sessionValue['currency_id'];
            $deposit->payment_method_id = $sessionValue['payment_method'];
            $deposit->uuid = $uuid;
            $deposit->charge_percentage = $feeInfo->charge_percentage ? $p_calc : 0;
            $deposit->charge_fixed = $feeInfo->charge_fixed ?? 0;
            $deposit->amount = $amount;
            $deposit->status = 'Success';
            $deposit->save();

            // Transaction
            $transaction = new Transaction();
            $transaction->agent_id = $agentId;
            $transaction->currency_id = $sessionValue['currency_id'];
            $transaction->payment_method_id = $sessionValue['payment_method'];
            $transaction->transaction_reference_id = $deposit->id;
            $transaction->transaction_type_id = Deposit;
            $transaction->uuid = $uuid;
            $transaction->subtotal = $amount;
            $transaction->percentage = $feeInfo->charge_percentage ?? 0;
            $transaction->charge_percentage = $deposit->charge_percentage;
            $transaction->charge_fixed = $deposit->charge_fixed;
            $transaction->total = $amount + $deposit->charge_percentage + $deposit->charge_fixed;
            $transaction->status = 'Success';
            $transaction->save();

            // Agent Wallet
            $agentwallet = AgentWallet::where(['agent_id' => $agentId, 'currency_id' => $sessionValue['currency_id']])->first(['id', 'balance']);
            if (empty($agentwallet)) {
                $createWallet = new AgentWallet();
                $createWallet->agent_id = $agentId;
                $createWallet->currency_id = $sessionValue['currency_id'];
                $createWallet->balance = $amount;
                $createWallet->is_default = 'No';
                $createWallet->save();
            } else {
                $agentwallet->balance = ($agentwallet->balance + $amount);
                $agentwallet->save();
            }
            DB::commit();

            event(new AgentDeposited($deposit));

            $data['transInfo'] = $transaction;
            $data['transInfo']['currSymbol'] = $transaction->currency->symbol;
            $data['agent_id'] = $agentId;

            Session::forget('transInfo');

            return view('agent::admin.deposit.success', $data);

        } catch (Exception $e) {
            DB::rollBack();
            Session::forget('transInfo');
            clearActionSession();

            Common::one_time_message('error', $e->getMessage());
            
            return redirect()->route('admin.agents.agents.index');
        }
    }

    public function amountFeesLimitCheck(Request $request)
    {
        $amount = $request->amount;
        $paymentMethodId = $request->payment_method_id ?? PaymentMethod::where('name', 'Mts')->value('id');

        $feesDetails = FeesLimit::where([
            'transaction_type_id' => Deposit, 
            'currency_id' => $request->currency_id, 
            'payment_method_id' => $paymentMethodId
        ])->first(['min_limit', 'max_limit', 'charge_percentage', 'charge_fixed']);
        
        $wallet = AgentWallet::where(['currency_id' => $request->currency_id, 'agent_id' => $request->agent_id])->first();

        // Amount Limit Check Starts here
        if (empty($feesDetails)) {
            $feesPercentage = 0;
            $feesFixed = 0;
            $totalFess = $feesPercentage + $feesFixed;
            $totalAmount = $amount + $totalFess;
            $success['feesPercentage'] = $feesPercentage;
            $success['feesFixed'] = $feesFixed;
            $success['totalFees'] = $totalFess;
            $success['totalFeesHtml'] = formatNumber($totalFess, $request->currency_id);
            $success['totalAmount'] = $totalAmount;
            $success['pFees'] = $feesPercentage;
            $success['pFeesHtml'] = formatNumber($feesPercentage, $request->currency_id);
            $success['fFees'] = $feesFixed;
            $success['fFeesHtml'] = formatNumber($feesFixed, $request->currency_id);
            $success['min'] = 0;
            $success['max'] = 0;
            $success['balance'] = 0;
        } else {
            if ($feesDetails->max_limit == null) {
                if ($amount < $feesDetails->min_limit) {
                    $success['message'] = __('Minimum amount :x', ['x' => formatNumber($feesDetails->min_limit, $request->currency_id)]);
                    $success['status'] = '401';
                } else {
                    $success['status'] = 200;
                }
            } else {
                if (($amount < $feesDetails->min_limit) || ($amount > $feesDetails->max_limit)) {
                    $success['message'] = __('Minimum amount :x and Maximum amount :y', ['x' => formatNumber($feesDetails->min_limit, $request->currency_id), 'y' => formatNumber($feesDetails->max_limit, $request->currency_id)]);
                    $success['status'] = '401';
                } else {
                    $success['status'] = 200;
                }
            }
            $feesPercentage = $amount * ($feesDetails->charge_percentage / 100);
            $feesFixed = $feesDetails->charge_fixed;
            $totalFess = $feesPercentage + $feesFixed;
            $totalAmount = $amount + $totalFess;
            $success['feesPercentage'] = $feesPercentage;
            $success['feesFixed'] = $feesFixed;
            $success['totalFees'] = $totalFess;
            $success['totalFeesHtml'] = formatNumber($totalFess, $request->currency_id);
            $success['totalAmount'] = $totalAmount;
            $success['pFees'] = $feesDetails->charge_percentage;
            $success['pFeesHtml'] = formatNumber($feesDetails->charge_percentage, $request->currency_id);
            $success['fFees'] = $feesDetails->charge_fixed;
            $success['fFeesHtml'] = formatNumber($feesDetails->charge_fixed, $request->currency_id);
            $success['min'] = $feesDetails->min_limit;
            $success['max'] = $feesDetails->max_limit;
            $success['balance'] = $wallet->available_balance ?? 0;
        }
        // Amount Limit Check Ends here
        return response()->json(['success' => $success]);
    }

    public function printpdf($transactionId)
    {
        $data['transaction'] = Transaction::with(['agent:id,first_name,last_name','payment_method:id,name', 'currency:id,symbol,code'])
            ->where(['id' => $transactionId])
            ->first();

        generatePDF('agent::admin.deposit.pdf', 'deposit_report_', $data);
    }
}