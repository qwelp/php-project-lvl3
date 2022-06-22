<?php

use App\Http\Controllers\UrlCheckController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    function () {
        return view('welcome');
    }
)->name('home');

Route::resource('urls', UrlController::class)->only('index', 'store', 'show');
Route::resource('urls.checks', UrlCheckController::class)->only('store');
