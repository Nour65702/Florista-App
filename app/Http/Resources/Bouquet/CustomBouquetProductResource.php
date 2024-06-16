<?php

namespace App\Http\Resources\Bouquet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomBouquetProductResource extends JsonResource
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
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ];
    }
}
