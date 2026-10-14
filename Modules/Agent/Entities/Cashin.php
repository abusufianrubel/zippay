<?php

namespace Modules\Agent\Entities;

use App\Models\{User, 
    Currency, 
    Transaction, 
    PaymentMethod
};
use Modules\Agent\Entities\Agent;
use Illuminate\Database\Eloquent\Model;
use Modules\Agent\Traits\FilterableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashin extends Model
{
    use HasFactory, FilterableTrait;

    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'transaction_reference_id', 'id');
    }

    public function createCashIn($userId, $currencyId, $paymentMethodId, $feesLimit, $amount, $agentId = null, $agentFees = null)
    {
        $uuid = unique_code();

        $cashin = new self();
        $cashin->user_id = $userId;
        $cashin->currency_id = $currencyId;
        $cashin->payment_method_id = $paymentMethodId;
        $cashin->uuid = $uuid;
        $cashin->charge_percentage = $feesLimit->fees_percentage;
        $cashin->charge_fixed = $feesLimit->charge_fixed;
        $cashin->amount = $amount;
        $cashin->subtotal = $feesLimit->total_amount;
        $cashin->total = $feesLimit->total_amount - $agentFees;
        $cashin->agent_id = $agentId;
        $cashin->agent_package_id = getAgentPackage($agentId)->id;
        $cashin->agent_percentage = $agentFees;
        $cashin->status = 'Success';
        $cashin->save();

        $transaction = new Transaction();
        $transaction->user_id = $userId;
        $transaction->currency_id = $currencyId;
        $transaction->payment_method_id = $paymentMethodId;
        $transaction->uuid = $uuid;
        $transaction->transaction_reference_id = $cashin->id;
        $transaction->transaction_type_id =  Cashin;
        $transaction->subtotal = $cashin->amount;
        $transaction->percentage = $feesLimit->charge_percentage;
        $transaction->agent_percentage = $agentFees;
        $transaction->charge_percentage = $feesLimit->fees_percentage;
        $transaction->charge_fixed = $feesLimit->charge_fixed;
        $transaction->total =  $feesLimit->total_amount - $agentFees;
        $transaction->agent_id = $agentId;
        $transaction->status = 'Success';
        $transaction->save();

        return $transaction;
    }

    public function getCashinsUsersName($user)
    {
        return $this->leftJoin('users', 'users.id', '=', 'cashins.user_id')
            ->where(['user_id' => $user])
            ->select('users.first_name', 'users.last_name', 'users.id')
            ->first();
    }

    public function getCashinsUsersResponse($search)
    {
        return $this->leftJoin('users', 'users.id', '=', 'cashins.user_id')
            ->where('users.first_name', 'LIKE', '%' . $search . '%')
            ->orWhere('users.last_name', 'LIKE', '%' . $search . '%')
            ->distinct('users.first_name')
            ->select('users.first_name', 'users.last_name', 'cashins.user_id')
            ->get();
    }
}
