<?php

namespace App\Trait;

use Carbon\Carbon;

trait VerificationTrait
{
    protected $model;

    protected function setModel($model)
    {
        $this->model = $model;
    }

    protected function verify($code)
    {
        $user = $this->model->whereVerificationToken($code)
            ->where('expires_at','>',Carbon::now())
            ->first();

        if(! $user){
            return response()->json([
                'status' => 401,
                'message' => 'your account is not verified'
            ],200);
        }

        $user->verification_token = null;
        $user->expires_at = null;
        $user->verified = now();
        $user->save();

        return  response()->json([
            'status' => 200,
            'message' => 'your account has been confirmed'
        ],200);

    }
}
