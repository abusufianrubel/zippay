<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use Exception;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\EmailController;
use Modules\Agent\Entities\{Cashin,
    AgentWallet,
    Agent
};
use App\Http\Resources\V2\FeesResource;
use Modules\Agent\Http\Requests\CashinRequest;
use Modules\Agent\Services\AgentPaymentService;
use Modules\Agent\Transformers\{AgentWalletResource,
    TransactionResource
};

class AgentCashInController extends Controller
{
    protected $email;
    protected $agent;
    protected $transactionType;
    protected $paymentMethodId;
    protected $amount;
    protected $currencyId;
    protected $user;
    protected $feesLimit;
    protected $agentCommission;
    protected $service;

    public function __construct(AgentPaymentService $service)
    {
        $this->email = new EmailController();
        $this->service = $service;
        $this->agent = auth('agent-v2')->user();
        $this->transactionType = Cashin;
        $this->paymentMethodId = Cash;
        $this->currencyId = request('currency_id') ?? null;
        $this->amount = request('amount') ?? null;
    }

    public function currencyWalletList()
    {
        try {
            $wallets = AgentWalletResource::collection(
                AgentWallet::getActiveCurrencyWallets($this->agent->id)
            );
            return $this->successResponse(['wallets' => $wallets]);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function amountLimit(CashinRequest $request)
    {
        try {

            $feesLimit = $this->service->getTransactionFeesLimit(
                $this->currencyId, $this->amount, $this->transactionType, $this->paymentMethodId
            );

            $agentCommission = $this->service->getAgentTransactionCommission($this->amount);

            $agentWalletBalance = $this->service->agentWalletBalance($this->currencyId);

            if ($this->amount > $agentWalletBalance) {
                return $this->unprocessableResponse([], __('You do not have sufficient balance'));
            }

            $feesArray = [
                'agent_commission' => $agentCommission,
                'min' => $feesLimit->min_limit,
                'max' => $feesLimit->max_limit,
                'payment_method' => $this->paymentMethodId,
                'transactionType' => $this->transactionType,
                'agentFees' => $agentCommission,
                'formattedAgentFees' => formatNumber($agentCommission),
            ];

            $data =  array_merge((new FeesResource($feesLimit))->toArray(request()), $feesArray) ;

            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function balanceCheck(CashinRequest $request)
    {
        try {

            $agentWalletBalance = $this->service->agentWalletBalance($this->currencyId);

            if ($this->amount > $agentWalletBalance) {
                return $this->unprocessableResponse([], __('You do not have sufficient balance'));
            }

            $data = [
                'requestAmount' => $this->amount,
                'currencyId' => $this->currencyId,
                'walletBalance' => formatNumber($agentWalletBalance, $this->currencyId)
            ];

            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function store(CashinRequest $request)
    {
        try {

            $this->user = $this->service->getValidUser($request->user);

            $agentWalletBalance = $this->service->agentWalletBalance($this->currencyId);

            $this->feesLimit = $this->service->getTransactionFeesLimit(
                $this->currencyId, $this->amount, $this->transactionType, $this->paymentMethodId
            );

            $this->agentCommission = $this->service->getAgentTransactionCommission($this->amount);

            $totalAmount = $this->feesLimit->total_amount - $this->agentCommission;

            if ($totalAmount > $agentWalletBalance) {
                return $this->unprocessableResponse([], __('You do not have sufficient balance'));
            }

            DB::beginTransaction();

            $transactionResponse = (new Cashin())->createCashIn(
                $this->user->id,
                $this->currencyId,
                $this->paymentMethodId,
                $this->feesLimit,
                $this->amount,
                $this->agent->id,
                $this->agentCommission
            );

            $this->walletUpdate();

            DB::commit();

            event(new \Modules\Agent\Events\AgentCashinEvent($transactionResponse));

            return $this->successResponse(new TransactionResource($transactionResponse));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function walletUpdate()
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $this->user->id, 'currency_id' => $this->currencyId],
            ['balance' => 0]
        );

        $wallet->balance += $this->amount;
        $wallet->save();


        AgentWallet::where([
            'agent_id' => $this->agent->id,
            'currency_id' => $this->currencyId,
        ])->decrement('balance', $this->feesLimit->total_amount - $this->agentCommission);

    }

    public function getUser()
    {
        try {
            return $this->successResponse(
                $this->service->getValidUser(request()->user)
            );
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
        
    }
}
