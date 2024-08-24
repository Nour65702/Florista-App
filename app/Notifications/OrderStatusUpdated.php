<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    private $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'status' => $this->order->status,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
        ];
    }

    public function toMessage()
    {
        return "Your order #{$this->order->id} has been updated to status: {$this->order->status}.";
    }
}
