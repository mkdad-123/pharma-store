<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Trait\NotificationTrait;

class OrderStatusNotificationController extends Controller
{
    use NotificationTrait;

    public function __construct()
    {
        $this->setModel(new Pharmacist() , auth()->guard('pharmacist')->id());
    }
}
