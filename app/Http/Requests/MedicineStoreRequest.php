<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'commercial_name' => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
            'expiration_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'photo' => 'required|image:jpg,png,jpeg|max:2048',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
