<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Medicine extends Model
{
    use HasFactory ;
        //Searchable ;

    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function favorite(): BelongsTo
    {
        return $this->belongsTo(Favorite::class);
    }


//    public function toSearchableArray(): array
//    {
//        return [
//            'id' => $this->id, // <- Always include the primary key
//            'commercial_name' => $this->commercial_name,
//            'category' => $this->category(),
//        ];
//    }

    protected $hidden = [
        'category_id',
        'company_id',
        'warehouse_id'
    ];
}
