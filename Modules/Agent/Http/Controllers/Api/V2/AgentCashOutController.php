<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use Exception;
use App\Models\{User,
    Wallet,
    UserDetail
};

use Modules\Agent\Entities\{Agent,
    Cashout,
    AgentWallet,
    OtpCode
};

use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\EmailController;
use App\Http\Resources\V2\FeesResource;
use Modules\Agent\Http\Requests\CashoutRequest;
use Modules\Agent\Services\AgentPaymentService;

use Carbon\Carbon;

use Modules\Agent\Transformers\{AgentWalletResource,
    TransactionResource
};

class AgentCashOutController extends Controller
{
    protected $agent;
    protected $amount;
    protected $service;
    protected $currencyId;
    protected $transactionType;
    protected $paymentMethodId;

    public function __construct(AgentPaymentService $service)
    {
        $this->service = $service;
        $this->paymentMethodId = Cash;
        $this->transactionType = Cashout;
        $this->agent = auth('agent-v2')->user();
        $this->amount = request('amount') ?? null;
        $this->currencyId = request('currency_id') ?? null;

    }

    public function withdrawalCurrencyList(Request $request)
    {
        try {

            $user = $this->service->getValidUser($request->user);

            $walletList = Wallet::where(['user_id' => $user->id])
                ->whereHas('active_currency', function ($q) {
                    $q->whereHas('fees_limit', function ($query) {
                        $query->where(['transaction_type_id' =>  $this->transactionType, 'has_transaction' => 'Yes']);
                    });
                })
                ->with(['active_currency:id,code'])
                ->get(['id', 'currency_id', 'is_default', 'balance']);

            return $this->successResponse(AgentWalletResource::collection($walletList));
        } catch (Exception $e) {
            return $this->unprocessableResponse([],$e->getMessage());
        }
    }

    public function userBalanceCheck(CashoutRequest $request)
    {
        try {

            $user = $this->service->getValidUser($request->user);

            $wallet =  (new Common())->getWallet($user->id, $this->currencyId);

            $feesLimit = $this->service->getTransactionFeesLimit(
                $this->currencyId, $this->amount, $this->transactionType, $this->paymentMethodId
            );

            if ($feesLimit->total_amount > $wallet->balance) {
                return $this->unprocessableResponse([], __('User does not have sufficient balance'));
            }

            $agentCommission = $this->service->getAgentTransactionCommission($this->amount);

            $feesArray = [
                'agentCommission' => $agentCommission,
                'agentCommissionHtml' => formatNumber($agentCommission, $this->currencyId),
                'balance' => formatNumber($wallet->balance, $this->currencyId),
                'userId' => $user->id,
                'userName' => getFullName($user),
            ];

            $data =  array_merge((new FeesResource($feesLimit))->toArray(request()), $feesArray) ;

            return $this->successResponse($data);
        }catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function withdrawalOtp(Request $request)
    {
        try {
            $otpCode = rand(100000, 999999);
            
            $user = $this->getUserById($request->user_id);
            if (!$user) {
                return $this->unprocessableResponse([], __('User not found.'));
            }

            $agentId = auth('agent-v2')->user()->id;
            $conditions = [
                'user_id'   => $user->id,
                'agent_id'  => $agentId,
                'type'      => strtolower('CashOut'),
            ];

            $otpCodeInstance = OtpCode::updateOrCreateOtpCode($conditions, $otpCode);
            if (!$otpCodeInstance) {
                return $this->unprocessableResponse([], __('Otp not send, please try again'));
            }

            event(new \Modules\Agent\Events\AgentCashoutOtpCode($otpCodeInstance));

            $data = [
                'userId'   => $user->id,
                'userName' => getFullName($user),
                'otpCode'  => $otpCode,
            ];

            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], __($e->getMessage()));
        }
    }

    private function getUserById($userId)
    {
        return User::find($userId);
    }

    public function store(CashoutRequest $request)
    {
        try {
            $otpCode = $request->otp_code;

            $user = $this->service->getValidUser($request->user);

            $wallet =  (new Common())->getWallet($user->id, $this->currencyId);

            $otpCodeInstance = OtpCode::findOtpCode(
                [
                    'user_id' => $user->id, 
                    'agent_id' => $this->agent->id, 
                    'type' => strtolower('Cashout')
                ]
            );

            if (!$otpCodeInstance) {
                throw new Exception(__('OTP code is not avaialble'));
            }

            $feesLimit = $this->service->getTransactionFeesLimit(
                $this->currencyId, $this->amount, $this->transactionType, $this->paymentMethodId
            );

            if ($feesLimit->total_amount > $wallet->balance) {
                throw new Exception(__('User does not have sufficient balance'));
            }

            
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $otpCodeInstance->updated_at);
            $endTime = Carbon::createFromFormat('Y-m-d H:i:s', now());
            
            // Calculate the difference in minutes
            $timeDifference = $endTime->diffInMinutes($startTime);
            \Illuminate\Support\Facades\Log::info('time otp',[$otpCodeInstance->updated_at, now(), $timeDifference]);

            // Check if the time difference is greater than 5 minutes
            if ($timeDifference > 1) {
                throw new Exception(__('The OTP you entered is Expired'));
            }

            if ($otpCode != $otpCodeInstance->otp_code) {
                throw new Exception(__('The OTP you entered is incorrect'));
            }

            DB::beginTransaction();

            $agentCommission =  $this->service->getAgentTransactionCommission($this->amount);

            $cashOutArr = [
                'user_id' => $user->id,
                'currency_id' => $this->currencyId,
                'payment_method_id' => $this->paymentMethodId,
                'uuid' => unique_code(),
                'charge_percentage' => $feesLimit->charge_percentage,
                'charge_fixed' => $feesLimit->charge_fixed,
                'subtotal' => $this->amount - $feesLimit->total_fees,
                'amount' => $this->amount,
                'total_amount' => $feesLimit->amount,
                'payment_method_info' => $user->email,
                'agent_id' => $this->agent->id,
                'agent_percentage' => $agentCommission,
                'fees_percentage' => $feesLimit->fees_percentage,
                'status' => 'Success'
            ];

            $transactionResponse = (new Cashout())->createCashOut($cashOutArr);

            Wallet::where([
                'user_id' => $user->id,
                'currency_id' => $this->currencyId,
            ])->decrement('balance', ($this->amount + $feesLimit->total_fees));


            AgentWallet::where([
                'agent_id' => $this->agent->id,
                'currency_id' => $this->currencyId,
            ])->increment('balance', ($this->amount + $agentCommission));

            $otpCodeInstance->delete();

            DB::commit();

            event(new \Modules\Agent\Events\AgentCashoutEvent($transactionResponse));

            return $this->successResponse(new TransactionResource($transactionResponse));
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function notificationSend($withdrawal)
    {
        try {
            if (checkAppMailEnvironment()) {
                $withdrawNotification = (new Agent())->withdrawNotificationsend($withdrawal);
                (new EmailController())->sendEmail(
                    $withdrawNotification['email'], 
                    $withdrawNotification['subject'], 
                    $withdrawNotification['message']
                );
            }

            // sms notification send
            if (checkAppSmsEnvironment()) {
                (new Agent())->withdrawSmsNotificationsend($withdrawal);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
