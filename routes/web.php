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
use App\Http\Controllers\FaultyDeviceController;
use App\Http\Controllers\WarehouseTransferController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\WastageController;

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
Route::get('/faulty-devices', [FaultyDeviceController::class, 'index'])
    ->name('faulty-devices.index');

Route::get('/faulty-devices/create', [FaultyDeviceController::class, 'create'])
    ->name('faulty-devices.create');

Route::post('/faulty-devices', [FaultyDeviceController::class, 'store'])
    ->name('faulty-devices.store');
Route::get('/faulty-devices/{faultyDevice}/edit', [FaultyDeviceController::class, 'edit'])
    ->name('faulty-devices.edit');

Route::put('/faulty-devices/{faultyDevice}', [FaultyDeviceController::class, 'update'])
    ->name('faulty-devices.update');
Route::get('/warehouse-transfers', [WarehouseTransferController::class, 'index'])
    ->name('warehouse-transfers.index');

Route::get('/warehouse-transfers/create', [WarehouseTransferController::class, 'create'])
    ->name('warehouse-transfers.create');

Route::post('/warehouse-transfers', [WarehouseTransferController::class, 'store'])
    ->name('warehouse-transfers.store');
Route::get('/stock-adjustments', [StockAdjustmentController::class, 'index'])
    ->name('stock-adjustments.index');

Route::get('/stock-adjustments/create', [StockAdjustmentController::class, 'create'])
    ->name('stock-adjustments.create');

Route::post('/stock-adjustments', [StockAdjustmentController::class, 'store'])
    ->name('stock-adjustments.store');
Route::resource('wastages', WastageController::class)
    ->only(['index', 'create', 'store']);
