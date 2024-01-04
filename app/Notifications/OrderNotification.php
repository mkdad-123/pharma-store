<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    protected $warehouse,$order;

    public function __construct($warehouse,$order)
    {
        $this->warehouse = $warehouse;
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toArray(object $notifiable): array
    {
        return [
            'warehouse' => $this->warehouse,
            'order' => $this->order,
        ];
    }
}
