<?php

namespace App\Reposetries;

use App\Interfaces\CrudRepoInterface;
use App\Models\Order;

class WarehouseOrderRepo implements CrudRepoInterface
{

    public function store($data){}

    public function showAll()
    {

        $warehouseId = auth('warehouse')->id();

        $orders = getOrderWithPharmacist()
            ->whereWarehouseId($warehouseId)
            ->get();

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $orders
        ]);
    }

    public function showOne($id)
    {
        $order = getOrderWithWarehouse()->find($id);

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $order
        ]);
    }
}
