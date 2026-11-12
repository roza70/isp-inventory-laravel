<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = StockAdjustment::with([
            'device.product',
            'device.warehouse',
            'product',
            'warehouse',
            'approver',
        ])->latest()->get();

        return view('stock_adjustments.index', compact('adjustments'));
    }

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

    public function store(Request $request)
    {
        $rules = [
            'adjustment_type' => 'required|in:increase,decrease',
            'adjustment_date' => 'required|date',
            'reason' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ];

        if ($request->adjustment_type === 'increase') {
            $rules = array_merge($rules, [
                'product_id' => 'required|exists:products,id',
                'serial_number' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('devices', 'serial_number'),
                    Rule::unique('stock_adjustments', 'serial_number')
                        ->where(fn($query) => $query->where('approval_status', 'pending')),
                ],

                'mac_address' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('devices', 'mac_address'),
                    Rule::unique('stock_adjustments', 'mac_address')
                        ->where(fn($query) => $query->where('approval_status', 'pending')),
                ],
                'condition' => 'required|in:new,old',
                'current_warehouse_id' => 'nullable|exists:warehouses,id',
            ]);
        } else {
            $rules['device_id'] = [
                'required',
                'exists:devices,id',
            ];
        }

        $validated = $request->validate($rules);

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

            if ($validated['adjustment_type'] === 'decrease') {

                $device = Device::where('id', $validated['device_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($device->status !== 'in_stock') {
                    throw ValidationException::withMessages([
                        'device_id' => 'Only in-stock devices can be decreased.',
                    ]);
                }

                StockAdjustment::create([
                    'device_id' => $device->id,
                    'adjustment_type' => 'decrease',
                    'adjustment_date' => $validated['adjustment_date'],
                    'reason' => $validated['reason'],
                    'remarks' => $validated['remarks'] ?? null,
                    'approval_status' => 'pending',
                ]);
            } else {

                StockAdjustment::create([
                    'device_id' => null,
                    'product_id' => $validated['product_id'],
                    'serial_number' => $validated['serial_number'] ?? null,
                    'mac_address' => $validated['mac_address'] ?? null,
                    'condition' => $validated['condition'],
                    'current_warehouse_id' => $validated['current_warehouse_id'] ?? null,
                    'adjustment_type' => 'increase',
                    'adjustment_date' => $validated['adjustment_date'],
                    'reason' => $validated['reason'],
                    'remarks' => $validated['remarks'] ?? null,
                    'approval_status' => 'pending',
                ]);
            }
        });

        return redirect()
            ->route('stock-adjustments.index')
            ->with('success', 'Stock adjustment request submitted for approval!');
    }
    public function approve(Request $request, StockAdjustment $stockAdjustment)
    {
        abort_unless(Auth::check(), 403);

        $validated = $request->validate([
            'approval_remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($stockAdjustment, $validated) {

            $adjustment = StockAdjustment::whereKey($stockAdjustment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($adjustment->approval_status !== 'pending') {
                throw ValidationException::withMessages([
                    'approval_status' => 'This request has already been processed.',
                ]);
            }

            if ($adjustment->adjustment_type === 'increase') {

                // Check whether the requested identifiers are still available.
                if (
                    $adjustment->serial_number &&
                    Device::where('serial_number', $adjustment->serial_number)->exists()
                ) {
                    throw ValidationException::withMessages([
                        'serial_number' => 'This serial number already exists.',
                    ]);
                }

                if (
                    $adjustment->mac_address &&
                    Device::where('mac_address', $adjustment->mac_address)->exists()
                ) {
                    throw ValidationException::withMessages([
                        'mac_address' => 'This MAC address already exists.',
                    ]);
                }

                // Create the actual device only after approval.
                $device = Device::create([
                    'product_id' => $adjustment->product_id,
                    'serial_number' => $adjustment->serial_number,
                    'mac_address' => $adjustment->mac_address,
                    'condition' => $adjustment->condition,
                    'status' => 'in_stock',
                    'current_warehouse_id' => $adjustment->current_warehouse_id,
                ]);

                $adjustment->device_id = $device->id;
            } elseif ($adjustment->adjustment_type === 'decrease') {

                $device = Device::whereKey($adjustment->device_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($device->status !== 'in_stock') {
                    throw ValidationException::withMessages([
                        'device_id' => 'This device is no longer available in stock.',
                    ]);
                }

                // Remove the device from available stock.
                $device->update([
                    'status' => 'written_off',
                ]);
            }

            $adjustment->approval_status = 'approved';
            $adjustment->approved_by = Auth::id();
            $adjustment->approved_at = now();
            $adjustment->approval_remarks = $validated['approval_remarks'] ?? null;

            $adjustment->save();
        });

        return redirect()
            ->route('stock-adjustments.index')
            ->with('success', 'Stock adjustment approved successfully!');
    }
    public function reject(Request $request, StockAdjustment $stockAdjustment)
    {
        abort_unless(Auth::check(), 403);

        $validated = $request->validate([
            'approval_remarks' => 'required|string',
        ]);

        DB::transaction(function () use ($stockAdjustment, $validated) {

            $adjustment = StockAdjustment::whereKey($stockAdjustment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($adjustment->approval_status !== 'pending') {
                throw ValidationException::withMessages([
                    'approval_status' => 'This request has already been processed.',
                ]);
            }

            $adjustment->update([
                'approval_status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'approval_remarks' => $validated['approval_remarks'],
            ]);
        });

        return redirect()
            ->route('stock-adjustments.index')
            ->with('success', 'Stock adjustment rejected successfully!');
    }
}
