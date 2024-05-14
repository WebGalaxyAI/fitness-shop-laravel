<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Attribute */
class AttributeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'frontend_type' => $this->frontend_type,
            'is_required' => $this->is_required,
            'is_filterable' => $this->is_filterable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'values' => AttributeValueResource::collection($this->whenLoaded('values')),
        ];
    }
}
