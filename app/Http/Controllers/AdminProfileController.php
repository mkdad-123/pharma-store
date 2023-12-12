<?php

namespace App\Http\Controllers;

use App\Interfaces\CrudProfileInterface;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    protected CrudProfileInterface $profileRepo;

    public function __construct(CrudProfileInterface $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }

    public function showProfile()
    {
        return $this->profileRepo->show();
    }

    public function updateProfile(Request $request)
    {
        return $this->profileRepo->update($request);
    }

    public function deleteProfile()
    {
        return $this->profileRepo->delete();
    }
}
