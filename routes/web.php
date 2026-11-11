<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloIspController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UsageInfoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-isp', [HelloIspController::class, 'index']);

Route::resource('products', ProductController::class);
Route::resource('organizations', OrganizationController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('devices', DeviceController::class);
Route::get('/usage-infos/create', [UsageInfoController::class, 'create'])
    ->name('usage-infos.create');

Route::post('/usage-infos', [UsageInfoController::class, 'store'])
    ->name('usage-infos.store');
Route::get('/usage-infos', [UsageInfoController::class, 'index'])
    ->name('usage-infos.index');
Route::put('/usage-infos/{usageInfo}/return', [UsageInfoController::class, 'returnDevice'])
    ->name('usage-infos.return');
