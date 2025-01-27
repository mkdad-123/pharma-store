<?php

namespace App\Trait;

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
        $medicines = $this->model->with([
            'medicines.category:id,name',
            'medicines.company:id,name',
            'medicines.warehouse:id,name',
            ])->get(['id','name']);

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
