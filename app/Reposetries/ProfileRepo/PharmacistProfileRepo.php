<?php

namespace App\Reposetries\ProfileRepo;

use App\Interfaces\CrudProfileInterface;
use App\Models\Pharmacist;
use App\Trait\SharedProfileTrait;

class PharmacistProfileRepo implements CrudProfileInterface
{
    use SharedProfileTrait;

    public function __construct()
    {
        $this->setModel(new Pharmacist(),auth()->guard('pharmacist')->id());
    }

    public function show()
    {
        $pharmacistId = auth()->guard('pharmacist')->id();

        $pharmacist = Pharmacist::with(['reviews','orders','favorites'])->find($pharmacistId);

        return  response()->json([
            'status' => 200,
            'message' => '',
            'data' => $pharmacist,
        ]);
    }
}
