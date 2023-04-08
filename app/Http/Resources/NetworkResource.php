<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Network */
class NetworkResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
        ];
    }
}
