<?php

namespace App\Trait;

use Exception;
use Illuminate\Support\Facades\DB;

trait SharedProfileTrait
{
    protected $model;
    protected $id;

    protected function setModel($model,$id): void
    {
        $this->model = $model;
        $this->id = $id;
    }

    public function update($request)
    {
        try {

            DB::beginTransaction();

            $data = $request->all();

            $this->model->find($this->id)->update($data);

            DB::commit();

            return  response()->json([
                'status' => 200,
                'message' => 'your account has been updated successfully',
                'data'=> response(),
            ]);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json($e->getMessage());
        }
    }

    public function delete()
    {
        $this->model->find($this->id)->delete();

        return  response()->json([
            'status' => 200,
            'message' => 'your account has been deleted successfully',
            'data'=> response(),
        ]);

    }
}
