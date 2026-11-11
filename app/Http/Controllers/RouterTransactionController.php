<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Organization;
use App\Models\RouterTransaction;
use App\Models\UsageInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouterTransactionController extends Controller
{
    // Show transaction form
    public function create()
    {
        $devices = Device::where('status', 'in_use')
            ->with('product')
            ->get();

        $organizations = Organization::all();

        return view('router_transactions.create', compact(
            'devices',
            'organizations'
        ));
    }

    // Save router transaction
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'organization_id' => 'required|exists:organizations,id',
            'delivery_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            $device = Device::where('status', 'in_use')
                ->lockForUpdate()
                ->findOrFail($validated['device_id']);

            $activeUsage = UsageInfo::where('device_id', $device->id)
                ->where('organization_id', $validated['organization_id'])
                ->whereNull('return_date')
                ->exists();

            if (!$activeUsage) {
                abort(422, 'This device is not assigned to this organization.');
            }

            RouterTransaction::create([
                'device_id' => $device->id,
                'organization_id' => $validated['organization_id'],
                'delivery_date' => $validated['delivery_date'],
                'status' => 'delivered',
                'remarks' => $validated['remarks'] ?? null,
            ]);
        });

        return redirect()->route('router-transactions.index')
            ->with('success', 'Router transaction recorded successfully!');
    }

    // Show router transaction history
    public function index()
    {
        $transactions = RouterTransaction::with([
            'device.product',
            'organization'
        ])->latest()->get();

        return view('router_transactions.index', compact('transactions'));
    }
}
