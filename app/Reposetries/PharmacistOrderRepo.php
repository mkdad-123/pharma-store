<?php

namespace App\Reposetries;

use App\Interfaces\CrudRepoInterface;
use App\Models\Order;
use App\Services\OrderServices\OrderStoreService;

class PharmacistOrderRepo implements CrudRepoInterface
{

    public function showAll()
    {
        $pharmacistId = auth()->guard('pharmacist')->id();

        $orders = getOrderWithWarehouse()
            ->where('pharmacist_id',$pharmacistId)
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

    public function store($data)
    {
         $result = (new OrderStoreService)->store($data);

         return response()->json([
             'status' => $result->status,
             'message' => $result->message,
             'data' => $result->data
         ]);
    }

}
