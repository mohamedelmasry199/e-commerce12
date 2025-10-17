<?php
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
    });
});
