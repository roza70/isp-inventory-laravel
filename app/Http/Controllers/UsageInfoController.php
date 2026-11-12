<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Organization;
use App\Models\UsageInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsageInfoController extends Controller
{
    public function create()
    {
        $devices = Device::where('status', 'in_stock')
            ->with('product')
            ->get();

        $organizations = Organization::all();

        return view('usage_infos.create', compact(
            'devices',
            'organizations'
        ));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => [
                'required',
                'exists:devices,id,status,in_stock',
            ],
            'organization_id' => 'required|exists:organizations,id',
            'issue_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);
        DB::transaction(function () use ($validated) {

            $device = Device::where('status', 'in_stock')
                ->lockForUpdate()
                ->findOrFail($validated['device_id']);

            UsageInfo::create([
                'device_id' => $device->id,
                'organization_id' => $validated['organization_id'],
                'issue_date' => $validated['issue_date'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            $device->update([
                'status' => 'in_use',
                'current_warehouse_id' => null,
            ]);
        });

        return redirect()
            ->route('devices.index')
            ->with('success', 'Device issued successfully!');
    }
    public function index()
    {
        $usageInfos = UsageInfo::with([
            'device.product',
            'organization'
        ])->latest()->get();

        $warehouses = \App\Models\Warehouse::all();

        return view('usage_infos.index', compact(
            'usageInfos',
            'warehouses'
        ));
    }
    public function returnDevice(Request $request, UsageInfo $usageInfo)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        DB::transaction(function () use ($usageInfo, $validated) {

            $usageInfo = UsageInfo::whereKey($usageInfo->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($usageInfo->return_date !== null) {
                abort(422, 'This device has already been returned.');
            }

            $device = Device::whereKey($usageInfo->device_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($device->status !== 'in_use') {
                abort(422, 'Device is not currently in use.');
            }

            $usageInfo->update([
                'return_date' => now()->toDateString(),
            ]);

            $device->update([
                'status' => 'in_stock',
                'current_warehouse_id' => $validated['warehouse_id'],
            ]);
        });

        return redirect()
            ->route('usage-infos.index')
            ->with('success', 'Device returned successfully!');
    }
}
