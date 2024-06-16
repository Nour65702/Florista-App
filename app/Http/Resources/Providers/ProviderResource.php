<?php

namespace App\Http\Resources\Providers;

use App\Http\Resources\Tasks\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_image_url' => $imageUrl,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks'))

        ];
    }
}
