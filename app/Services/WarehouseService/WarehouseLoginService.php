<?php

namespace App\Services\WarehouseService;

use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use App\Trait\SharedLogin;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WarehouseLoginService
{
    use SharedLogin;

    public function __construct()
    {
        $this->model = new Warehouse();
        $this->guard = 'warehouse';
        $this->result = new OperationResult();
    }

}
