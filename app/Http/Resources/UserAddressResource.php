<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'country_iso' => $this->country_iso,
            'city' => $this->city,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'zip_code' => $this->zip_code,
        ];
    }
}
