<?php

namespace App\Services\OrderServices;

use App\Events\NewOrderEvent;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Models\Warehouse;
use App\Notifications\OrderNotification;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderStoreService
{
    protected OperationResult $result;

    public function __construct()
    {
        $this->result = new OperationResult();
    }

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
        $order = getOrderWithPharmacist()
            ->whereId($orderId)->get();

        // real time notification
        event(new NewOrderEvent($order,$warehouseId));

        // store notification in database
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

            $this->result->message = 'Your order has been registered successfully';
            $this->result->data = response();

        }catch (Exception $e) {
            DB::rollBack();
            $this->result->status = 500;
            $this->result->message = $e->getMessage();
        }
        return $this->result;
    }
}
