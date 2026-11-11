<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloIspController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UsageInfoController;
use App\Http\Controllers\StockReceiptController;
use App\Http\Controllers\RouterTransactionController;

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
Route::get('/stock-receipts', [StockReceiptController::class, 'index'])
    ->name('stock-receipts.index');

Route::get('/stock-receipts/create', [StockReceiptController::class, 'create'])
    ->name('stock-receipts.create');

Route::post('/stock-receipts', [StockReceiptController::class, 'store'])
    ->name('stock-receipts.store');
Route::get('/router-transactions', [RouterTransactionController::class, 'index'])
    ->name('router-transactions.index');

Route::get('/router-transactions/create', [RouterTransactionController::class, 'create'])
    ->name('router-transactions.create');

Route::post('/router-transactions', [RouterTransactionController::class, 'store'])
    ->name('router-transactions.store');
