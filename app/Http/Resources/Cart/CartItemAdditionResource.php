<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemAdditionResource extends JsonResource
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
            'addition_name' => $this->addition->name,
            'quantity' => $this->quantity,
            'image' => $imageUrl,
        ];
    }
}
