<?php

namespace App\Http\Resources\Bouquet;

use App\Http\Resources\Addition\AdditionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomBouquetResource extends JsonResource
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
            'total_price' => $this->total_price,
            'products' => CustomBouquetProductResource::collection($this->products),
            'color' =>  ColorResource::make($this->color),
            'design' =>  DesignResource::make($this->design),
            'additions' => AdditionResource::collection($this->additions),
        ];
    }
}
