<?php

namespace Modules\Agent\Services;

use Exception;
use App\Models\{User, 
    Transaction
};
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Modules\Agent\Entities\AgentWallet;

class AgentPaymentService
{    
    /**
     * The authenticated agent.
     *
     * @var \App\Models\Agent
     */
    protected $agent;
    
    /**
     * Create a new AgentPaymentService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->agent = auth('agent-v2')->user();
    }
    
    /**
     * Get the commission for the agent's transaction.
     *
     * @param  float  $amount
     * @return float
     */
    public function getAgentTransactionCommission($amount)
    {
        return getAgentCommission($this->agent->id, $amount);
    }

    /**
     * Get the wallet balance for the agent.
     *
     * @param  int  $currencyId
     * @return float
     */
    public function agentWalletBalance($currencyId)
    {
        return AgentWallet::getBalance($this->agent->id, $currencyId);
    }

    /**
     * Get the fees and limits for a transaction.
     *
     * @param  int  $currencyId
     * @param  float  $amount
     * @param  string  $transactionType
     * @param  string  $paymentMethod
     * @return array
     */
    public function getTransactionFeesLimit($currencyId, $amount, $transactionType, $paymentMethod)
    {
        $feesLimits = (new Common)->transactionFees($currencyId, $amount, $transactionType, $paymentMethod);

        (new Common)->amountIsInLimit($feesLimits, $amount);

        return $feesLimits;
    }

    /**
     * Get a valid user by email.
     *
     * @param  string  $user
     * @return \App\Models\User
     *
     * @throws \Exception
     */
    public function getValidUser($user)
    {
        $user = User::where('email', $user)->first();

        if (empty($user)) {
            throw new Exception(__('User Not Found'));
        }

        return $user;
    }

    /**
     * Search for a user's transactions by name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $transactionType
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactionSearch(Request $request, $transactionType)
    {
        $search = $request->search;
    
        $users = User::where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%');
            })
            ->with([$transactionType => function ($query) {
                $query->select('user_id');
            }])
            ->distinct()
            ->get(['id', 'first_name', 'last_name']);
    
        $filteredUsers = $users->filter(function ($user) use ($transactionType) {
            return count($user->{$transactionType}) > 0;
        });

    
        $res = [
            'status' => $filteredUsers->isEmpty() ? 'fail' : 'success',
            'data'   => [
                $transactionType => $filteredUsers->isEmpty() ? null : $filteredUsers,
            ],
        ];
    
        return response()->json($res);
    }

    /**
     * Get a list of agent revenues.
     *
     * @param  string|null  $from
     * @param  string|null  $to
     * @param  int|string|null  $currency
     * @param  int|string|null  $type
     * @param  \App\Models\Agent|null  $agent
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getAgentRevenuesList($from = null, $to = null, $currency = null, $type = null, $agent = null)
    {
        $query = Transaction::query();

        $revenueTransactionTypes = [Cashin, Cashout];

        $relationships = [
            'agent:id,first_name,last_name',
            'cashin.user:id,first_name,last_name',
            'cashout.user:id,first_name,last_name',
        ];
    
        $query->with(array_merge((new Transaction())->transactionRelationships(), $relationships))
            ->where('transactions.status', 'Success');

        if (!empty($currency) && $currency != 'all') {
            $query->where('transactions.currency_id', $currency);
        }

        if (!empty($type) && $type != 'all') {
            $query->where('transaction_type_id', $type);
        }

        if (!empty($from) && !empty($to)) {
            $query->whereDate('transactions.created_at', '>=', $from)->whereDate('transactions.created_at', '<=', $to);
        }

        $query->where(function ($q) {
            $q->where('agent_percentage', '>', 0);
        });

        $query->whereIn('transaction_type_id', $revenueTransactionTypes);

        return $query;
    }
}