<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;

class AdminController extends Controller
{
    public function acceptedWarehouse($id)
    {
        Warehouse::find($id)->update(['status' => 1]);
        return response()->json([
            'status' => 200,
            'message' => 'the status warehouse has been changed',
        ]);
    }

    public function deleteWarehouse($id)
    {
        Warehouse::find($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'the warehouse has been deleted',
        ]);
    }
}
