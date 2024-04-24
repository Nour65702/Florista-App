<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'main category' => $this->parent_id,
            'sub category' => CategoryResource::collection($this->whenLoaded('children')),
            'collections' => CollectionResource::collection($this->whenLoaded('collections'))
        ];
    }
}
