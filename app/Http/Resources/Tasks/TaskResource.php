<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Providers\ProviderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'completed' => $this->completed,
            'provider' => ProviderResource::make($this->whenLoaded('provider'))
        ];
    }
}
