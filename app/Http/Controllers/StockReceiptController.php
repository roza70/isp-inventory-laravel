<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Device;
use App\Models\StockReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockReceiptController extends Controller
{
    // Show receiving form
    public function create()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();

        return view('stock_receipts.create', compact(
            'products',
            'warehouses'
        ));
    }

    // Save received device and receipt history
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'serial_number' => 'nullable|string|unique:devices,serial_number',
            'mac_address' => 'nullable|string|unique:devices,mac_address',
            'condition' => 'required|in:new,old',
            'warehouse_id' => 'required|exists:warehouses,id',
            'received_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        if (
            empty($validated['serial_number']) &&
            empty($validated['mac_address'])
        ) {
            return back()
                ->withErrors([
                    'serial_number' => 'Serial Number or MAC Address is required.'
                ])
                ->withInput();
        }

        DB::transaction(function () use ($validated) {

            $device = Device::create([
                'product_id' => $validated['product_id'],
                'serial_number' => $validated['serial_number'] ?? null,
                'mac_address' => $validated['mac_address'] ?? null,
                'condition' => $validated['condition'],
                'status' => 'in_stock',
                'current_warehouse_id' => $validated['warehouse_id'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            StockReceipt::create([
                'device_id' => $device->id,
                'warehouse_id' => $validated['warehouse_id'],
                'received_date' => $validated['received_date'],
                'remarks' => $validated['remarks'] ?? null,
            ]);
        });

        return redirect()->route('stock-receipts.index')
            ->with('success', 'Device received successfully!');
    }

    // Show receiving history
    public function index()
    {
        $stockReceipts = StockReceipt::with([
            'device.product',
            'warehouse'
        ])->latest()->get();

        return view('stock_receipts.index', compact('stockReceipts'));
    }
}
