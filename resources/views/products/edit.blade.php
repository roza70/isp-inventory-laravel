@extends('layouts.app')

@section('content')

<h2>Edit Product</h2>

<form action="{{ route('products.update', $product->id) }}" method="POST">

  @csrf
  @method('PUT')

  <label>Product Model Name:</label>
  <input
    type="text"
    name="model_name"
    value="{{ old('model_name', $product->model_name) }}">

  @error('model_name')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <br><br>

  <label>Brand:</label>
  <input
    type="text"
    name="brand"
    value="{{ old('brand', $product->brand) }}">

  @error('brand')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <br><br>

  <label>Product Type:</label>
  <input
    type="text"
    name="type"
    value="{{ old('type', $product->type) }}">

  @error('type')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <br><br>

  <button type="submit">Update Product</button>

</form>

@endsection