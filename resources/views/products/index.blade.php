@extends('layouts.app')

@section('content')

    <h2>Products Page</h2>

    <h3>All Products</h3>

    <table border="1" cellpadding="10">
        <tr>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Type</th>
        </tr>

        @foreach($products as $product)
            <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['brand'] }}</td>
                <td>{{ $product['type'] }}</td>
            </tr>
        @endforeach

    </table>

@endsection