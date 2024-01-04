<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderMedicineRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|integer|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:5',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'total_price' => 'required|numeric'
        ];
    }
}
