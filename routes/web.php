<?php

use App\Http\Controllers\Website\FaqController;
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
         Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
            ->name('home');
              Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
            ->name('home');
         Route::get('/profile/{id}', [ProfileController::class, 'show'])
            ->name('profile.show');



            ##pages
            Route::get('/page/{slug}', [App\Http\Controllers\Website\PageController::class, 'show'])
            ->name('page.show');
            ##end pages
        Route::get('faqs',         [FaqController::class, 'showFaqPage'])->name('faqs.index');

    });

});
include('dashboard.php');
