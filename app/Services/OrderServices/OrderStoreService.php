<?php

namespace App\Services\OrderServices;

use App\Events\NewOrderEvent;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use Exception;
use Illuminate\Http\JsonResponse;
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

    protected function sendNotificationOrder($orderId,$warehouseId)
    {
        $order = Order::with(['orderMedicines','pharmacist:id,name'])
            ->whereId($orderId)
            ->get(['id','status','payment']);

        event(new NewOrderEvent($order,$warehouseId));
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $orderId = $this->storeOrder($request);

            $medicines = $this->storeOrderMedicines($request,$orderId);

            $this->deductionQuantity($medicines);

            $this->sendNotificationOrder($orderId,$request->input('warehouse_id'));

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Your order has been registered successfully',
                'data'=> [],
            ]);

        }catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage());
        }

    }
}
