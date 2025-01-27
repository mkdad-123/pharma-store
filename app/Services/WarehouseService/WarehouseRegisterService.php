<?php

namespace App\Services\WarehouseService;

use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use App\Trait\SharedRegister;

class WarehouseRegisterService
{
    use SharedRegister;

    public function __construct()
    {
        $this->model = new Warehouse();

        $this->result = new OperationResult();
    }

}
