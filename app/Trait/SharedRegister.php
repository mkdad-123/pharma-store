<?php

namespace App\Trait;

use App\Mail\SendEmailVerification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

Trait SharedRegister
{
    protected $model;

    protected function setModel($model): void
    {
        $this->model = $model;
    }

    protected function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'error' => $validator->errors()->toJson(),
            ],422);
        }

        return $validator->validated();
    }

    protected function store($data)
    {
        $user = $this->model->create($data);

        return $user->email;
    }

    protected function generateCode($email)
    {
        try {

            $code = bin2hex(random_bytes(4));

            $user = $this->model->whereEmail($email)->first();

            $user->verification_token = $code;

            $user->verified = null;

            $user->expires_at = Carbon::now()->addMinute(30);

            $user->save();

            return $user;

        }catch (Exception $e){

            return response($e->getMessage());
        }


    }
    protected function sendEmail($user): void
    {
        Mail::to($user->email)->send(new SendEmailVerification($user));
    }

    public function register($request)
    {
        try {

            DB::beginTransaction();

            $data = $this->validation($request);

            $email = $this->store($data);

            $user = $this->generateCode($email);

             $this->sendEmail($user);

            DB::commit();

            return response()->json([
                'status' => 201,
                'message' => 'your account has been created , please check your email',
            ], 201);

        } catch (Exception $e) {

            DB::rollBack();
            return response($e->getMessage());
        }
    }
}
