<?php

namespace App\Managers;

use App\Models\Attribute;

class AttributeManager
{
    public function massCreateOrUpdateWithValues(array $attributes, $lang = 'uk'): array
    {
        $resultIds = [];
        foreach ($attributes as $attName => $attValue) {
            $attribute = Attribute::where("name->{$lang}", $attName)->first();
            if (!$attribute) {
                $attribute = Attribute::create([
                    'name' => [$lang => $attName],
                ]);
            }
            $value = $attribute->values()->where('value->uk', $attValue)->first();
            if (!$value) {
                $value = $attribute->values()->create([
                    'value' => [$lang => $attValue],
                ]);
            }
            $resultIds[] = $value->id;
        }
        return $resultIds;
    }
}
