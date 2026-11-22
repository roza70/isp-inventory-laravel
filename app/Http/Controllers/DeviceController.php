<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

use App\Models\Device;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Organization;
use App\Services\StockService;

class DeviceController extends Controller
{
    // Display devices with search and filters
    public function index(Request $request, StockService $stockService)
    {
        $query = Device::with(['product', 'warehouse']);

        // Filter by product model name
        if ($request->filled('model_name')) {
            $query->whereHas('product', function ($productQuery) use ($request) {
                $productQuery->where(
                    'model_name',
                    'like',
                    '%' . $request->model_name . '%'
                );
            });
        }

        // Filter by serial number
        if ($request->filled('serial_number')) {
            $query->where(
                'serial_number',
                'like',
                '%' . $request->serial_number . '%'
            );
        }

        // Filter by device status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by organization through usage records
        if ($request->filled('organization_id')) {
            $query->whereHas('usageInfos', function ($usageQuery) use ($request) {
                $usageQuery->where('organization_id', $request->organization_id);
            });
        }

        $devices = $query->latest()->get();

        // Automatic inventory calculations
        $totalDevices = Device::count();
        $inStock = Device::where('status', 'in_stock')->count();
        $inUse = Device::where('status', 'in_use')->count();
        $faulty = Device::where('status', 'faulty')->count();
        $newDevices = Device::where('condition', 'new')->count();
        $oldDevices = Device::where('condition', 'old')->count();

        // Available stock summary remains independent of filters
        $stockSummary = $stockService->getAvailableStockSummary();

        // Dropdown data
        $products = Product::orderBy('model_name')->get();
        $organizations = Organization::orderBy('name')->get();

        return view('devices.index', compact(
            'devices',
            'totalDevices',
            'inStock',
            'inUse',
            'faulty',
            'newDevices',
            'oldDevices',
            'stockSummary',
            'products',
            'organizations'
        ));
    }

    // Show device creation form
    public function create()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();

        return view('devices.create', [
            'products' => $products,
            'warehouses' => $warehouses
        ]);
    }

    // Store a new device
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',

            'serial_number' => [
                'nullable',
                'required_without:mac_address',
                'string',
                'max:255',
                'unique:devices,serial_number',
            ],

            'mac_address' => [
                'nullable',
                'required_without:serial_number',
                'string',
                'max:255',
                'unique:devices,mac_address',
            ],

            'condition' => 'required|in:new,old',
            'current_warehouse_id' => 'nullable|exists:warehouses,id',
            'remarks' => 'nullable|string',
        ]);

        // Status is not accepted from the form.
        // Database default automatically sets it to in_stock.
        Device::create($validatedData);

        return redirect()->route('devices.index')
            ->with('success', 'Device created successfully!');
    }

    // Display a specific device
    public function show(string $id)
    {
        $device = Device::with(['product', 'warehouse'])
            ->findOrFail($id);

        return view('devices.show', [
            'device' => $device
        ]);
    }

    // Show device edit form
    public function edit(string $id)
    {
        $device = Device::findOrFail($id);
        $products = Product::all();
        $warehouses = Warehouse::all();

        return view('devices.edit', [
            'device' => $device,
            'products' => $products,
            'warehouses' => $warehouses
        ]);
    }

    // Update an existing device
    public function update(Request $request, string $id)
    {
        $device = Device::findOrFail($id);

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',

            'serial_number' => [
                'nullable',
                'required_without:mac_address',
                'string',
                'max:255',
                Rule::unique('devices', 'serial_number')
                    ->ignore($device->id),
            ],

            'mac_address' => [
                'nullable',
                'required_without:serial_number',
                'string',
                'max:255',
                Rule::unique('devices', 'mac_address')
                    ->ignore($device->id),
            ],

            'condition' => 'required|in:new,old',
            'current_warehouse_id' => 'nullable|exists:warehouses,id',
            'remarks' => 'nullable|string',
        ]);

        // Status is deliberately excluded.
        // Existing device status remains unchanged.
        $device->update($validatedData);

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully!');
    }

    // Delete a device safely
    public function destroy(string $id)
    {
        $device = Device::findOrFail($id);

        // Check whether the device has inventory history
        $hasHistory =
            $device->usageInfos()->exists() ||
            $device->faultyDevices()->exists() ||
            $device->warehouseTransfers()->exists() ||
            $device->stockAdjustments()->exists() ||
            $device->stockReceipts()->exists() ||
            $device->routerTransactions()->exists() ||
            $device->wastages()->exists();

        if ($hasHistory) {
            return redirect()->route('devices.index')
                ->with(
                    'error',
                    'This device cannot be deleted because it has related inventory history.'
                );
        }

        try {
            $device->delete();
        } catch (QueryException $exception) {
            return redirect()->route('devices.index')
                ->with(
                    'error',
                    'This device cannot be deleted because it is referenced by another record.'
                );
        }

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully!');
    }
}
