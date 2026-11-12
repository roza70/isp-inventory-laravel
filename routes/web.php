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
use App\Http\Controllers\ProfileController;

// Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// All authenticated routes
Route::middleware('auth')->group(function () {

    // Company information
    Route::get('/hello-isp', [HelloIspController::class, 'index']);

    // Products
    Route::resource('products', ProductController::class);

    // Organizations
    Route::resource('organizations', OrganizationController::class);

    // Warehouses
    Route::resource('warehouses', WarehouseController::class);

    // Devices
    Route::resource('devices', DeviceController::class);

    // Usage information
    Route::get('/usage-infos/create', [UsageInfoController::class, 'create'])
        ->name('usage-infos.create');

    Route::post('/usage-infos', [UsageInfoController::class, 'store'])
        ->name('usage-infos.store');

    Route::get('/usage-infos', [UsageInfoController::class, 'index'])
        ->name('usage-infos.index');

    Route::put('/usage-infos/{usageInfo}/return', [UsageInfoController::class, 'returnDevice'])
        ->name('usage-infos.return');

    // Stock receipts
    Route::get('/stock-receipts', [StockReceiptController::class, 'index'])
        ->name('stock-receipts.index');

    Route::get('/stock-receipts/create', [StockReceiptController::class, 'create'])
        ->name('stock-receipts.create');

    Route::post('/stock-receipts', [StockReceiptController::class, 'store'])
        ->name('stock-receipts.store');

    // Router transactions
    Route::get('/router-transactions', [RouterTransactionController::class, 'index'])
        ->name('router-transactions.index');

    Route::get('/router-transactions/create', [RouterTransactionController::class, 'create'])
        ->name('router-transactions.create');

    Route::post('/router-transactions', [RouterTransactionController::class, 'store'])
        ->name('router-transactions.store');

    // Faulty devices
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

    // Warehouse transfers
    Route::get('/warehouse-transfers', [WarehouseTransferController::class, 'index'])
        ->name('warehouse-transfers.index');

    Route::get('/warehouse-transfers/create', [WarehouseTransferController::class, 'create'])
        ->name('warehouse-transfers.create');

    Route::post('/warehouse-transfers', [WarehouseTransferController::class, 'store'])
        ->name('warehouse-transfers.store');

    // Stock adjustments
    Route::get('/stock-adjustments', [StockAdjustmentController::class, 'index'])
        ->name('stock-adjustments.index');

    Route::get('/stock-adjustments/create', [StockAdjustmentController::class, 'create'])
        ->name('stock-adjustments.create');

    Route::post('/stock-adjustments', [StockAdjustmentController::class, 'store'])
        ->name('stock-adjustments.store');

    // Wastages
    Route::resource('wastages', WastageController::class)
        ->only(['index', 'create', 'store']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Admin-only approval actions
Route::middleware(['auth', 'admin'])->group(function () {

    Route::post(
        '/stock-adjustments/{stockAdjustment}/approve',
        [StockAdjustmentController::class, 'approve']
    )->name('stock-adjustments.approve');

    Route::post(
        '/stock-adjustments/{stockAdjustment}/reject',
        [StockAdjustmentController::class, 'reject']
    )->name('stock-adjustments.reject');
});

require __DIR__ . '/auth.php';
