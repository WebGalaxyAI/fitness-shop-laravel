<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Spatie\MediaLibrary\MediaCollections\Models\Media */
class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'model_type' => $this->model_type,
            'model_id' => $this->model_id,
            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'disk' => $this->disk,
            'conversions_disk' => $this->conversions_disk,
            'type' => $this->type,
            'extension' => $this->extension,
            'humanReadableSize' => $this->humanReadableSize,
            'preview_url' => $this->preview_url,
            'original_url' => $this->original_url,
            'size' => $this->size,
            'order_column' => $this->order_column,
            'manipulations' => $this->manipulations,
            'custom_properties' => $this->custom_properties,
            'generated_conversions' => $this->generated_conversions,
            'responsive_images' => $this->responsive_images,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
