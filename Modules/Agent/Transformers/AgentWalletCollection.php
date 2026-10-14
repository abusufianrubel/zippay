<?php

namespace Modules\Agent\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AgentWalletCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return AgentWalletResource::collection($this->collection);

    }
}
