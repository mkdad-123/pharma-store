<?php

namespace App\Providers;

use App\Http\Controllers\PharmacistControllers\PharmacistOrderController;
use App\Http\Controllers\WarehouseControllers\WarehouseOrderController;
use App\Interfaces\CrudRepoInterface;
use App\Reposetries\PharmacistOrderRepo;
use App\Reposetries\WarehouseOrderRepo;
use Illuminate\Support\ServiceProvider;

class CrudRepoProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->when(PharmacistOrderController::class)
            ->needs(CrudRepoInterface::class)
            ->give(function () {
                return new PharmacistOrderRepo();
            });

        $this->app->when(WarehouseOrderController::class)
            ->needs(CrudRepoInterface::class)
            ->give(function () {
                return new WarehouseOrderRepo();
            });
    }


    public function boot(): void
    {

    }
}
