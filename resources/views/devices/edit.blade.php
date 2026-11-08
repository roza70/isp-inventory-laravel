@extends('layouts.app')

@section('content')

<h2>Edit Device</h2>

<form action="{{ route('devices.update', $device->id) }}" method="POST">

  @csrf
  @method('PUT')

  <div>
    <label>Product:</label>
    <select name="product_id" required>
      @foreach($products as $product)
      <option value="{{ $product->id }}"
        {{ old('product_id', $device->product_id) == $product->id ? 'selected' : '' }}>
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
    <input type="text" name="serial_number"
      value="{{ old('serial_number', $device->serial_number) }}">
    @error('serial_number')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>MAC Address:</label>
    <input type="text" name="mac_address"
      value="{{ old('mac_address', $device->mac_address) }}">
    @error('mac_address')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <p>Provide at least one: Serial Number or MAC Address.</p>

  <br>

  <div>
    <label>Condition:</label>
    <select name="condition" required>
      <option value="new" {{ old('condition', $device->condition) == 'new' ? 'selected' : '' }}>New</option>
      <option value="old" {{ old('condition', $device->condition) == 'old' ? 'selected' : '' }}>Old</option>
    </select>
  </div>

  <br>

  <div>
    <label>Status:</label>
    <select name="status" required>
      <option value="in_stock" {{ old('status', $device->status) == 'in_stock' ? 'selected' : '' }}>In Stock</option>
      <option value="in_use" {{ old('status', $device->status) == 'in_use' ? 'selected' : '' }}>In Use</option>
      <option value="faulty" {{ old('status', $device->status) == 'faulty' ? 'selected' : '' }}>Faulty</option>
    </select>
  </div>

  <br>

  <div>
    <label>Warehouse:</label>
    <select name="current_warehouse_id">
      <option value="">Not Assigned</option>

      @foreach($warehouses as $warehouse)
      <option value="{{ $warehouse->id }}"
        {{ old('current_warehouse_id', $device->current_warehouse_id) == $warehouse->id ? 'selected' : '' }}>
        {{ $warehouse->name }}
      </option>
      @endforeach
    </select>
  </div>

  <br>

  <div>
    <label>Remarks:</label>
    <textarea name="remarks">{{ old('remarks', $device->remarks) }}</textarea>
  </div>

  <br>

  <button type="submit">Update Device</button>

  <a href="{{ route('devices.index') }}">Cancel</a>

</form>

@endsection