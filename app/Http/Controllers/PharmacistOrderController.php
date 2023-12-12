<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderMedicineRequest;
use App\Interfaces\CrudRepoInterface;

class PharmacistOrderController extends Controller
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

    public function addOrder(OrderMedicineRequest $request)
    {
        return $this->crudRepo->store($request);
    }

}
