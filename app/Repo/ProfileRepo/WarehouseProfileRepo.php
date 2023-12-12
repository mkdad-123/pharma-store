<?php

namespace App\Repo\ProfileRepo;

use App\Interfaces\CrudProfileInterface;
use App\Models\Warehouse;
use App\Trait\SharedProfileTrait;

class WarehouseProfileRepo implements CrudProfileInterface
{
    use SharedProfileTrait;

    public function __construct()
    {
        $this->setModel(new Warehouse(),auth()->guard('warehouse')->id());
    }

    public function show()
    {
        $warehouseId = auth()->guard('warehouse')->id();
        $warehouse = Warehouse::with(['reviews','medicines'])->find($warehouseId);

        return  response()->json([
            'status' => 200,
            'data' => $warehouse
        ]);
    }


}
