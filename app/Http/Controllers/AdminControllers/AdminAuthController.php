<?php
namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ForgetPassword;
use App\Trait\ForgetPasswordTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    use ForgetPasswordTrait;

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
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
                'data'=> [],
                ]);
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
            return response()->json([
                'status'=> 400,
                'message' => $validator->errors()->toJson(),
                'data' => [],
            ]);
        }
        $admin = Admin::create($validator->validated());

        return response()->json([
            'status'=> 200,
            'message' => 'successfully registered',
            'admin' => $admin
        ]);
    }


    public function logout() {
        auth()->guard('admin')->logout();
        return response()->json([
            'status' => 200,
            'message' => 'successfully signed out',
            'data'=> []
        ]);
    }

    public function refresh() {
        return $this->createNewToken(auth()->guard('admin')->refresh());
    }

    protected function createNewToken($token){

        return response()->json([
            'status'=> 200,
            'message' => '',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
                'admin' => auth()->guard('admin')->user()
            ]
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'email' => 'required|exists:admins'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message'=> $validator->errors(),
                'data' => [],
            ]);

        }
        $this->emailUser = $request->email;

        return $this->forgetPassword($request);
    }

    public function checkCodeResetPassword($code)
    {
        return $this->checkCode($code);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'password' => ['required', 'confirmed',
//                Password::min(8)
//                    ->mixedCase()
//                    ->numbers()
//                    ->symbols()],
            'password' => 'required',
            'email' => 'required|exists:warehouses'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message'=> $validator->errors(),
                'data' => [],
            ]);
        }
        $warehouse = Admin::whereEmail($request->email)->first();

        $warehouse->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'password has been updated successfully',
            'data' => [],
        ]);
    }
}
