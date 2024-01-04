<?php

namespace App\Services\MedicineService;

use App\Models\Category;
use App\Models\Company;
use App\Models\Medicine;
use Exception;
use Illuminate\Support\Facades\DB;

class MedicineStoreService
{
    protected Medicine $model;

    public function __construct()
    {
        $this->model = new Medicine();
    }

    protected function adminPercent($price): float
    {
        $discount = $price * 0.01;
        return $price - $discount;
    }

    protected function storeCategory($categoryName)
    {
        $category =  Category::whereName($categoryName)->first();

        if(! $category){
            return response()->json([
                'status' => 400,
                'message' => 'Category is not found'
            ]);
        }
        return $category->id;
    }

    protected function storeCompany($companyName)
    {
        $company = Company::whereName($companyName)->first();

        if(! $company){
            $company = Company::create(['name' => $companyName]);
        }
        return $company->id;
    }

    protected function storeMedicine($request,$categoryId ,$companyId): Medicine
    {
        $medicine = $request->except('category','company','photo');

        if($request->hasFile('photo')) {

            $photo = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('images', $photo, 'public');
            $medicine['photo'] = $path;
        }

        $medicine['category_id'] = $categoryId;
        $medicine['company_id'] = $companyId;
        $medicine['price'] = $this->adminPercent($request->price);
        $medicine['warehouse_id'] = auth()->guard('warehouse')->id();


        $medicineStored = $this->model->create($medicine);

        return $medicineStored;

    }


    public function store($request)
    {
        try {
            DB::beginTransaction();

            $categoryId = $this->storeCategory($request->category);

            $companyId = $this->storeCompany($request->company);

            $medicine = $this->storeMedicine($request,$categoryId ,$companyId);

            DB::commit();

            return response()->json([
                'status' => 201,
                'message' => 'Medicine has been created successfully',
                'your price after discount is ' => $medicine->price,
            ]);

        }catch (Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],400);
        }


    }

}
