<?php

use App\Http\Controllers\Dashboard\WorldController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale().'/dashboard',
    'as' => 'dashboard.'
], function () {

    // Public routes (no middleware)
    Route::get('login', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Dashboard\Auth\AuthController::class, 'login'])->name('login.post');

    // Protected routes (with auth:admin middleware)
    Route::middleware('auth:admin')->group(function () {

        Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');

        Route::resource('roles', App\Http\Controllers\Dashboard\RoleController::class)->middleware('can:roles');


        Route::resource('admins', App\Http\Controllers\Dashboard\AdminController::class)->middleware('can:admins');
        Route::get('admins/{id}/status', [App\Http\Controllers\Dashboard\AdminController::class, 'changeStatus'])->name('admins.status')->middleware('can:admins');

        ############################ Shipping & Countries ##########################
            Route::group(['middleware' => 'can:shipping'], function () {
                Route::controller(App\Http\Controllers\Dashboard\WorldController::class)->group(function () {

                    Route::prefix('countries')->name('countries.')->group(function () {
                        Route::get('/',                              'getAllCountries')->name('index');
                        Route::get('/{country_id}/governorates',     'getGovsByCountry')->name('governorates.index');
                        Route::get('/change-status/{country_id}',    'changeStatus')->name('status');
                    });

                    Route::prefix('governorates')->name('governorates.')->group(function () {
                        Route::get('/change-status/{gov_id}',       'changeGovStatus')->name('status');
                        Route::put('/shipping-price',               'changeShippingPrice')->name('shipping-price');
                    });
                });
            });
            ############################### End Shipping ###############################

            ############################ categories ##########################

            Route::group(['middleware'=> ['can:categories']], function () {
            Route::resource('categories', App\Http\Controllers\Dashboard\CategoryController::class);
            Route::get('categories-all' , [App\Http\Controllers\Dashboard\CategoryController::class,'getAll'])->name('categories.all');
});
            ############################ end categories ##########################

            ############################ brands ##########################
            Route::group(['middleware'=> ['can:brands']], function () {
                Route::resource('brands', App\Http\Controllers\Dashboard\BrandController::class);
                Route::get('brands-all' , [App\Http\Controllers\Dashboard\BrandController::class,'getAll'])->name('brands.all');
            });
            ############################ end brands ##########################

    });
});
