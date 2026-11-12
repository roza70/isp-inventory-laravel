@extends('layouts.app')

@section('content')
<h2>Stock Adjustment</h2>

<form action="{{ route('stock-adjustments.store') }}" method="POST">
  @csrf

  <div>
    <label>Adjustment Type</label>
    <select name="adjustment_type" id="adjustment_type" required>
      <option value="">Select Type</option>
      <option value="increase"
        {{ old('adjustment_type') == 'increase' ? 'selected' : '' }}>
        Increase (+)
      </option>
      <option value="decrease"
        {{ old('adjustment_type') == 'decrease' ? 'selected' : '' }}>
        Decrease (-)
      </option>
    </select>
    @error('adjustment_type')
    <p>{{ $message }}</p>
    @enderror
  </div>

  <div id="increase_fields">
    <h3>Add New Device</h3>

    <div>
      <label>Product</label>
      <select name="product_id">
        <option value="">Select Product</option>
        @foreach ($products as $product)
        <option value="{{ $product->id }}"
          {{ old('product_id') == $product->id ? 'selected' : '' }}>
          {{ $product->brand }} - {{ $product->model_name }}
        </option>
        @endforeach
      </select>
      @error('product_id')
      <p>{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label>Serial Number</label>
      <input type="text" name="serial_number"
        value="{{ old('serial_number') }}">
      @error('serial_number')
      <p>{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label>MAC Address</label>
      <input type="text" name="mac_address"
        value="{{ old('mac_address') }}">
      @error('mac_address')
      <p>{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label>Condition</label>
      <select name="condition">
        <option value="">Select Condition</option>
        <option value="new">New</option>
        <option value="old">Old</option>
      </select>
      @error('condition')
      <p>{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label>Warehouse</label>
      <select name="current_warehouse_id">
        <option value="">Not Assigned</option>
        @foreach ($warehouses as $warehouse)
        <option value="{{ $warehouse->id }}">
          {{ $warehouse->name }}
        </option>
        @endforeach
      </select>
      @error('current_warehouse_id')
      <p>{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div id="decrease_fields">
    <h3>Remove Device From Available Stock</h3>

    <label>Device</label>
    <select name="device_id">
      <option value="">Select Device</option>
      @foreach ($devices as $device)
      <option value="{{ $device->id }}"
        {{ old('device_id') == $device->id ? 'selected' : '' }}>
        {{ $device->product->brand }} -
        {{ $device->product->model_name }}
        ({{ $device->serial_number ?? $device->mac_address }})
      </option>
      @endforeach
    </select>
    @error('device_id')
    <p>{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label>Adjustment Date</label>
    <input type="date" name="adjustment_date"
      value="{{ old('adjustment_date') }}" required>
    @error('adjustment_date')
    <p>{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label>Reason</label>
    <input type="text" name="reason"
      value="{{ old('reason') }}" required>
    @error('reason')
    <p>{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label>Remarks</label>
    <textarea name="remarks">{{ old('remarks') }}</textarea>
    @error('remarks')
    <p>{{ $message }}</p>
    @enderror
  </div>

  <button type="submit">Save Adjustment</button>
</form>

<script>
  const adjustmentType = document.getElementById('adjustment_type');
  const increaseFields = document.getElementById('increase_fields');
  const decreaseFields = document.getElementById('decrease_fields');

  function toggleAdjustmentFields() {
    increaseFields.style.display =
      adjustmentType.value === 'increase' ? 'block' : 'none';

    decreaseFields.style.display =
      adjustmentType.value === 'decrease' ? 'block' : 'none';
  }

  adjustmentType.addEventListener('change', toggleAdjustmentFields);

  toggleAdjustmentFields();
</script>
@endsection