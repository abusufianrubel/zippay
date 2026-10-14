<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Agent\Transformers\TransactionResource;
use Modules\Agent\Entities\AgentWallet;
use Modules\Agent\Transformers\AgentWalletResource;

class TransactionController extends Controller
{
    public function transactionList(Request $request)
    {
        try {
            $type = $request->has('type') ? $request->type: 'all';
            $limit = $request->has('limit') ? $request->limit: 10;
            $order = $request->has('order') ? $request->order: "desc";

            $page = $request->input('page', 1);
            $offset = ($page - 1) * $limit;

            $from = isset(request()->from) ? setDateForDb(request()->from) : null;
            $to = isset(request()->to) ? setDateForDb(request()->to) : null;
            $currencyId = $request->has('currency_id') ? $request->currency_id: 'all';

            if ('all' == $type) {
                $type = [Cashin, Cashout, Deposit];
            } else {
                $type = [$type];
            }
            
            $agentId = auth('agent-v2')->user()->id;

            $transactions = Transaction::where('agent_id', $agentId);

            if (!empty($type) && $type != 'all') {
                $transactions->whereIn('transaction_type_id', $type);
            }

            if (!empty($currencyId) && $currencyId != 'all') {
                $transactions->where('currency_id', $currencyId);
            }

            if (!empty($from) && !empty($to)) {
                $transactions->whereDate('transactions.created_at', '>=', $from)
                            ->whereDate('transactions.created_at', '<=', $to);
            }

            $transactions->orderBy('id', $order);
                        
            $totalRecords         = $transactions->count();
            $transactions         = $transactions->offset($offset)->limit($limit)->get();

            $transactions = TransactionResource::collection($transactions);

            $wallets  = AgentWalletResource::collection(AgentWallet::getAgentWallet($agentId));
            $agentRevenues = Transaction::with('currency')
                ->where('agent_id', $agentId)
                ->selectRaw("SUM(agent_percentage) as total")
                ->selectRaw('currency_id')
                ->groupBy('currency_id')
                ->get();

            return $this->successResponse(
                [
                    'transactions' =>  $transactions,
                    'totalRecords' => $totalRecords,
                    'wallets' => $wallets,
                    'agentRevenues' => $agentRevenues,
                    'totalPage' => ceil($totalRecords / $limit),
                    'page' => $page,
                    'limit' => $limit
                ]
            );
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function transactionDetails(Request $request, $id)
    {
        try {
            // $transaction = new Transaction();
            $transaction = $this->agentTransactionDetails($id, auth('agent-v2')->user()->id);



            return $this->successResponse($transaction);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function getPaymentMethod()
    {
        try {
            $paymentMethod = getPaymentMethodViaName('Cash');

            return $this->successResponse($paymentMethod);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function agentTransactionDetails($tr_id, $agent_id)
    {
        $conditions       = ['transactions.id' => $tr_id, 'transactions.agent_id' => $agent_id];
        $whereInCondition = [Cashin, Cashout, Deposit];

        $transaction = new Transaction();

        $transaction = $transaction->with([
            'currency:id,type,code,symbol',
            'user:id,first_name,last_name,picture,email,formattedPhone',
            'agent:id,first_name,last_name,email',
            'end_user:id,first_name,last_name,picture,email,formattedPhone',
            'payment_method:id,name',
            'transaction_type:id,name',
        ])
            ->where($conditions)
            ->whereIn('transactions.transaction_type_id', $whereInCondition)
            ->orderBy('transactions.id', 'desc')
            ->select([
                'transactions.id as id',
                'transactions.user_id',
                'transactions.agent_id',
                'transactions.end_user_id',
                'transactions.currency_id',
                'transactions.payment_method_id',
                'transactions.transaction_type_id',
                'transactions.transaction_reference_id as transaction_reference_id',
                'transactions.charge_percentage as charge_percentage',
                'transactions.agent_percentage as agent_percentage',
                'transactions.charge_fixed as charge_fixed',
                'transactions.subtotal as subtotal',
                'transactions.total as total',
                'transactions.uuid as transaction_id',
                'transactions.status as status',
                'transactions.note as description',
                'transactions.email as email',
                'transactions.phone as phone',
                'transactions.created_at as t_created_at',
            ])->first();

        if(!$transaction) {
            throw new Exception(__('Transaction not Exist.'));
        }

        if ($transaction->agent_id) {
            $transaction->agent_id     = $transaction->agent_id;
            $transaction->agent_f_name = optional($transaction->agent)->first_name;
            $transaction->agent_l_name = optional($transaction->agent)->last_name;
            $transaction->agent_email  = optional($transaction->agent)->email;
            $transaction->agent_phone  = optional($transaction->agent)->formattedPhone;
            $transaction->agent_photo  = optional($transaction->agent)->picture;
        }

        $transaction->curr_code   = optional($transaction->currency)->code;
        $transaction->curr_symbol = optional($transaction->currency)->symbol;

        //formatNumber - starts
        $transaction->total = optional($transaction->currency)->type != 'fiat' ? moneyFormat(optional($transaction->currency)->symbol, $transaction->total) : moneyFormat(optional($transaction->currency)->symbol, formatNumber($transaction->total));

        $transaction->subtotal = optional($transaction->currency)->type != 'fiat' ? moneyFormat(optional($transaction->currency)->symbol, $transaction->subtotal) : moneyFormat(optional($transaction->currency)->symbol, formatNumber($transaction->subtotal));

        if (optional($transaction->currency)->type != 'fiat') {
            $transaction->totalFees = (($transaction->charge_percentage == 0) && ($transaction->charge_fixed == 0)) ? moneyFormat(optional($transaction->currency)->symbol, 0.00000000) : moneyFormat(optional($transaction->currency)->symbol, $transaction->charge_fixed);
        } else {
            $transaction->totalFees = (($transaction->charge_percentage == 0) && ($transaction->charge_fixed == 0)) ? moneyFormat(optional($transaction->currency)->symbol, formatNumber(0)) : moneyFormat(optional($transaction->currency)->symbol, formatNumber($transaction->charge_percentage + $transaction->charge_fixed));
        }
        //formatNumber - ends

        if ($transaction->payment_method_id) {
            $transaction->payment_method_name = optional($transaction->payment_method)->name;
            $transaction->company_name        = settings('name');
        }

        if ($transaction->merchant_id) {
            $transaction->merchant_name = optional($transaction->merchant)->business_name;
        }
        $transaction->type_id      = optional($transaction->transaction_type)->id;
        $transaction->type         = optional($transaction->transaction_type)->name;

        if (!empty($transaction->user_id)) {
            $transaction->t_created_at = dateFormat($transaction->t_created_at, null);
        }

        $transaction->recipient_mobile = optional($transaction->recharge)->recipient_mobile;
        $transaction->agent_percentage = ($transaction->agent_percentage == 0 ) ? $transaction->agent_percentage : moneyFormat(optional($transaction->currency)->symbol, formatNumber($transaction->agent_percentage));

        return $transaction;
    }


}
