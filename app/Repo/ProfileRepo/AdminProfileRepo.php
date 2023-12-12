<?php

namespace App\Repo\ProfileRepo;

use App\Interfaces\CrudProfileInterface;
use App\Models\Admin;
use App\Trait\SharedProfileTrait;

class AdminProfileRepo implements CrudProfileInterface
{
    use SharedProfileTrait;

    public function __construct()
    {
        $this->setModel(new Admin(),auth()->guard('admin')->id());
    }

    public function show()
    {
        $adminId = auth()->guard('admin')->id();

        $admin = Admin::find($adminId);

        return response()->json([
            'status' => 200,
            'data' => $admin
        ]);
    }
}
