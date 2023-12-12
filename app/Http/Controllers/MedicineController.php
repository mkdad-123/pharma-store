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
            'data' => $medicines,
        ],200);
    }

    public function showOne($id)
    {
        $medicine = Medicine::with(['category:id,name','company:id,name','warehouse:id,name'])->find($id)
            ->makeHidden(['category_id','company_id','warehouse_id']);

        return response()->json([
            'status' => 200,
            'data' => $medicine,
        ],200);
    }

    public function store(MedicineStoreRequest $request)
    {
        return (new MedicineStoreService)->store($request);
    }

    public function show()
    {
       $medicine = QueryBuilder::for(Medicine::class)
            ->allowedFilters((new FilterMedicine)->filter())
           ->with(['category:id,name','company:id,name','warehouse:id,name'])
           ->get()->makeHidden(['category_id','company_id','warehouse_id']);

       return response()->json([
           'status' => 200,
           'data' => $medicine
       ],200);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $medicine = Medicine::search($query)->get();

        return response()->json([
            'status' => 200,
            'data' => $medicine
        ],200);
    }


    public function delete($id)
    {
        Medicine::find($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'the medicine has been deleted',
        ]);
    }

}
