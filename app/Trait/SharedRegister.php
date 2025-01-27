<?php

namespace App\Trait;

use App\Events\WarehouseRegisterEvent;
use App\Mail\SendEmailVerification;
use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

Trait SharedRegister
{
    protected $model;

    protected OperationResult $result;

    protected function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->toJson(),
                'data'
            ]);
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

            $code = rand(1000,9999);

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

    protected function sendNotificationAdmin($user): void
    {
        event(new WarehouseRegisterEvent($user));
    }

    public function register($request)
    {
        try {

            DB::beginTransaction();

            $data = $this->validation($request);

            $email = $this->store($data);

            $user = $this->generateCode($email);

            $this->sendEmail($user);

            if($this->model instanceof Warehouse)
            {
                $this->sendNotificationAdmin($user);
            }

            DB::commit();

            $this->result->message = 'your account has been created,please check your email';
            $this->result->data = response();

        } catch (Exception $e) {

            DB::rollBack();
            $this->result->status = 500;
            $this->result->message = $e->getMessage();
        }
        return $this->result;
    }
}
