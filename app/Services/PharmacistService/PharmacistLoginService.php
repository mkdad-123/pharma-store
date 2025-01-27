<?php

namespace App\Services\PharmacistService;

use App\Models\Pharmacist;
use App\ResponseManger\OperationResult;
use App\Trait\SharedLogin;

class PharmacistLoginService
{
    use SharedLogin;

    public function __construct()
    {
        $this->model = new Pharmacist();
        $this->guard = 'pharmacist';
        $this->result = new OperationResult();
    }
}
