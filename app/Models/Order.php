<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['status' , 'payment'];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function pharmacist(): BelongsTo
    {
        return $this->belongsTo(Pharmacist::class);
    }

    public function orderMedicines(): HasMany
    {
        return $this->hasMany(OrderMedicine::class);
    }
}
