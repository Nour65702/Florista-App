<?php

namespace App\Http\Resources\Addresses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'city' => $this->city,
            'country_id' => $this->country_id,
            'line_one' => $this->line_one,
            'line_two' => $this->line_two,
            'street' => $this->street,
        ];
    }
}
