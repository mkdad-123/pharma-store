<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function acceptedWarehouse($id)
    {
        Warehouse::find($id)->update(['status' => 1]);
        return response()->json([
            'status' => 200,
            'message' => 'the status warehouse has been changed',
            'data'=> response(),
        ]);
    }

    public function deleteWarehouse($id)
    {
        Warehouse::find($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'the warehouse has been deleted',
            'data'=> response(),
        ]);
    }

    public function addCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:companies',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 200,
                'message' => $validator->errors(),
                'data'=> response(),
            ]);
        }
        Company::create(['name' => $request->input('name')]);

        return response()->json([
            'status' => 200,
            'message' => 'Company has been created successfully',
            'data'=> response(),
        ]);
    }
}
