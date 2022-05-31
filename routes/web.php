<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController')->name('index');

Route::group(['namespace' => 'Url'], function () {
    Route::get('/urls', 'IndexController')->name('url.index');
    Route::get('/urls/{id}', 'ShowController')->name('url.show');
    Route::post('/urls', 'StoreController')->name('url.store');
    Route::post('urls/{id}/checks', 'CheckController')->name('url.check.store');
});
