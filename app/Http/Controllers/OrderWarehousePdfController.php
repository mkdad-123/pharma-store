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


         $orders = getOrderWithPharmacist()->whereBetween('created_at',[$request->fromDate,$request->toDate])
             ->whereWarehouseId($warehouse->id)->get();

         $pdf = PDF::loadView('pdf.reportWarehouse',
             array('orders' =>  $orders, 'warehouse' => $warehouse)
         )->setPaper('a4', 'portrait');

         return $pdf->stream();
     }

}
