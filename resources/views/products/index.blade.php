@extends('layouts.app')

@section('content')

<h2>Products Page</h2>

@if(session('success'))
<p style="color: green;">
    {{ session('success') }}
</p>
@endif

<h3>All Products</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Product Name</th>
        <th>Brand</th>
        <th>Type</th>
        <th>Action</th>
    </tr>

    @foreach($products as $product)
    <tr>
        <td>{{ $product->model_name }}</td>
        <td>{{ $product->brand }}</td>
        <td>{{ $product->type }}</td>

        <td>
            <a href="{{ route('products.show', $product->id) }}">
                View
            </a>
            <a href="{{ route('products.edit', $product->id) }}">
                Edit
            </a>

            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm('Are you sure you want to delete this product?')">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection