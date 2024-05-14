<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\AttributeValue */
class AttributeValueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'code' => $this->code,
            'attribute' => AttributeResource::make($this->whenLoaded('attribute')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
