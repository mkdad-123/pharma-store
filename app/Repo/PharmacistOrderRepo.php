<?php

namespace App\Repo;

use App\Interfaces\CrudRepoInterface;
use App\Models\Order;
use App\Services\OrderServices\OrderStoreService;

class PharmacistOrderRepo implements CrudRepoInterface
{

    public function showAll()
    {
        $pharmacistId = auth()->guard('pharmacist')->id();

        $orders = Order::with([
                'orderMedicines.medicine.category:id,name',
                'orderMedicines.medicine.company:id,name',
                'orderMedicines.medicine.warehouse:id,name',
                'warehouse'])
            ->where('pharmacist_id',$pharmacistId)
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
                'orderMedicines.medicine.category',
                'orderMedicines.medicine.company',
                'orderMedicines.medicine.warehouse',
                'warehouse']
        )->find($id);


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

    public function store($data)
    {
        return (new OrderStoreService)->store($data);
    }

}
