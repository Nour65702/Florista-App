<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Addition\AdditionResource;
use App\Http\Resources\Bouquet\CustomBouquetProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCustomBouquetResource extends JsonResource
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
            'name' => $this->name,
            'products' => CustomBouquetProductResource::collection($this->products),
            'additions' => AdditionResource::collection($this->userCustomBouquetAdditions),
        ];
    }
}
