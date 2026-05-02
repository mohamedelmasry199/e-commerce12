<?php

use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WorldController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale() . '/dashboard',
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

        Route::group(['middleware' => ['can:categories']], function () {
            Route::resource('categories', App\Http\Controllers\Dashboard\CategoryController::class);
            Route::get('categories-all', [App\Http\Controllers\Dashboard\CategoryController::class, 'getAll'])->name('categories.all');
        });
        ############################ end categories ##########################

        ############################ brands ##########################
        Route::group(['middleware' => ['can:brands']], function () {
            Route::resource('brands', App\Http\Controllers\Dashboard\BrandController::class);
            Route::get('brands-all', [App\Http\Controllers\Dashboard\BrandController::class, 'getAll'])->name('brands.all');
        });
        ############################ end brands ##########################
        ############################ coupons ##########################
        Route::group(['middleware' => ['can:coupons']], function () {
            Route::resource('coupons', App\Http\Controllers\Dashboard\CouponController::class)->except(['create', 'show']);
            Route::get('coupons-all', [App\Http\Controllers\Dashboard\CouponController::class, 'getAll'])->name('coupons.all');
            Route::post('changeStatus/{id}', [App\Http\Controllers\Dashboard\CouponController::class, 'changeStatus'])->name('coupons.change_status');
        });
        //add can faqs
        Route::group(['middleware' => ['can:faqs']], function () {
            Route::resource('faqs', App\Http\Controllers\Dashboard\FaqController::class)->except(['create', 'show', 'edit']);
        });
        ############################ end coupons ##########################
        ############################ Settings Route ##########################
        Route::resource('settings', App\Http\Controllers\Dashboard\SettingController::class)->only(['index', 'update'])->middleware('can:settings');
        ############################ End Settings Route ##########################

        ######################### Attributes & Attribute Values ##########################
        Route::group(['middleware' => 'can:attributes'], function () {
            Route::resource('attributes', App\Http\Controllers\Dashboard\AttributeController::class);
            Route::get('attributes-all', [App\Http\Controllers\Dashboard\AttributeController::class, 'getAll'])->name('attributes.all');
        });
        ######################### End Attributes & Attribute Values ##########################

        ############################ products ##########################

        Route::group(['middleware' => ['can:products']], function () {
            Route::resource('products', App\Http\Controllers\Dashboard\ProductController::class);
            Route::get('products-all', [App\Http\Controllers\Dashboard\ProductController::class, 'getAll'])->name('products.all');
            Route::post('change-status', [App\Http\Controllers\Dashboard\ProductController::class, 'changeStatus'])->name('products.status');
            Route::delete('destroy/{id}', [App\Http\Controllers\Dashboard\ProductController::class, 'delete'])->name('products.destroy');
            Route::delete('variants_delete',[App\Http\Controllers\Dashboard\ProductController::class, 'deleteVariant'])->name('products.variants.delete');



        });
        ############################ end products ##########################
        ############################ users ##########################
          Route::group(['middleware' => 'can:users'], function () {
                Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);
                Route::post('users/status', [App\Http\Controllers\Dashboard\UserController::class, 'changeStatus'])
                    ->name('users.status');
                Route::get('users-all', [App\Http\Controllers\Dashboard\UserController::class, 'getAll'])
                    ->name('users.all');
            });
        ############################ end users ##########################

         ############################ contacts ##########################
          Route::group(['middleware' => 'can:contacts'], function () {
                Route::get('contacts',[ App\Http\Controllers\Dashboard\ContactController::class, 'index'])->name('contacts.index');
                Route::get('contacts-all', [App\Http\Controllers\Dashboard\ContactController::class, 'getAll'])->name('contacts.all');
                Route::post('contacts/status', [App\Http\Controllers\Dashboard\ContactController::class, 'changeStatus'])->name('contacts.status');
                ######################## end contacts ##########################
############################### Sliders Routes ##############################
            Route::group(['middleware' => 'can:sliders'], function () {
                Route::get('sliders',         [SliderController::class, 'index'])->name('sliders.index');
                Route::post('sliders',        [SliderController::class, 'store'])->name('sliders.store');
                Route::get('sliders-all',     [SliderController::class, 'getAll'])->name('sliders.all');
                Route::get('remove/{id}',     [SliderController::class, 'destroy'])->name('sliders.delete');
            });
            ############################### End Sliders ################################

    });
});
});
