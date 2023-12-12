<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\WarehouseReview */
class WarehouseReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'pharmacist' => $this->pharmacist->name,
            'rate' => $this->rate,
        ];
    }
}
