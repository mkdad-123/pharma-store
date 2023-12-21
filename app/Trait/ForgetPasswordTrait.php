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
                $data->update([
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
        Mail::to($data->email)->send(new ResetPasswordEmail($data->code));
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
                'message' => 'pleas check your email'
            ]);

        }catch (Exception $e){
            DB::rollBack();
            return response()->json($e->getMessage());
        }

    }

}
