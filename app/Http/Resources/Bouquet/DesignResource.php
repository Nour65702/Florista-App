<?php

namespace App\Http\Resources\Bouquet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imageUrl = $this->media->first()->getUrl(); // Adjust this according to your storage setup
        $imageUrl = str_replace('http://localhost:8000', '', $imageUrl);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imageUrl,
        ];
    }
}
