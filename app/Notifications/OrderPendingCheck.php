<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\ProductionOrder;

class OrderPendingCheck extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(ProductionOrder $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'warning', // Yellow icon
            'title' => 'Verifikasi Order',
            'message' => "Order #{$this->order->order_number} menunggu verifikasi Anda.",
            'url' => route('production.show', $this->order->id),
            'order_id' => $this->order->id,
        ];
    }
}
