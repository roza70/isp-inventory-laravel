<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockAdjustmentController extends Controller
{
    /**
     * Display all stock adjustment records.
     */
    public function index()
    {
        $adjustments = StockAdjustment::with([
            'device.product',
            'device.warehouse',
        ])->latest()->get();

        return view('stock_adjustments.index', compact('adjustments'));
    }

    /**
     * Show the stock adjustment form.
     */
    public function create()
    {
        $devices = Device::with('product')
            ->where('status', 'in_stock')
            ->get();

        $products = Product::all();

        $warehouses = Warehouse::all();

        return view('stock_adjustments.create', compact(
            'devices',
            'products',
            'warehouses'
        ));
    }

    /**
     * Store a stock adjustment.
     */
    public function store(Request $request)
    {
        $rules = [
            'adjustment_type' => 'required|in:increase,decrease',
            'adjustment_date' => 'required|date',
            'reason' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ];

        // Increase: a new physical device will be added.
        if ($request->adjustment_type === 'increase') {
            $rules = array_merge($rules, [
                'product_id' => 'required|exists:products,id',
                'serial_number' => 'nullable|string|unique:devices,serial_number',
                'mac_address' => 'nullable|string|unique:devices,mac_address',
                'condition' => 'required|in:new,old',
                'current_warehouse_id' => 'nullable|exists:warehouses,id',
            ]);
        }

        // Decrease: an existing in-stock device will be written off.
        else {
            $rules['device_id'] = 'required|exists:devices,id';
        }

        $validated = $request->validate($rules);

        // At least one unique identifier is required for a new device.
        if (
            $validated['adjustment_type'] === 'increase' &&
            empty($validated['serial_number']) &&
            empty($validated['mac_address'])
        ) {
            throw ValidationException::withMessages([
                'serial_number' => 'Serial number or MAC address is required.',
            ]);
        }

        DB::transaction(function () use ($validated) {

            if ($validated['adjustment_type'] === 'increase') {

                $device = Device::create([
                    'product_id' => $validated['product_id'],
                    'serial_number' => $validated['serial_number'] ?? null,
                    'mac_address' => $validated['mac_address'] ?? null,
                    'condition' => $validated['condition'],
                    'status' => 'in_stock',
                    'current_warehouse_id' => $validated['current_warehouse_id'] ?? null,
                ]);
            } else {

                $device = Device::where('id', $validated['device_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($device->status !== 'in_stock') {
                    throw ValidationException::withMessages([
                        'device_id' => 'Only in-stock devices can be decreased.',
                    ]);
                }

                $device->update([
                    'status' => 'written_off',
                ]);
            }

            // Save adjustment history.
            StockAdjustment::create([
                'device_id' => $device->id,
                'adjustment_type' => $validated['adjustment_type'],
                'adjustment_date' => $validated['adjustment_date'],
                'reason' => $validated['reason'],
                'remarks' => $validated['remarks'] ?? null,
            ]);
        });

        return redirect()
            ->route('stock-adjustments.index')
            ->with('success', 'Stock adjustment recorded successfully!');
    }
}
