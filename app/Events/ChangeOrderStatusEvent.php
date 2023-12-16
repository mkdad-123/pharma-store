<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeOrderStatusEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $orderStatus;

    protected $pharmacist_id;

    public function __construct($orderStatus,$pharmacist_id)
    {
        $this->orderStatus = $orderStatus;
        $this->pharmacist_id = $pharmacist_id;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('private-order-status.'.$this->pharmacist_id);
    }

    public function broadcastWith()
    {
        return [
            'order-status' => $this->orderStatus
        ];
    }
}
