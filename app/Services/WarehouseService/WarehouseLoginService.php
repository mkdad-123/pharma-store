<?php

namespace App\Services\WarehouseService;

use App\Models\Warehouse;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WarehouseLoginService
{
    protected Warehouse $model;

    public function __construct()
    {
        $this->model = new Warehouse();
    }

    protected function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->errors()
                ], 200);
        }

        return $validator->validated();
    }

    protected function isValidData($data)
    {
        if (! $token = auth()->guard('warehouse')->attempt($data)) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                ], 200);
        }
        return $token;
    }

    protected function isValidStatus($email)
    {
        $warehouse = Warehouse::whereEmail($email)->first();

        return $warehouse->status;
    }

    protected function isVerified($email)
    {
       $warehouse = Warehouse::whereEmail($email)->first();
       return $warehouse->verified;
    }

    public function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'warehouse' => auth()->guard('warehouse')->user()
        ],200);
    }

    public function login($request)
    {
        try {

            DB::beginTransaction();

            $data = $this->validation($request);

            $token = $this->isValidData($data);

            if($this->isVerified($data['email']) == null){

                return response()->json(['message' => 'Your account is not verified']);

            }
            if (! ($this->isValidStatus($data['email'])) ) {

                return response()->json(['message' => 'Your account is pending']);
            }

            DB::commit();

           return $this->createNewToken($token);

        } catch (Exception $e){

            DB::rollBack();
            return response($e->getMessage());
        }

    }

}
