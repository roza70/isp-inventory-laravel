@extends('layouts.app')

@section('content')

<h2>Add New Device</h2>

<form action="{{ route('devices.store') }}" method="POST">

  @csrf

  <div>
    <label>Product:</label>

    <select name="product_id" required>
      <option value="">Select Product</option>

      @foreach($products as $product)
      <option
        value="{{ $product->id }}"
        {{ old('product_id') == $product->id ? 'selected' : '' }}>
        {{ $product->brand }} - {{ $product->model_name }}
      </option>
      @endforeach
    </select>

    @error('product_id')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Serial Number:</label>

    <input
      type="text"
      name="serial_number"
      value="{{ old('serial_number') }}"
      maxlength="255">

    @error('serial_number')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>MAC Address:</label>

    <input
      type="text"
      name="mac_address"
      value="{{ old('mac_address') }}"
      maxlength="255">

    @error('mac_address')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <p>Provide at least one: Serial Number or MAC Address.</p>

  <br>

  <div>
    <label>Condition:</label>

    <select name="condition" required>
      <option value="">Select Condition</option>
      <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
      <option value="old" {{ old('condition') == 'old' ? 'selected' : '' }}>Old</option>
    </select>

    @error('condition')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Status:</label>

    <select name="status" required>
      <option value="in_stock" {{ old('status', 'in_stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
      <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
      <option value="faulty" {{ old('status') == 'faulty' ? 'selected' : '' }}>Faulty</option>
    </select>

    @error('status')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Warehouse:</label>

    <select name="current_warehouse_id">
      <option value="">Not Assigned</option>

      @foreach($warehouses as $warehouse)
      <option
        value="{{ $warehouse->id }}"
        {{ old('current_warehouse_id') == $warehouse->id ? 'selected' : '' }}>
        {{ $warehouse->name }}
      </option>
      @endforeach
    </select>

    @error('current_warehouse_id')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Remarks:</label>

    <textarea name="remarks">{{ old('remarks') }}</textarea>

    @error('remarks')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <button type="submit">Save Device</button>

  <a href="{{ route('devices.index') }}">Cancel</a>

</form>

@endsection