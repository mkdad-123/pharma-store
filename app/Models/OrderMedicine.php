<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderMedicine extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function category()
    {
        return $this->hasOneThrough(Category::class,Medicine::class);
    }

    public function scopeCheck($query)
    {
        $clientId = auth('pharmacist')->id();

        return $query->where('pharmacist_id',$clientId);
    }
}
