<?php

namespace App\Trait;

use App\Http\Requests\SharedRequest;

trait CrudTrait
{
    protected $model;

    public function setModelCrud($model)
    {
        $this->model = $model;
    }

    public function add(SharedRequest $request)
    {

        $this->model->create(['name' => $request->input('name')]);

        return response()->json([
            'status' => 200,
            'message' => 'Data has been created successfully',
            'data'=> response(),
        ]);
    }

    public function update(SharedRequest $request,$id)
    {
        $data = $this->model->find($id);
        $data->update(['name' => $request->input('name')]);

        return response()->json([
            'status' => 200,
            'message' => 'Data has been created successfully',
            'data'=> response(),
        ]);

    }
    public function delete($id)
    {
        $this->model->find($id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Data has been deleted successfully',
            'data'=> response(),
        ]);
    }
}
