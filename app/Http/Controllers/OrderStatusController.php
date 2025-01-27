<?php

namespace App\Http\Controllers;

use App\Events\ChangeOrderStatusEvent;
use App\Http\Requests\OrderStatusRequest;
use App\Http\Requests\PaymentStatusRequest;
use App\Models\Order;
use App\Models\Pharmacist;
use App\Notifications\ChangeOrderStatusNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderStatusController extends Controller
{
    public function changeStatusOrder(OrderStatusRequest $request,$id)
    {
        try {

            DB::beginTransaction();

            $order = getOrderWithWarehouse()->find($id);

            $order->setAttribute('status',$request->status)->save();

            event(new ChangeOrderStatusEvent($request->status,$order['pharmacist_id']));

            Notification::send($order->pharmacist, new ChangeOrderStatusNotification($request->status,$order));

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'The order status has changed ',
                'data'=> response(),
            ]);

        }catch (Exception $e){
            DB::rollBack();
            return response($e->getMessage());
        }

    }

    public function changeStatusPayment(PaymentStatusRequest $request,$id)
    {
        $order = Order::findOrFail($id);

        $order->setAttribute('payment',$request->payment)->save();

        return response()->json([
            'status' => 200,
            'message' => 'The payment status has changed ',
            'data'=> response(),
        ]);
    }


}
