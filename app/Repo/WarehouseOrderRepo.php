<?php

namespace App\Repo;

use App\Interfaces\CrudRepoInterface;
use App\Models\Order;

class WarehouseOrderRepo implements CrudRepoInterface
{

    public function store($data){}

    public function showAll()
    {

        $warehouseId = auth()->guard('warehouse')->id();

        $orders = Order::with(['orderMedicines.medicine','pharmacist'])
            ->where('warehouse_id',$warehouseId)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $orders
        ]);
    }

    public function showOne($id)
    {
        $order = Order::with(['orderMedicines.medicine','pharmacist'])->find($id);

        return response()->json([
            'status' => 200,
            'data' => $order
        ]);
    }
}
