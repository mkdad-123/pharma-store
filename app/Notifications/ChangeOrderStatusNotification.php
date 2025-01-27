<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeOrderStatusNotification extends Notification
{
    use Queueable;

    protected $orderStatus , $order;

    public function __construct($orderStatus , $order)
    {
        $this->orderStatus = $orderStatus;
        $this->order = $order;
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toArray(object $notifiable): array
    {
        return [
            'order-status' => $this->orderStatus,
            'order' => $this->order,
        ];
    }
}
