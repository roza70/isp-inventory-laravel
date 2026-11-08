<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display all organizations.
     */
    public function index()
    {
        $organizations = Organization::all();

        return view('organizations.index', [
            'organizations' => $organizations
        ]);
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created organization.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'remarks' => 'nullable|string',
        ]);

        Organization::create($validatedData);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization created successfully!');
    }

    /**
     * Display the specified organization.
     */
    public function show(Organization $organization)
    {
        return view('organizations.show', [
            'organization' => $organization
        ]);
    }

    /**
     * Show the form for editing an organization.
     */
    public function edit(Organization $organization)
    {
        return view('organizations.edit', [
            'organization' => $organization
        ]);
    }

    /**
     * Update the specified organization.
     */
    public function update(Request $request, Organization $organization)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('organizations', 'name')
                    ->ignore($organization->id),
            ],
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'remarks' => 'nullable|string',
        ]);

        $organization->update($validatedData);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization updated successfully!');
    }

    /**
     * Remove the specified organization.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organizations.index')
            ->with('success', 'Organization deleted successfully!');
    }
}
