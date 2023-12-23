<?php

namespace App\Trait;

use App\Models\Category;

trait DatawithMedicineTrait
{
    protected $model;

    public function setmodel($model)
    {
        $this->model = $model;
    }

    public function show()
    {
        $data = $this->model->all(['id','name']);

        return response()->json([
                'status' => 200,
                'message' => '',
                'data' => $data
            ]);
    }

    public function showWithMedicines()
    {
        $medicines = $this->model->with(['medicines' => function($query){
            $query->select(['category_id','company_id','warehouse_id','id','commercial_name','scientific_name','amount'
                ,'expiration_date','price','photo','created_at','updated_at']);
        }, 'medicines.warehouse:id,name',
            'medicines.category'])
            ->get(['id','name']);
        $medicines->each(function ($category) {
            $category->medicines->makeHidden(['category_id', 'company_id', 'warehouse_id']);
        });

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => $medicines
        ]);
    }
}
