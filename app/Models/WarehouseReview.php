<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseReview extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function pharmacist(): BelongsTo
    {
        return $this->belongsTo(Pharmacist::class);
    }
}
