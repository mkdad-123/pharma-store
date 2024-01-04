<?php

namespace App\Services\PharmasictService;

use App\Models\Pharmacist;
use App\Trait\SharedRegister;

class PharmacistRegisterService
{
    use SharedRegister;

    public function __construct()
    {
        $this->setModel(new Pharmacist());
    }

}
