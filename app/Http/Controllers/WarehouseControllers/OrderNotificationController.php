<?php

namespace App\Http\Controllers\WarehouseControllers;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Trait\NotificationTrait;
use Illuminate\Support\Facades\DB;

class OrderNotificationController extends Controller
{
    use NotificationTrait;

    public function __construct()
    {
        $this->setModel(new Warehouse() , auth()->guard('warehouse')->id());
    }
}
