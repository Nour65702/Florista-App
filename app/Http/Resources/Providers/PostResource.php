<?php

namespace App\Http\Resources\Providers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $imageUrls = $this->media->map(function ($media) {
            return str_replace('http://localhost:8000', '', $media->getUrl());
        })->toArray();

        return [
            'id' => $this->id,
            'description' => $this->description,
            'imageUrls' => $imageUrls,
        ];
    }
}
