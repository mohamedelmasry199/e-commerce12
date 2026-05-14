<?php

use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Website\BrandController;
use App\Http\Controllers\Website\FaqController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
], function () {
    Auth::routes();

    Route::group([
        'as' => 'website.'
    ], function () {
        Route::get('/home', [HomeController::class, 'index'])
            ->name('home');
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');

        ##pages
        Route::get('/page/{slug}', [PageController::class, 'show'])
            ->name('page.show');
        ##end pages
        Route::get('faqs',[FaqController::class, 'showFaqPage'])->name('faqs.index');

        ################################# Brands Routes ######################################
        Route::prefix('brands')->name('brands.')->controller(BrandController::class)->group(function () {
            Route::get('/',                  'getBrands')->name('index');
            Route::get('/{slug}/products',   'getProductsByBrand')->name('products');
        });
        ################################# Categories Routes ######################################
        Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {
            Route::get('/',   'getCategories')->name('index');
            Route::get('/{slug}/products', 'getProductsByCategory')->name('products');
        });

        ################################# Products Routes ######################################
        Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
            Route::get('/{type}',                  'getProductsByType')->name('by.type');
            Route::get('/show/{slug}',             'showProductPage')->name('show');
            Route::get('/{slug}/related-products', 'relatedProducts')->name('related');
        });


        Route::get('shop',           [HomeController::class, 'showShopPage'])->name('shop');

        ################################## Profile ####################################
        Route::group(['middleware' => 'auth:web'], function () {

            Route::get('/profile/{id}', [ProfileController::class, 'show'])
                ->name('profile.show');
        });
    });
});
include('dashboard.php');
