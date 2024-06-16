<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Addition\AdditionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'collection_id' => $this->collection_id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'size' => $this->size,
            'min_level' => $this->min_level,
            'is_active' => (bool) $this->is_active,
            'in_stock' => (bool) $this->in_stock,
            'on_sale' => (bool) $this->on_sale,
            'image' => $imageUrl,
            'rate' => $this->rate,
            'additions' => AdditionResource::collection($this->whenLoaded('additions')),
        ];
    }
}
