<?php

namespace App\Services\PharmacistService;

use App\Models\Pharmacist;
use App\ResponseManger\OperationResult;
use App\Trait\SharedRegister;

class PharmacistRegisterService
{
    use SharedRegister;

    public function __construct()
    {
        $this->model = new Pharmacist();

        $this->result = new OperationResult();
    }

}
