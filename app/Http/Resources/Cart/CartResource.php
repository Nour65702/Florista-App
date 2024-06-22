<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Bouquet\CustomBouquetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'user_name' => $this->user->name,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
            'custom_bouquets' => CustomBouquetResource::collection($this->customBouquets),

        ];
    }
}
