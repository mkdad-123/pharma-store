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

        $orders = Order::with([
                'orderMedicines.medicine.category:id,name',
                'orderMedicines.medicine.company:id,name',
                'orderMedicines.medicine.warehouse:id,name',
                'warehouse'
            ])->where('warehouse_id',$warehouseId)
            ->get();

        $orders->each(function ($order) {
            $order->orderMedicines->each(function ($orderMedicines) {
                $orderMedicines->medicine->makeHidden(['category_id', 'company_id', 'warehouse_id']);
            });
        });

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $orders
        ]);
    }

    public function showOne($id)
    {
        $order = Order::with([
            'orderMedicines.medicine.category:id,name',
            'orderMedicines.medicine.company:id,name',
            'orderMedicines.medicine.warehouse:id,name',
            'warehouse'])->find($id);

        $order->each(function ($order) {
            $order->orderMedicines->each(function ($orderMedicines) {
                $orderMedicines->medicine->makeHidden(['category_id', 'company_id', 'warehouse_id']);
            });
        });

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $order
        ]);
    }
}
