<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    /**
     * Display all warehouses.
     */
    public function index()
    {
        $warehouses = Warehouse::all();

        return view('warehouses.index', [
            'warehouses' => $warehouses
        ]);
    }

    /**
     * Show the form for creating a new warehouse.
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Store a newly created warehouse.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:warehouses,name',
            'location' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        Warehouse::create($validatedData);

        return redirect()->route('warehouses.index')
            ->with('success', 'Warehouse created successfully!');
    }

    /**
     * Display the specified warehouse.
     */
    public function show(Warehouse $warehouse)
    {
        return view('warehouses.show', [
            'warehouse' => $warehouse
        ]);
    }

    /**
     * Show the form for editing a warehouse.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', [
            'warehouse' => $warehouse
        ]);
    }

    /**
     * Update the specified warehouse.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('warehouses', 'name')
                    ->ignore($warehouse->id),
            ],
            'location' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $warehouse->update($validatedData);

        return redirect()->route('warehouses.index')
            ->with('success', 'Warehouse updated successfully!');
    }

    /**
     * Remove the specified warehouse.
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('warehouses.index')
            ->with('success', 'Warehouse deleted successfully!');
    }
}
