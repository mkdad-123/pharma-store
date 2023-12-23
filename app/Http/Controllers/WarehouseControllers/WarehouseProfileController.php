<?php

namespace App\Http\Controllers\WarehouseControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseRegisterRequest;
use App\Interfaces\CrudProfileInterface;
use Illuminate\Http\Request;

class WarehouseProfileController extends Controller
{
    protected CrudProfileInterface $crudRepo;

    public function __construct(CrudProfileInterface $crudRepo)
    {
        $this->crudRepo = $crudRepo;
    }

    public function showProfile()
    {
        return $this->crudRepo->show();
    }

    public function updateProfile(Request $request)
    {
        return $this->crudRepo->update($request);
    }

    public function deleteProfile()
    {
        return $this->crudRepo->delete();
    }
}
