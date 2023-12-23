<?php

namespace App\Http\Controllers\PharmacistControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacistRegisterRequest;
use App\Models\Pharmacist;
use App\Services\PharmasictService\ParmasictRegisterService;
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
                'data' => []
            ]);
        }

        if (! $token = auth()->guard('pharmacist')->attempt($validator->validated())) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'data' => []
            ]);
        }

        return $this->createNewToken($token);
    }

    public function register(PharmacistRegisterRequest $request)
    {
        return (new ParmasictRegisterService())->register($request);
    }


    public function logout() {

        auth()->guard('pharmacist')->logout();

        return response()->json([
            'status' => 200,
            'message' => 'pharmacist successfully signed out',
            'data' => []
            ]);
    }

    public function refresh() {

        return $this->createNewToken(auth()->guard('pharmacist')->refresh());
    }

    protected function createNewToken($token){

        Auth::factory()->setTTL(360);

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
