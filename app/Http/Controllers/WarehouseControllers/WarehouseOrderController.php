<?php

namespace App\Http\Controllers\WarehouseControllers;

use App\Http\Controllers\Controller;
use App\Interfaces\CrudRepoInterface;

class WarehouseOrderController extends Controller
{
    protected CrudRepoInterface $crudRepo;

    public function __construct(CrudRepoInterface $crudRepo)
    {
        $this->crudRepo = $crudRepo;
    }

    public function showAllOrder()
    {
        return $this->crudRepo->showAll();
    }

    public function showOneOrder($id)
    {
        return $this->crudRepo->showOne($id);
    }
}
