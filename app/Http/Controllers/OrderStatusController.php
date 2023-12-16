<?php

namespace App\Http\Controllers;

use App\Events\ChangeOrderStatusEvent;
use App\Http\Requests\OrderStatusRequest;
use App\Http\Requests\PaymentStatusRequest;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderStatusController extends Controller
{
    public function changeStatusOrder(OrderStatusRequest $request,$id)
    {
        try {

            DB::beginTransaction();

            $order = Order::findOrFail($id);

            $order->setAttribute('status',$request->status)->save();

            event(new ChangeOrderStatusEvent($order['status'],$order['pharmacist_id']));

            DB::commit();

            return response()->json([
                'status' => 201,
                'message' => 'The order status has changed '
            ]);

        }catch (Exception $e){
            DB::rollBack();
            return response()->json($e->getMessage());
        }

    }

    public function changeStatusPayment(PaymentStatusRequest $request,$id)
    {
        $order = Order::findOrFail($id);

        $order->setAttribute('payment',$request->payment)->save();

        return response()->json([
            'status' => 201,
            'message' => 'The payment status has changed '
        ]);
    }


}
