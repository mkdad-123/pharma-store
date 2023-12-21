<?php

namespace App\Http\Controllers\PharmacistControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacistRegisterRequest;
use App\Interfaces\CrudProfileInterface;

class PharmacistProfileController extends Controller
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

    public function updateProfile(PharmacistRegisterRequest $request)
    {
        return $this->crudRepo->update($request);
    }

    public function deleteProfile()
    {
        return $this->crudRepo->delete();
    }
}
