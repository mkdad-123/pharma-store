<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WarehouseRegisterEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $warehouse;

    public function __construct($warehouse)
    {
        $this->warehouse = $warehouse;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('private-warehouse-register');
    }

    public function broadcastWith()
    {
        return [
            'warehouse' => $this->warehouse
        ];
    }
}
