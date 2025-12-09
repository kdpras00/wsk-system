<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\ProductionOrder;

class NewOrderAvailable extends Notification
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
            'type' => 'info', // Blue icon
            'title' => 'Order Baru Tersedia',
            'message' => "Order #{$this->order->order_number} siap dikerjakan.",
            'url' => route('operator.dashboard'), // Go to dashboard to pick it up
            'order_id' => $this->order->id,
        ];
    }
}
