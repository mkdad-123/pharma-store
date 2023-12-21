<?php

namespace App\Filtering;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class FilterMedicine
{
    public function filter(): array
    {
        return [
            AllowedFilter::callback('item', function (Builder $query, $value) {

                $query->where('commercial_name' , 'like' , "%{$value}%");

//                $query->whereHas('category',function (Builder $query) use ($value){
//                    $query->where('name' , 'like' , "%{$value}%");
//
//                })->orWhereHas('warehouse' , function (Builder $query) use ($value){
//                    $query->where('name','like',"%{$value}%");
//                });
            })
        ];
    }
}
