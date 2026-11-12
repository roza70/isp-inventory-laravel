@extends('layouts.app')

@section('content')
<h2>Transfer Device Between Warehouses</h2>

<form action="{{ route('warehouse-transfers.store') }}" method="POST">
  @csrf

  <div>
    <label>Device</label>
    <select name="device_id" required>
      <option value="">Select Device</option>

      @foreach ($devices as $device)
      <option value="{{ $device->id }}">
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
    <label>Destination Warehouse</label>
    <select name="to_warehouse_id" required>
      <option value="">Select Warehouse</option>

      @foreach ($warehouses as $warehouse)
      <option value="{{ $warehouse->id }}">
        {{ $warehouse->name }}
      </option>
      @endforeach
    </select>
    @error('to_warehouse_id')
    <p>{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label>Transfer Date</label>
    <input type="date" name="transfer_date"
      value="{{ old('transfer_date') }}" required>
    @error('transfer_date')
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

  <button type="submit">Transfer Device</button>
</form>
@endsection