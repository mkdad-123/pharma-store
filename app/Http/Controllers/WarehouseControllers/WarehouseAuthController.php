<?php
namespace App\Http\Controllers\WarehouseControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseLoginRequest;
use App\Http\Requests\WarehouseRegisterRequest;
use App\Models\ForgetPassword;
use App\Models\Warehouse;
use App\Services\WarehouseService\WarehouseLoginService;
use App\Services\WarehouseService\WarehouseRegisterService;
use App\Trait\ForgetPasswordTrait;
use App\Trait\VerificationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WarehouseAuthController extends Controller
{
    use VerificationTrait,ForgetPasswordTrait;

    public function __construct() {

        $this->middleware('auth:warehouse', ['only' => ['logout', 'refresh']]);

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

        return (new WarehouseLoginService())->createNewToken(auth()->guard('warehouse')->refresh());
    }

    public function resetPassword(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'email' => 'required|exists:warehouses'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        return $this->forgetPassword($request);
    }

    public function checkCodeResetPassword($code)
    {
        $data = ForgetPassword::whereCode($code)
            ->where('expires_at','>',Carbon::now())->first();

        if(! $data){
            return response()->json([
                'status' => 401,
                'message' => 'the code is not correct'
            ]);
        }
        $data->code = null;
        $data->expires_at = null;
        $data->save();
        return response()->json([
            'status' => 200,
            'message' => 'the code is correct ,reset your password'
        ]);
    }

    public function updatePassword(Request $request)
    {

    }








}
