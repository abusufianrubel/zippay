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

class Cashout extends Model
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

    public function createCashOut($arr)
    {
        $cashOut                      = new self();
        $cashOut->user_id             = $arr['user_id'];
        $cashOut->currency_id         = $arr['currency_id'];
        $cashOut->payment_method_id   = $arr['payment_method_id'];
        $cashOut->uuid                = $arr['uuid'];
        $cashOut->charge_percentage   = $arr['fees_percentage'];
        $cashOut->charge_fixed        = $arr['charge_fixed'];
        $cashOut->subtotal            = $arr['subtotal'];
        $cashOut->amount              = $arr['amount'];
        $cashOut->total               = $arr['total_amount'] + $arr['agent_percentage'];
        $cashOut->payment_method_info = $arr['payment_method_info'];
        $cashOut->agent_id            = $arr['agent_id'];
        $cashOut->agent_package_id    = getAgentPackage($arr['agent_id'])->id;
        $cashOut->agent_percentage    = $arr['agent_percentage'];
        $cashOut->status              = 'Success';
        $cashOut->save();

        $transaction = new Transaction();
        $transaction->user_id =$arr['user_id'];
        $transaction->currency_id = $arr['currency_id'];
        $transaction->payment_method_id = $arr['payment_method_id'];
        $transaction->uuid = $arr['uuid'];
        $transaction->transaction_reference_id = $cashOut->id;
        $transaction->transaction_type_id =  Cashout;
        $transaction->subtotal = $arr['amount'];
        $transaction->percentage = $arr['charge_percentage'];
        $transaction->agent_percentage = $arr['agent_percentage'];
        $transaction->charge_percentage = $arr['fees_percentage'];
        $transaction->charge_fixed = $arr['charge_fixed'];
        $transaction->total =  $arr['total_amount'] + $arr['agent_percentage'];
        $transaction->agent_id = $arr['agent_id'];
        $transaction->status = 'Success';
        $transaction->save();

        return $transaction;
    }

    public function getCashoutsUsersName($user)
    {
        return $this->leftJoin('users', 'users.id', '=', 'cashouts.user_id')
            ->where(['user_id' => $user])
            ->select('users.first_name', 'users.last_name', 'users.id')
            ->first();
    }

    public function getCashoutsUsersResponse($search)
    {
        return $this->leftJoin('users', 'users.id', '=', 'cashouts.user_id')
            ->where('users.first_name', 'LIKE', '%' . $search . '%')
            ->orWhere('users.last_name', 'LIKE', '%' . $search . '%')
            ->distinct('users.first_name')
            ->select('users.first_name', 'users.last_name', 'cashouts.user_id')
            ->get();
    }
}
