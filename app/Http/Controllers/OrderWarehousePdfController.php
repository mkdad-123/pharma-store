<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderWarehousePdfController extends Controller
{
    public function viewPDF(Request $request)
    {
         $warehouse = auth()->guard('warehouse')->user();


         $orders = Order::whereBetween('created_at',[$request->fromDate,$request->toDate])
             ->with([
             'orderMedicines.medicine.category:id,name',
             'orderMedicines.medicine.company:id,name',
             'orderMedicines.medicine.warehouse:id,name',
             'pharmacist',
         ])->whereWarehouseId($warehouse->id)->get();

         $orders->each(function ($order) {
             $order->orderMedicines->each(function ($orderMedicines) {
                 $orderMedicines->medicine->makeHidden(['category_id', 'company_id', 'warehouse_id']);
             });
         });

         $pdf = PDF::loadView('pdf.reportWarehouse',
             array('orders' =>  $orders, 'warehouse' => $warehouse)
         )->setPaper('a4', 'portrait');

         return $pdf->stream();
     }

}
