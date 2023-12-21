<?php

namespace App\Services\WarehouseService;

use App\Models\Warehouse;
use App\Trait\SharedRegister;

class WarehouseRegisterService
{
    use SharedRegister;

    public function __construct()
    {
        $this->setModel(new Warehouse());
    }

}
