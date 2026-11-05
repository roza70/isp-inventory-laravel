@extends('layouts.app')

@section('content')

<h2>Add New Product</h2>

<form action="{{ route('products.store') }}" method="POST">

  @csrf

  <label>Product Model Name:</label>
  <input type="text" name="model_name"
    value="{{ old('model_name') }}">
  @error('model_name')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <br><br>

  <label>Brand:</label>
  <input type="text" name="brand"
    value="{{ old('brand') }}">
  @error('brand')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <br><br>

  <label>Product Type:</label>
  <input type="text" name="type"
    value="{{ old('type') }}">
  @error('type')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <br><br>

  <button type="submit">Save Product</button>

</form>

@endsection