<?php

use App\Http\Controllers\{AdminControllers\AdminAuthController,
    AdminControllers\AdminController,
    AdminControllers\AdminProfileController,
    CategoryController,
    CompanyController,
    FavoriteController,
    MedicineController,
    OrderStatusController,
    PharmacistControllers\PharmacistAuthController,
    PharmacistControllers\PharmacistOrderController,
    PharmacistControllers\PharmacistProfileController,
    WarehouseControllers\WarehouseAuthController,
    WarehouseControllers\WarehouseController,
    WarehouseControllers\WarehouseOrderController,
    WarehouseControllers\WarehouseProfileController,
    WarehouseReviewController};
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {

    Route::controller(AdminAuthController::class)->prefix('admin')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register','register');
        Route::post('/logout', 'logout');
        Route::post('/refresh','refresh');
    });

    Route::controller(WarehouseAuthController::class)->prefix('warehouse')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh','refresh');
        Route::get('/verification/{code}','verify');
        Route::post('/resetPassword','resetPassword');
        Route::get('/check_code/{code}','checkCodeResetPassword');
    });

    Route::controller(PharmacistAuthController::class)->prefix('pharmacist')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh','refresh');
        Route::get('/verification/{code}','verify');
    });

});

Route::get('/unauthorized', function (){
    return response()->json([
        'message' => 'unauthorized'
    ],401);
})->name('login');

Route::group(['prefix' => 'profile'], function () {

    Route::controller(AdminProfileController::class)->prefix('admin')
        ->middleware('auth:admin')->group(function () {
            Route::get('show_profile', 'showProfile');
            Route::post('show_profile', 'updateProfile');
            Route::post('delete_profile', 'deleteProfile');
        });

    Route::controller(WarehouseProfileController::class)->prefix('warehouse')
        ->middleware('auth:warehouse')->group(function () {
            Route::get('show_profile', 'showProfile');
            Route::post('show_profile', 'updateProfile');
            Route::post('delete_profile', 'deleteProfile');
        });

    Route::controller(PharmacistProfileController::class)->prefix('pharmacist')
        ->middleware('auth:pharmacist')->group(function () {
            Route::get('show_profile', 'showProfile');
            Route::post('show_profile', 'updateProfile');
            Route::post('delete_profile', 'deleteProfile');
        });
});


Route::controller(MedicineController::class)->prefix('medicine')->group(function (){
    Route::get('show_all','showAll');
    Route::get('show_one/{id}','showOne');
    Route::post('store','store')->middleware('auth:warehouse');
    Route::get('show','show');
    Route::post('delete/{id}','delete');
    Route::post('search','search');
});

Route::controller(CategoryController::class)->prefix('categories')->group(function (){
   Route::get('show_all','show');
   Route::get('show_medicines','showWithMedicines');
   Route::middleware('auth:admin')->group(function (){
       Route::post('delete/{id}', 'delete');
       Route::post('add' , 'add');
       Route::post('update/{id}' , 'update');
   });
});
Route::controller(CompanyController::class)->prefix('companies')
    ->middleware('auth:admin')->group(function (){
    Route::post('delete/{id}', 'delete');
    Route::post('add' , 'add');
    Route::post('update/{id}' , 'update');
});

Route::controller(WarehouseController::class)->prefix('warehouses')->group(function (){
    Route::get('show_all','show');
    Route::get('show_medicines','showWithMedicines');
});

Route::controller(FavoriteController::class)->prefix('favorites')
    ->middleware('auth:pharmacist')
    ->group(function (){
    Route::post('store_medicine/{id}','storeMedicine');
    Route::get('show_medicines','showMedicine');
    Route::post('store_warehouse/{id}','storeWarehouse');
    Route::get('show_warehouse','showWarehouse');
    Route::get('top-favorite-medicines','getTopFavoriteMedicines');
});

Route::controller(PharmacistOrderController::class)->prefix('pharmacist/order')
    ->middleware('auth:pharmacist')
    ->group(function (){
        Route::get('show_all','showAllOrder');
        Route::get('show_one/{id}','showOneOrder');
        Route::post('store','addOrder');
    });

Route::prefix('warehouse/order')->middleware('auth:warehouse')->group(function (){
    Route::get('show_all',[WarehouseOrderController::class,'showAllOrder']);
    Route::get('show_one/{id}',[WarehouseOrderController::class,'showOneOrder']);
    Route::post('change_status/{id}',[OrderStatusController::class,'changeStatusOrder']);
    Route::post('change_payment/{id}',[OrderStatusController::class,'changeStatusPayment']);
    });

Route::controller(WarehouseReviewController::class)->group(function (){
        Route::get('warehouse/review/show_all/{id}','showWarehouseRates');
        Route::post('pharmacist/review/store','store')->middleware('auth:pharmacist');
    });

Route::controller(AdminController::class)->prefix('admin')
    ->middleware('auth:admin')
    ->group(function (){
    Route::post('delete_warehouse/{id}','deleteWarehouse');
    Route::post('accepted_warehouse/{id}','acceptedWarehouse');
    Route::post('store_company','addCompany');
});


