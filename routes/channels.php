<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('private-orders.{warehouse_id}',function ($warehouse){

    return (int) $warehouse->id === (int) auth()->guard('warehouse')->id();
});

Broadcast::channel('warehouse-register',function ($admin){

    return (Auth::guard('admin')->check());
});
