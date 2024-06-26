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
        $imageUrl = null;

        if ($this->product && $this->product->getFirstMediaUrl('product_image')) {
            $imageUrl = $this->product->getFirstMediaUrl('product_image'); 
            $imageUrl = str_replace('http://localhost:8000', '', $imageUrl);
        }
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'quantity' => $this->quantity,
            'size' => $this->size,
            'image' => $imageUrl
        ];
    }
}
