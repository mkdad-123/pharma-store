<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'rate' => 'required|integer|max:5',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
