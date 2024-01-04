<?php

namespace App\Services\OrderServices;

use App\Events\NewOrderEvent;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Models\Warehouse;
use App\Notifications\OrderNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderStoreService
{
    protected function storeOrder($data)
    {
        $warehouseId = $data->input('warehouse_id');
        $order = new Order();
        $order->pharmacist_id = auth()->guard('pharmacist')->id();
        $order->warehouse_id = $warehouseId;
        $order->total_price = $data->total_price;
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
        $order = Order::with([
            'orderMedicines.medicine.category:id,name',
            'orderMedicines.medicine.company:id,name',
            'orderMedicines.medicine.warehouse:id,name',
            'pharmacist',
        ])->whereId($orderId)->get();

        // real time notification
        event(new NewOrderEvent($order,$warehouseId));

        // database notification
        $warehouse = Warehouse::whereId($warehouseId)->get();
        Notification::send($warehouse, new OrderNotification($warehouse,$order));
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
                'data'=> response(),
            ]);

        }catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage());
        }

    }
}
