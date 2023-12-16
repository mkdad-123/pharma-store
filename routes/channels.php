<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('private-orders.{warehouse_id}',function ($warehouse){

    return (int) $warehouse->id === (int) auth()->guard('warehouse')->id();
});

Broadcast::channel('private-order-status.{pharmacist_id}',function ($pharmacist){

    return (int) $pharmacist->id === (int) auth()->guard('pharmacist')->id();
});

Broadcast::channel('warehouse-register',function ($admin){

    return (Auth::guard('admin')->check());
});
