<?php

namespace App\Providers;

use App\Broadcasting\OrderStatusChannel;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::channel('private-order-status.{pharmacistId}',OrderStatusChannel::class);
    }
}
