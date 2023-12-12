<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function scopeFavoriteWarehouse($query)
    {
        $pharmacistId = auth()->guard('pharmacist')->id();
        return $query->where('pharmacist_id',$pharmacistId)
            ->where('medicine_id',null);
    }

    public function scopeFavoriteMedicines($query)
    {
        $pharmacistId = auth()->guard('pharmacist')->id();
        return $query->where('pharmacist_id',$pharmacistId)
            ->where('warehouse_id',null);
    }
}
