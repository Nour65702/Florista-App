<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user->name,
            'payment_method' => $this->payment_method,
            'delivery_to' => $this->delivery_to,
            'shipping_method' => $this->shipping_method,
            'total_price' => $this->total_price,
            'notes' => $this->notes
        ];
    }
}
