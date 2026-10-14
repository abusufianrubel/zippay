<?php

namespace Modules\Agent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentWalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'agent_id '         => $this->agent_id ,
            'currency_id'       => $this->currency_id ,
            'available_balance' => $this->balance,
            'is_default'        => $this->is_default,
            'currency_type'     => $this->currency->type,
            'currency_code'     => $this->currency->code,
            'currency_symbol'   => $this->currency->symbol,
            'currency_logo'     => $this->currency->logo,
            'currency_path'     => image($this->currency->logo, 'currency')
        ];
    }
}
