<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

include __DIR__.'/dashboard.php';
Route::get('/', function () {
    return view('welcome');
})->name('home');
