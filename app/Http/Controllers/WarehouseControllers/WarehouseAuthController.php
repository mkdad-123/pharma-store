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
use Illuminate\Validation\Rules\Password;

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

        auth()->guard('warehouse')->logout();

        return response()->json([
            'status' => 200,
            'message' => 'User successfully signed out',
            'data'=> [],
        ]);
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
        $validator  = Validator::make($request->all(),[
            'password' => ['required','confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
            'email' => 'required|exists:warehouses'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message'=> $validator->errors(),
                'data' => [],
            ]);
        }
        $warehouse = Warehouse::whereEmail($request->email)->first();

        $warehouse->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'password has been updated successfully',
            'data'=> [],
        ]);

    }








}
