<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
            'model_name' => 'required|string|max:255|unique:products,model_name',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
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
            'model_name' => 'required|string|max:255|unique:products,model_name,' . $product->id,
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
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
