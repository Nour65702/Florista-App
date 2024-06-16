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
        return [
            'id' => $this->id,
            'addition_id' => $this->addition_id,
            'quantity' => $this->quantity,
        ];
    }
}
