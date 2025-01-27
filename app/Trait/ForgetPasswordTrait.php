<?php

namespace App\Trait;

use App\Mail\ResetPasswordEmail;
use App\Models\ForgetPassword;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

trait ForgetPasswordTrait
{
//    protected function generateCode($email)
//    {
//        try {
//            $code = rand(1000,9999);
//
//            $data = ForgetPassword::whereEmail($email)->first();
//
//            if(! $data)
//            {
//                $data = ForgetPassword::create([
//                    'email' => $email,
//                    'code' => $code,
//                    'expires_at' => Carbon::now()->addMinute(30)
//                ]);
//            }else{
//                $data = $data->update([
//                    'email' => $email,
//                    'code' => $code,
//                    'expires_at' => Carbon::now()->addMinute(30)
//                ]);
//            }
//            return $data;
//
//        }catch (Exception $e){
//
//            return response($e->getMessage());
//        }
//
//    }
    protected function sendEmail($data): void
    {
        Mail::to($data['email'])->send(new ResetPasswordEmail($data['code']));
    }

//    public function forgetPassword1($request)
//    {
//        try {
//            DB::beginTransaction();
//
//            $data = $this->generateCode($request->email);
//
//            $this->sendEmail($data);
//
//            DB::commit();
//
//            return response()->json([
//                'status' => 200,
//                'message' => 'pleas check your email',
//                'data' => response()
//            ]);
//
//        }catch (Exception $e){
//
//            DB::rollBack();
//            return response()->json($e->getMessage());
//        }
//
//    }

//    public function checkCode1($code)
//    {
//        $data = ForgetPassword::whereCode($code)
//            ->where('expires_at', '>', Carbon::now())->first();
//
//        if (!$data) {
//            return response()->json([
//                'status' => 401,
//                'message' => 'the code is not correct',
//                'data'=> response(),
//            ]);
//        }
//        $data->code = null;
//        $data->expires_at = null;
//        $data->save();
//
//        return response()->json([
//            'status' => 200,
//            'message' => 'the code is correct ,reset your password',
//            'data'=> response()
//        ]);
//    }

    public function storeCode($request){

        $passwordReset = ForgetPassword::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'code' => rand(1000,9999)
            ]);

        return $passwordReset;
    }

    public function forgetPassword($request)
    {

        try {
            DB::beginTransaction();

            $passwordReset = $this->storeCode($request);

            // send email with the token to the user

            $this->sendEmail($passwordReset);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'pleas check your email',
                'data' => response()
            ]);

        }catch (Exception $e){

            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    public function checkCode($code)
    {
        $passwordReset = ForgetPassword::where('code', $code)->first();

        if (!$passwordReset) {
            return response()->json([
                'status' => 404,
                'message' => 'This password reset token is invalid.',
                'data' => response(),
            ]);
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(30)->isPast()) {
            $passwordReset->delete();

            return response()->json([
                'status' => 404,
                'message' => 'This password reset token is expired.',
                'data' => response(),
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'This password reset token is valid.',
            'data' => response(),
        ]);
    }

}
