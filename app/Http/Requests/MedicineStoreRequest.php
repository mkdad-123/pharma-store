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
            'amount' => 'required|integer|min:1',
            'expiration_date' => 'required|date',
            'price' => 'required|numeric|min:1',
            'category' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'photo' => 'image:jpg,png,jpeg',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
