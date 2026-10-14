<?php

namespace Modules\Agent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            'business_name'     => $this->business_name,
            'package_name'      => $this->agentPackage->name,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'iso2'              => $this->iso2,
            'dial_code'         => $this->dial_code,
            'phone'             => $this->phone,
            'formatted_phone'   => $this->formatted_phone,
            'address'           => $this->address,
            'city'              => $this->city,
            'state'             => $this->state,
            'country'           => $this->country->name,
            'timezone'          => $this->timezone,
            'photo'             => !empty($this->photo) ? url('Modules/Agent/Resources/assets/images/profile') . '/' . $this->photo: defaultImage('profile'),
            'type'              => $this->type,
            'status'            => $this->status
        ];
    }
}
