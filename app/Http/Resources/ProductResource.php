<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'active' => $this->active,
            'featured' => $this->featured,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image' => $this->getFirstImgUrl(),
            'attribute_values' => AttributeValueResource::collection($this->whenLoaded('attributeValues')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'media' => MediaResource::collection($this->whenLoaded('media'))
        ];
    }
}
