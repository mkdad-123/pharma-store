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
                'message' => $validator->errors(),
                'data' => response(),
                ]);
        }

        return $validator->validated();
    }

    protected function isFound($email)
    {
        if (!$this->model->where('email', $email)->exists()) {
            return false;
        }
        return true;
    }

    protected function isValidData($data)
    {
        if (! $token = auth()->guard('warehouse')->attempt($data)) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
                'data' => response()
                ]);
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
            'status' => 200,
            'message' => '',
            'data' =>[
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
                'warehouse' => auth()->guard('warehouse')->user()
            ]
        ]);
    }

    public function login($request)
    {
        try {

            DB::beginTransaction();

            $data = $this->validation($request);

            if(! $this->isFound($data['email'])){
                return response()->json([
                    'status' => 404,
                    'message' => 'Account not found',
                    'data' => response()
                ]);
            }
            if (! $token = auth()->guard('warehouse')->attempt($data)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'the password is incorrect',
                    'data' => response()
                ]);
            }

            if($this->isVerified($data['email']) == null){

                return response()->json([
                    'status' => 400,
                    'message' => 'Your account is not verified',
                    'data' => response()
                ]);

            }
            if (! ($this->isValidStatus($data['email'])) ) {

                return response()->json([
                    'status' => 400,
                    'message' => 'Your account is pending',
                    'data' => response()
                ]);

            }

            DB::commit();

           return $this->createNewToken($token);

        } catch (Exception $e){

            DB::rollBack();
            return response($e->getMessage());
        }

    }

}
