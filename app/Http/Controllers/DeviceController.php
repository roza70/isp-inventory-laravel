<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Device;
use App\Models\Product;
use App\Models\Warehouse;

class DeviceController extends Controller
{
    // Display all devices

    public function index()
    {
        $devices = Device::with(['product', 'warehouse'])->get();

        // Automatic stock calculations
        $totalDevices = Device::count();

        $inStock = Device::where('status', 'in_stock')->count();

        $inUse = Device::where('status', 'in_use')->count();

        $faulty = Device::where('status', 'faulty')->count();

        $newDevices = Device::where('condition', 'new')->count();

        $oldDevices = Device::where('condition', 'old')->count();
        // Product-wise available stock calculation
        $stockSummary = Device::with('product')
            ->where('status', 'in_stock')
            ->get()
            ->groupBy('product_id')
            ->map(function ($devices) {
                return [
                    'product' => $devices->first()->product,
                    'new_quantity' => $devices->where('condition', 'new')->count(),
                    'old_quantity' => $devices->where('condition', 'old')->count(),
                    'total_quantity' => $devices->count(),
                ];
            })
            ->values();

        return view('devices.index', compact(
            'devices',
            'totalDevices',
            'inStock',
            'inUse',
            'faulty',
            'newDevices',
            'oldDevices',
            'stockSummary'

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

            'status' => 'required|in:in_stock,in_use,faulty',

            'current_warehouse_id' => 'nullable|exists:warehouses,id',

            'remarks' => 'nullable|string',
        ]);

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

            'status' => 'required|in:in_stock,in_use,faulty',

            'current_warehouse_id' => 'nullable|exists:warehouses,id',

            'remarks' => 'nullable|string',
        ]);

        $device->update($validatedData);

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully!');
    }

    // Delete a device
    public function destroy(string $id)
    {
        $device = Device::findOrFail($id);

        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully!');
    }
}
