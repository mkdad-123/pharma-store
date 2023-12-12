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
                'data' => $data
            ],200);
    }

    public function showWithMedicines()
    {
        $medicines = $this->model->with('medicines')->get();

        return response()->json([
            'status' => 200,
            'data' => $medicines
        ],200);
    }
}
