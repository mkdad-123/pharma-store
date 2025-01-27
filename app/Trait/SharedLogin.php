<?php

namespace App\Trait;

use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

trait SharedLogin
{
    protected $model;

    protected string $guard;

    protected OperationResult $result;

    protected function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors(),
                'data' => response(),
            ]);
        }

        return $validator->validated();
    }

    protected function isValidData($data)
    {
        if(! $token = auth()->guard($this->guard)->attempt($data)) {
            $this->result->status = 401;
            $this->result->data = response();
            $this->result->message = 'the password or email is incorrect';
        }

        return $token;
    }

    protected function isValidStatus($email)
    {
        $warehouse = $this->model->whereEmail($email)->first();

        if(! $warehouse->status) {
            $this->result->status = 400;
            $this->result->data = response();
            $this->result->message = 'Your account is pending';
        }
        return $warehouse->status;
    }

    protected function isVerified($email)
    {
        $warehouse = $this->model->whereEmail($email)->first();

        if ($warehouse->verified == null){
            $this->result->status = 400;
            $this->result->data = response();
            $this->result->message = 'Your account is not verified';
        }
        return $warehouse->verified;
    }

    public function login($request)
    {
        try {

            DB::beginTransaction();

            $data = $this->validation($request);

            if (! $token = $this->isValidData($data)){
                return $this->result;
            }

            if (! $this->isVerified($data['email'])){
                return $this->result;
            }

            if ($this->model instanceof Warehouse){{

                if (! $this->isValidStatus($data['email'])){
                    return $this->result;
                }
            }}


            DB::commit();

            $this->result->data = $token;


        } catch (Exception $e){

            DB::rollBack();

            $this->result->message = $e->getMessage();
            $this->result->data = response();
            $this->result->status = 500;
        }
        return $this->result;
    }

}
