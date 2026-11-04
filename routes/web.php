<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloIspController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-isp', [HelloIspController::class, 'index']);

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');