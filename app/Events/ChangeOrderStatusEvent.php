<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeOrderStatusEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $orderStatus,$phamacistId;

    public function __construct($orderStatus,$phamacistId)
    {
        $this->orderStatus = $orderStatus;
        $this->phamacistId = $phamacistId;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('private-order-status.'.$this->phamacistId);
    }

    public function broadcastWith()
    {
        return [
            'order-status' => $this->orderStatus
        ];
    }
}
