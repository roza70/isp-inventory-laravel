@extends('layouts.app')

@section('content')

<h2>Product Details</h2>

<p><strong>Product ID:</strong> {{ $product->id }}</p>

<p><strong>Model Name:</strong> {{ $product->model_name }}</p>

<p><strong>Brand:</strong> {{ $product->brand }}</p>

<p><strong>Type:</strong> {{ $product->type }}</p>

<a href="{{ route('products.index') }}">Back to Products</a>

@endsection