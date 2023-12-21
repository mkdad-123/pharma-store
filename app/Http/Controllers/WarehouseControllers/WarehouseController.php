<?php

namespace App\Http\Controllers\WarehouseControllers;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Trait\DatawithMedicineTrait;

class WarehouseController extends Controller
{
    use DatawithMedicineTrait;

    public function __construct()
    {
        $this->setmodel(new Warehouse());
    }
}
