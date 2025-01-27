<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required','confirmed'],
//                Password::min(8)
//                    ->mixedCase()
//                    ->numbers()
//                    ->symbols()],
            'email' => 'required|exists:warehouses'
        ];
    }
}
