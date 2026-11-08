<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloIspController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DeviceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-isp', [HelloIspController::class, 'index']);

Route::resource('products', ProductController::class);
Route::resource('organizations', OrganizationController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('devices', DeviceController::class);
