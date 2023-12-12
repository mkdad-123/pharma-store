<?php

namespace App\Services\OrderServices;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderStoreService
{
    protected function storeOrder($data)
    {
        $warehouseId = $data->input('warehouse_id');
        $order = new Order();
        $order->pharmacist_id = auth()->guard('pharmacist')->id();
        $order->warehouse_id = $warehouseId;
        $order->save();

        return $order->id;
    }

    protected function storeOrderMedicines($data,$orderId)
    {
        $medicines = $data->input('medicines');

        foreach ($medicines as $medicine){
            OrderMedicine::create([
                'medicine_id' =>  $medicine['medicine_id'],
                'quantity' => $medicine['quantity'],
                'order_id' => $orderId
            ]);
        }
        return $medicines;
    }

    protected function deductionQuantity($medicines): void
    {
        foreach ($medicines as $medicine){
            $medicineBeforeDeduction = Medicine::findOrFail($medicine['medicine_id']);
            $medicineBeforeDeduction->amount -= $medicine['quantity'];
            $medicineBeforeDeduction->save();
        }
    }

    protected function sendNotificationOrder(): void
    {}

    public function store($request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $orderId = $this->storeOrder($request);

            $medicines = $this->storeOrderMedicines($request,$orderId);

            $this->deductionQuantity($medicines);

            //$this->sendNotificationOrder();

            DB::commit();

            return response()->json([
                'status' => 201,
                'message' => 'Your order has been registered successfully'
            ],201);

        }catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

    }
}
