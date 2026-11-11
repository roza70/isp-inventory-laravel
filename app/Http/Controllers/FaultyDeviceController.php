<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Device;
use App\Models\FaultyDevice;

class FaultyDeviceController extends Controller
{
    // Display faulty device history
    public function index()
    {
        $faultyDevices = FaultyDevice::with([
            'device.product',
            'device.warehouse'
        ])->latest()->get();

        $totalFaulty = Device::where('status', 'faulty')->count();

        return view('faulty_devices.index', compact(
            'faultyDevices',
            'totalFaulty'
        ));
    }

    // Show faulty device registration form
    public function create()
    {
        $devices = Device::where('status', 'in_stock')
            ->with('product')
            ->get();

        return view('faulty_devices.create', compact('devices'));
    }

    // Register a faulty device
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'fault_date' => 'required|date',
            'fault_description' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            $device = Device::whereKey($validated['device_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($device->status !== 'in_stock') {
                abort(422, 'Only in-stock devices can be registered as faulty.');
            }

            FaultyDevice::create([
                'device_id' => $device->id,
                'fault_date' => $validated['fault_date'],
                'fault_description' => $validated['fault_description'],
                'resolution_status' => 'pending',
                'remarks' => $validated['remarks'] ?? null,
            ]);

            $device->update([
                'status' => 'faulty',
                'current_warehouse_id' => null,
            ]);
        });

        return redirect()->route('faulty-devices.index')
            ->with('success', 'Faulty device registered successfully!');
    }
}
