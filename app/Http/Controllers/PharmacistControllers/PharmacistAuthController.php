<?php

namespace App\Http\Controllers\PharmacistControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacistLoginRequest;
use App\Http\Requests\PharmacistRegisterRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Pharmacist;
use App\Services\PharmacistService\PharmacistLoginService;
use App\Services\PharmacistService\PharmacistRegisterService;
use App\Trait\ForgetPasswordTrait;
use App\Trait\VerificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PharmacistAuthController extends Controller
{
    use VerificationTrait , ForgetPasswordTrait;

    public function __construct() {

        $this->middleware('auth:pharmacist', ['only' => ['logout','refresh']]);

        $this->setModel(new Pharmacist());
    }

    public function login(PharmacistLoginRequest $request)
    {
        $result = (new PharmacistLoginService())->login($request);

        if($result->status == 200){

            return $this->createNewToken($result->data);

        } else {
            return response()->json([
                'status' => $result->status,
                'message' => $result->message,
                'data'=> $result->data,
            ]);
        }

    }

    public function register(PharmacistRegisterRequest $request)
    {
        $result = (new PharmacistRegisterService())->register($request);

        return response()->json([
            'status' => $result->status,
            'message' => $result->message,
            'data' => $result->data
        ]);
    }


    public function logout() {

        auth()->guard('pharmacist')->logout();

        return response()->json([
            'status' => 200,
            'message' => 'pharmacist successfully signed out',
            'data' => response()
            ]);
    }

    public function refresh() {

        return $this->createNewToken(auth()->guard('pharmacist')->refresh());
    }

    protected function createNewToken($token){

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ]
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'email' => 'required|exists:warehouses'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message'=> $validator->errors(),
                'data' => response(),
            ]);
        }

        return $this->forgetPassword($request);
    }

    public function checkCodeResetPassword($code)
    {
        return $this->checkCode($code);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $pharmacist = Pharmacist::whereEmail($request->email)->first();

        $pharmacist->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'password has been updated successfully',
            'data'=> response(),
        ]);

    }
}
