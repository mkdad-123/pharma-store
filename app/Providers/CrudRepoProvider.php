<?php

namespace App\Providers;

use App\Http\Controllers\PharmacistOrderController;
use App\Http\Controllers\WarehouseOrderController;
use App\Interfaces\CrudRepoInterface;
use App\Repo\PharmacistOrderRepo;
use App\Repo\WarehouseOrderRepo;
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
