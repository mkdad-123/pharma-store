<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Http\Request;

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

    public function addCompany(CategoryRequest $request)
    {

        Company::create(['name' => $request->input('name')]);

        return response()->json([
            'status' => 201,
            'message' => 'Company has been created successfully',
        ]);
    }
}
