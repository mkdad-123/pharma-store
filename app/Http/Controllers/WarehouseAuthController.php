<?php
namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRegisterRequest;
use App\Http\Requests\WarehouseLoginRequest;
use App\Models\Warehouse;
use App\Services\WarehouseService\WarehouseLoginService;
use App\Services\WarehouseService\WarehouseRegisterService;
use App\Trait\VerificationTrait;
use Illuminate\Support\Facades\Auth;

class WarehouseAuthController extends Controller
{
    use VerificationTrait;

    public function __construct() {

        $this->middleware('auth:warehouse', ['except' => ['login', 'register' , 'verify']]);

        $this->setModel(new Warehouse());
    }

    public function register(WarehouseRegisterRequest $request)
    {
        return (new WarehouseRegisterService)->register($request);
    }

    public function login(WarehouseLoginRequest $request)
    {
        return (new WarehouseLoginService())->login($request);
    }

    public function logout() {

        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh() {

        return $this->createNewToken(auth()->guard('warehouse')->refresh());
    }

    public function userProfile() {

        return response()->json(auth()->guard('warehouse')->user());
    }

    protected function createNewToken($token){

        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'warehouse' => auth()->guard('warehouse')->user()
        ]);
    }



}
