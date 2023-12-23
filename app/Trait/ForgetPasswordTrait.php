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
    protected function generateCode($email)
    {
        try {
            $code = bin2hex(random_bytes(4));

            $data = ForgetPassword::whereEmail($email)->first();

            if(! $data)
            {
                $data = ForgetPassword::create([
                    'email' => $email,
                    'code' => $code,
                    'expires_at' => Carbon::now()->addMinute(30)
                ]);
            }else{
                $data = $data->update([
                    'email' => $email,
                    'code' => $code,
                    'expires_at' => Carbon::now()->addMinute(30)
                ]);
            }
            return $data;

        }catch (Exception $e){

            return response($e->getMessage());
        }

    }
    protected function sendEmail($data): void
    {
        Mail::to($data['email'])->send(new ResetPasswordEmail($data['code']));
    }

    public function forgetPassword($request)
    {
        try {
            DB::beginTransaction();

            $data = $this->generateCode($request->email);

            $this->sendEmail($data);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'pleas check your email',
                'data' => []
            ]);

        }catch (Exception $e){

            DB::rollBack();
            return response()->json($e->getMessage());
        }

    }

    public function checkCode($code)
    {
        $data = ForgetPassword::whereCode($code)
            ->where('expires_at', '>', Carbon::now())->first();

        if (!$data) {
            return response()->json([
                'status' => 401,
                'message' => 'the code is not correct',
                'data'=> [],
            ]);
        }
        $data->code = null;
        $data->expires_at = null;
        $data->save();

        return response()->json([
            'status' => 200,
            'message' => 'the code is correct ,reset your password',
            'data'=> []
        ]);
    }
}
