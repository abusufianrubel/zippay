<?php

namespace Modules\Agent\Transformers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type'              => $this->type,
            'role_id'           => $this->role_id,
            'agent_id'          => $this->agent_id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'defaultCountry'    => $this->defaultCountry,
            'carrierCode'       => $this->carrierCode,
            'phone'             => $this->phone,
            'formattedPhone'    => $this->formattedPhone,
            'address_verified'  => $this->address_verified,
            'identity_verified' => $this->identity_verified,
            'picture'           => $this->picture ? url(User::$profilePictureDirectory). '/' . $this->picture : null,
            'image'             => $this->picture ?? null,
            'status'            => $this->status,
            'date'              => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
