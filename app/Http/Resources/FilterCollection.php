<?php

namespace App\Http\Resources;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Attribute */
class FilterCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return $this->collection->map(function (array $arr) {
            /** @var Attribute $value */
            $attribute = $arr['attribute'];
            return [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'code' => $attribute->code,
                'frontend_type' => $attribute->frontend_type,
                'facet_count' => $arr['facet_count'],
                'values' => $arr['values']->map(function (array $arr) {
                    /** @var AttributeValue $value */
                    $value = $arr['value'];
                    return [
                        'id' => $value->id,
                        'value' => $value->value,
                        'code' => $value->code,
                        'facet_count' => $arr['facet_count'],
                    ];
                }),
            ];
        })->toArray();
    }
}
