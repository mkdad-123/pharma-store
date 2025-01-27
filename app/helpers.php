<?php

use App\Models\Order;

function getOrderWithPharmacist(): \Illuminate\Database\Eloquent\Builder|\LaravelIdea\Helper\App\Models\_IH_Order_QB
{
    return Order::with([
        'orderMedicines.medicine.category:id,name',
        'orderMedicines.medicine.company:id,name',
        'orderMedicines.medicine.warehouse:id,name',
        'pharmacist',
    ]);
}

function getOrderWithWarehouse(): \Illuminate\Database\Eloquent\Builder|\LaravelIdea\Helper\App\Models\_IH_Order_QB
{
    return Order::with([
            'orderMedicines.medicine.category',
            'orderMedicines.medicine.company',
            'orderMedicines.medicine.warehouse',
            'warehouse'
    ]);
}
