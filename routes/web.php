<?php

use App\Http\Controllers\OrderWarehousePdfController;
use App\Http\Controllers\WarehouseControllers\WarehouseAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
//        event(new App\Events\ChangeOrderStatusEvent('sending' , 10));
        return view('welcome');
});

Route::group(['prefix' => 'auth'], function () {

    Route::controller(WarehouseAuthController::class)->prefix('warehouse')->group(function () {
        Route::get('/google/redirect', 'redirectToGoogle')->name('google.redirect');
        Route::get('/google/callback', 'handleGoogleCallback');
    });
});
