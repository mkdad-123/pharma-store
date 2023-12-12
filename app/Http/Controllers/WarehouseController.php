<?php

namespace App\Http\Controllers;

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
