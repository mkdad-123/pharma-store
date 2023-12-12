<?php
namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:admins',
            'password' => 'required|confirmed|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $admin = Admin::create($validator->validated());
        return response()->json([
            'message' => 'User successfully registered',
            'admin' => $admin
        ], 201);
    }


    public function logout() {
        auth()->guard('admin')->logout();
        return response()->json(['message' => 'User successfully signed out'],200);
    }

    public function refresh() {
        return $this->createNewToken(auth()->guard('admin')->refresh());
    }

    public function userProfile() {
        return response()->json(['admin' => auth()->guard('admin')->user()],200);
    }

    protected function createNewToken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'admin' => auth()->guard('admin')->user()
        ]);
    }
}
