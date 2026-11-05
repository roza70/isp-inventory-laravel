<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::all();

        return view('products.index', [
            'products' => $products
        ]);
    }

    // Show the Add Product form
    public function create()
    {
        return view('products.create');
    }

    // Store a new product
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'model_name' => ['required', 'string', 'max:255'],
            'brand' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('model_name', $request->model_name);
                }),
            ],
            'type' => ['required', 'string', 'max:255'],
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    // Display a single product
    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product
        ]);
    }

    // Show the Edit Product form
    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    // Update an existing product
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'model_name' => ['required', 'string', 'max:255'],
            'brand' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('model_name', $request->model_name);
                })->ignore($product->id),
            ],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $product->update($validatedData);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
