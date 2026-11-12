<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use App\Models\Device;
use App\Models\Wastage;

class WastageController extends Controller
{
    // Display wastage history
    public function index()
    {
        $wastages = Wastage::with([
            'device.product',
            'device.warehouse'
        ])->latest()->get();

        $totalWastages = Wastage::count();

        return view('wastages.index', compact(
            'wastages',
            'totalWastages'
        ));
    }

    // Show wastage registration form
    public function create()
    {
        $devices = Device::where('status', 'in_stock')
            ->with('product', 'warehouse')
            ->get();

        return view('wastages.create', compact('devices'));
    }

    // Store wastage record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'wastage_date' => 'required|date',
            'reason' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            $device = Device::whereKey($validated['device_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Only in-stock devices can be wasted
            if ($device->status !== 'in_stock') {
                throw ValidationException::withMessages([
                    'device_id' => 'Only in-stock devices can be registered as wasted.',
                ]);
            }

            // Create wastage history
            Wastage::create([
                'device_id' => $device->id,
                'wastage_date' => $validated['wastage_date'],
                'reason' => $validated['reason'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // Remove device from available stock
            $device->update([
                'status' => 'wasted',
                'current_warehouse_id' => null,
            ]);
        });

        return redirect()->route('wastages.index')
            ->with('success', 'Wastage record created successfully!');
    }
}
