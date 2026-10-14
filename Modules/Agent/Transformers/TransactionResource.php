<?php

namespace Modules\Agent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Agent\Entities\Cashin;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {  
       
        $directoryName = ($this->transaction_type_id == Deposit ) ? 
        optional($this->payment_method)->name : strtolower(optional($this->transaction_type)->name);
    
        return [
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'agent_id'  => $this->agent_id,

            'user_first_name'        => optional($this->user)->first_name,
            'user_last_name'         => optional($this->user)->last_name,
            'user_full_name'         => optional($this->user)->full_name,
            'user_email'             => optional($this->user)->email,
            'user_image'             => image(optional($this->user)->picture, 'profile'),
            'user_photo'             => image(optional($this->user)->picture, 'profile'),
            'transaction_image'      => image('', $directoryName),

            'agent_first_name'       => optional($this->agent)->first_name,
            'agent_last_name'        => optional($this->agent)->last_name,
            'agent_full_name'        => fullName($this->agent),
            'agent_email'            => optional($this->agent)->email,
            'agent_photo'            => image(optional($this->agent)->picture, 'profile'),

            'end_user_id'            => $this->end_user_id,
            'currency_id'            => $this->currency_id,
            'curr_code'              => optional($this->currency)->code,
            'curr_symbol'            => optional($this->currency)->symbol,
            'payment_method_id'      => $this->payment_method_id,
            'payment_method_name'    => optional($this->payment_method)->name,
            'company_name'           => settings('name'),
            'uuid'                   => $this->uuid,
            'transaction_reference_id'  => $this->transaction_reference_id,
            'transaction_type_id'       => $this->transaction_type_id,
            'transaction_type'          => optional($this->transaction_type)->name,
            'user_type'                 => $this->user_type,
            'status'                    => $this->status,

            'subtotal'          => $this->subtotal,
            'charge_percentage' => $this->charge_percentage,
            'charge_fixed'      => $this->charge_fixed,
            'percentage'        => $this->percentage,
            'total'             => $this->total,

            'display_agent_percentage'=> moneyFormat(
                optional($this->currency)->symbol,
                formatNumber($this->agent_percentage, $this->currency_id)
            ),
            'display_charge_percentage'=> formatNumber($this->charge_percentage, $this->currency_id),
            'display_charge_fixed'   => formatNumber($this->charge_fixed, $this->currency_id),
            'display_subtotal'       => moneyFormat(
                optional($this->currency)->symbol,
                formatNumber($this->subtotal, $this->currency_id)
            ),
            'display_total'          => moneyFormat(
                optional($this->currency)->symbol,
                formatNumber($this->total, $this->currency_id)
            ),
            'display_totalFess'      => moneyFormat(
                optional($this->currency)->symbol,
                formatNumber($this->charge_percentage + $this->charge_fixed, $this->currency_id)
            ),
            'created_at' => agentDateFormat($this->created_at),
        ];
    }
}
