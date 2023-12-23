<?php

namespace App\Http\Controllers;

use App\Filtering\FilterMedicine;
use App\Http\Requests\MedicineStoreRequest;
use App\Models\Medicine;
use App\Services\MedicineService\MedicineStoreService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MedicineController extends Controller
{
    public function showAll()
    {
        $medicines = Medicine::with(['category:id,name','company:id,name','warehouse:id,name'])->get()
            ->makeHidden(['category_id','company_id','warehouse_id']);

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $medicines,
        ]);
    }

    public function showOne($id)
    {
        $medicine = Medicine::with(['category:id,name','company:id,name','warehouse:id,name'])->find($id)
            ->makeHidden(['category_id','company_id','warehouse_id']);

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $medicine,
        ]);
    }

    public function store(MedicineStoreRequest $request)
    {
        return (new MedicineStoreService)->store($request);
    }

    public function searchNames()
    {
       $medicine = QueryBuilder::for(Medicine::class)
            ->allowedFilters((new FilterMedicine)->filterNames())
           ->with(['category:id,name','company:id,name','warehouse:id,name'])
           ->get()->makeHidden(['category_id','company_id','warehouse_id']);

       return response()->json([
           'status' => 200,
           'message' => '',
           'data' => $medicine
       ]);
    }

    public function searchCategories()
    {
        $medicine = QueryBuilder::for(Medicine::class)
            ->allowedFilters((new FilterMedicine)->filterCategories())
            ->with(['category:id,name','company:id,name','warehouse:id,name'])
            ->get()->makeHidden(['category_id','company_id','warehouse_id']);

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $medicine
        ]);
    }
    public function showWarehouseMedicines()
    {
        $medicines = Medicine::with(['category:id,name','company:id,name','warehouse:id,name'])
            ->whereId(auth()->guard('warehouse')->id())
            ->get()
            ->makeHidden(['category_id','company_id','warehouse_id']);

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $medicines,
        ]);
    }
//    public function search(Request $request)
//    {
//        $query = $request->input('query');
//        $medicine = Medicine::search($query)->get();
//
//        return response()->json([
//            'status' => 200,
//            'message' => '',
//            'data' => $medicine
//        ]);
//    }


    public function delete($id)
    {
        Medicine::find($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'the medicine has been deleted',
            'data'=> [],
        ]);
    }

}
