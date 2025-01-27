<?php
namespace App\Http\Controllers\WarehouseControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\WarehouseLoginRequest;
use App\Http\Requests\WarehouseRegisterRequest;
use App\Models\Warehouse;
use App\Services\WarehouseService\WarehouseLoginService;
use App\Services\WarehouseService\WarehouseRegisterService;
use App\Trait\ForgetPasswordTrait;
use App\Trait\VerificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class WarehouseAuthController extends Controller
{
    use VerificationTrait,ForgetPasswordTrait;

    public function __construct() {

        $this->middleware('auth:warehouse', ['only' => ['logout', 'refresh']]);

        $this->setModel(new Warehouse());
    }

    public function register(WarehouseRegisterRequest $request)
    {
        $result = (new WarehouseRegisterService)->register($request);

        return response()->json([
            'status' => $result->status,
            'message' => $result->message,
            'data' => $result->data
        ]);
    }

    public function login(WarehouseLoginRequest $request)
    {
         $result = (new WarehouseLoginService())->login($request);

         if($result->status == 200){

             return $this->createNewToken($result->data);

         }else {
             return response()->json([
                 'status' => $result->status,
                 'message' => $result->message,
                 'data'=> $result->data,
             ]);
         }
    }

    public function logout() {

        auth()->guard('warehouse')->logout();

        return response()->json([
            'status' => 200,
            'message' => 'User successfully signed out',
            'data'=> response(),
        ]);
    }

    public function refresh() {

        return $this->createNewToken(auth()->guard('warehouse')->refresh());
    }

    protected function createNewToken($token)
    {
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
        $warehouse = Warehouse::whereEmail($request->email)->first();

        $warehouse->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'password has been updated successfully',
            'data'=> response(),
        ]);

    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $warehouse = Warehouse::where('email', $googleUser->email)->first();

        if(!$warehouse)
        {
            $warehouse = Warehouse::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'phone' => '0999999999',
                'location' => '',
                'password' => bcrypt('password')
            ]);
        }

        $token = Auth::guard('warehouse')->attempt([
            'email' => $googleUser->email,
            'password'=> 'password',
        ]);

        return $this->createNewToken($token);
    }

}
