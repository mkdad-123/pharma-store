<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment' => 'required|in:paid'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
