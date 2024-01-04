<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class WarehouseRegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:warehouses',
            'phone' => 'required',
            //||regex:/^09/',
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
