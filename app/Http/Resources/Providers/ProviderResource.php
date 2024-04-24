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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks'))

        ];
    }
}
