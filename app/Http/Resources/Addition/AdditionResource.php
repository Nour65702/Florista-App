<?php

namespace App\Http\Resources\Addition;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionResource extends JsonResource
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
            $imageUrl = $this->media->first()->getUrl(); 
            $imageUrl = str_replace('http://localhost:8000', '', $imageUrl);
        }
        return [
            'id' => $this->id,
            'type_addition_id' => $this->type_addition_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image_url' => $imageUrl,
        ];
    }
}
