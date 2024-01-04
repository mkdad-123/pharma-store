<?php

namespace App\Http\Controllers\PharmacistControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacistRegisterRequest;
use App\Models\Pharmacist;
use App\Services\PharmasictService\PharmacistRegisterService;
use App\Trait\VerificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PharmacistAuthController extends Controller
{
    use VerificationTrait;

    public function __construct() {

        $this->middleware('auth:pharmacist', ['except' => ['login', 'register','verify']]);

        $this->setModel(new Pharmacist());
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'phone' => 'required|max:17',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors(),
                'data' => response()
            ]);
        }

        if (! $token = auth()->guard('pharmacist')->attempt($validator->validated())) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'data' => response()
            ]);
        }

        $pharmacist = Pharmacist::whereEmail($request->email)->first();

        if($pharmacist->verified == null)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Your account is not verified',
                'data' => response()
            ]);

        }

        return $this->createNewToken($token);
    }

    public function register(PharmacistRegisterRequest $request)
    {
        return (new PharmacistRegisterService())->register($request);
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
                'pharmacist' => auth()->guard('pharmacist')->user(),
            ]

        ]);
    }
}
