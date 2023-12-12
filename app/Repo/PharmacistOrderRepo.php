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

        $orders = Order::with(['orderMedicines.medicine','warehouse'])
            ->where('pharmacist_id',$pharmacistId)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $orders
        ]);
    }

    public function showOne($id)
    {
        $order = Order::with(['orderMedicines.medicine','warehouse'])->find($id);

        return response()->json([
            'status' => 200,
            'data' => $order
        ]);
    }

    public function store($data)
    {
        return (new OrderStoreService)->store($data);
    }

}
