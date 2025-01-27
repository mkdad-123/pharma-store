<?php

namespace App\Http\Requests;

use App\Models\Medicine;
use Illuminate\Foundation\Http\FormRequest;

class OrderMedicineRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->filled('medicines') && is_array($this->get('medicines'))){
            $this->merge([
               'medicines_ids' => array_column($this->get('medicines'),'id')
            ]);
        }
    }

    public function rules(): array
    {
        $medicines_ids = Medicine::pluck('id')->toArray();
        return [
            'medicines' => 'required|array|min:1',
            'medicines.*.medicine_id' => 'required|integer|in:'.implode(',',$medicines_ids),
            'medicines.*.quantity' => 'required|integer|min:5',
            'medicines_ids' => 'sometimes|array|in:'.implode(',',$medicines_ids),
            'medicines_id.*' => 'integer',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'total_price' => 'required|numeric'
        ];
    }
}
