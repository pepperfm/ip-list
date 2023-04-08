<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Address */
class AddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'frozen' => $this->frozen,
            'frozen_label' => $this->frozen ? 'Заморожен' : 'Свободен',
        ];
    }
}
