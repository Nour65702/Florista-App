<?php

namespace App\Http\Resources\Customers;

use App\Http\Resources\Addresses\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imageUrl = null;

        if ($this->media && $this->media->isNotEmpty()) {
            $imageUrl = $this->media->first()->getUrl(); // Adjust this according to your storage setup
            $imageUrl = str_replace('http://localhost:8000', '', $imageUrl);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $imageUrl,
            'address' => AddressResource::make($this->whenLoaded('address'))

        ];
    }
}
