<?php

namespace App\Providers;

use App\Http\Controllers\AdminControllers\AdminProfileController;
use App\Http\Controllers\PharmacistControllers\PharmacistProfileController;
use App\Http\Controllers\WarehouseControllers\WarehouseProfileController;
use App\Interfaces\CrudProfileInterface;
use App\Reposetries\ProfileRepo\AdminProfileRepo;
use App\Reposetries\ProfileRepo\PharmacistProfileRepo;
use App\Reposetries\ProfileRepo\WarehouseProfileRepo;
use Illuminate\Support\ServiceProvider;

class ProfileProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->when(AdminProfileController::class)
            ->needs(CrudProfileInterface::class)
            ->give(function () {
                return (new AdminProfileRepo());
            });

        $this->app->when(PharmacistProfileController::class)
            ->needs(CrudProfileInterface::class)
            ->give(function () {
                return (new PharmacistProfileRepo());
            });

        $this->app->when(WarehouseProfileController::class)
            ->needs(CrudProfileInterface::class)
            ->give(function () {
                return (new WarehouseProfileRepo());
            });
    }

    public function boot(): void
    {
        //
    }
}
