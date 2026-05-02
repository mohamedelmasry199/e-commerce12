<?php

use App\Http\Controllers\Website\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
], function () {
    Auth::routes();
     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
            ->name('home');
              Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
            ->name('home');
    Route::group([
        'as' => 'website.'
    ], function () {
         Route::get('/profile/{id}', [ProfileController::class, 'show'])
            ->name('profile.show');
    });

});
include('dashboard.php');
