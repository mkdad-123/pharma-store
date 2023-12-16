<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $order;

    protected $warehouse_id;

    public function __construct($order,$warehouse_id)
    {
        $this->order = $order;
        $this->warehouse_id = $warehouse_id;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('private-orders.'.$this->warehouse_id);
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order
        ];
    }
}
