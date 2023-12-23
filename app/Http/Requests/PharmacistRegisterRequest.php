<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PharmacistRegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:pharmacists',
            'phone' => 'required||regex:/^09/|unique:pharmacists',
//            'password' => ['required','confirmed',
//                Password::min(8)
//                    ->mixedCase()
//                    ->numbers()
//                    ->symbols()],
            'password' => 'required',
            'location' => 'required|string',
        ];
    }
}
