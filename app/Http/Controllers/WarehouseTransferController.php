<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Warehouse;
use App\Models\WarehouseTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WarehouseTransferController extends Controller
{
    public function index()
    {
        $transfers = WarehouseTransfer::with([
            'device.product',
            'fromWarehouse',
            'toWarehouse',
            'approver',
        ])->latest()->get();

        return view('warehouse_transfers.index', compact('transfers'));
    }

    public function create()
    {
        $devices = Device::with('product')
            ->where('status', 'in_stock')
            ->whereNotNull('current_warehouse_id')
            ->get();

        $warehouses = Warehouse::all();

        return view('warehouse_transfers.create', compact(
            'devices',
            'warehouses'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => [
                'required',
                'exists:devices,id,status,in_stock',
            ],
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'transfer_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            $device = Device::where('id', $validated['device_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($device->status !== 'in_stock') {
                throw ValidationException::withMessages([
                    'device_id' => 'Only in-stock devices can be transferred.',
                ]);
            }

            if (!$device->current_warehouse_id) {
                throw ValidationException::withMessages([
                    'device_id' => 'This device has no current warehouse.',
                ]);
            }

            if ($device->current_warehouse_id == $validated['to_warehouse_id']) {
                throw ValidationException::withMessages([
                    'to_warehouse_id' => 'Destination must be different from the current warehouse.',
                ]);
            }

            // Create a pending transfer request.
            WarehouseTransfer::create([
                'device_id' => $device->id,
                'from_warehouse_id' => $device->current_warehouse_id,
                'to_warehouse_id' => $validated['to_warehouse_id'],
                'transfer_date' => $validated['transfer_date'],
                'remarks' => $validated['remarks'] ?? null,
                'approval_status' => 'pending',
            ]);
        });

        return redirect()
            ->route('warehouse-transfers.index')
            ->with('success', 'Warehouse transfer request submitted for approval!');
    }
}
