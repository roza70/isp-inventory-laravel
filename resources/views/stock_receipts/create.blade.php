@extends('layouts.app')

@section('content')

<h2>Receive New Device</h2>

@if ($errors->any())
<div style="color: red;">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<form action="{{ route('stock-receipts.store') }}" method="POST">
  @csrf

  <div>
    <label>Product:</label>
    <select name="product_id" required>
      <option value="">Select Product</option>
      @foreach ($products as $product)
      <option value="{{ $product->id }}">
        {{ $product->brand }} - {{ $product->model_name }}
      </option>
      @endforeach
    </select>
  </div>

  <div>
    <label>Serial Number:</label>
    <input type="text" name="serial_number"
      value="{{ old('serial_number') }}">
  </div>

  <div>
    <label>MAC Address:</label>
    <input type="text" name="mac_address"
      value="{{ old('mac_address') }}">
  </div>

  <div>
    <label>Condition:</label>
    <select name="condition" required>
      <option value="new">New</option>
      <option value="old">Old</option>
    </select>
  </div>

  <div>
    <label>Warehouse:</label>
    <select name="warehouse_id" required>
      <option value="">Select Warehouse</option>
      @foreach ($warehouses as $warehouse)
      <option value="{{ $warehouse->id }}">
        {{ $warehouse->name }}
      </option>
      @endforeach
    </select>
  </div>

  <div>
    <label>Received Date:</label>
    <input type="date" name="received_date"
      value="{{ old('received_date', date('Y-m-d')) }}" required>
  </div>

  <div>
    <label>Remarks:</label>
    <textarea name="remarks">{{ old('remarks') }}</textarea>
  </div>

  <button type="submit">Receive Device</button>
</form>

@endsection