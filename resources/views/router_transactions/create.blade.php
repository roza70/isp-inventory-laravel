@extends('layouts.app')

@section('content')

<h2>Record Router Transaction</h2>

@if ($errors->any())
<div style="color: red;">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<form action="{{ route('router-transactions.store') }}" method="POST">
  @csrf

  <div>
    <label>Device:</label>
    <select name="device_id" required>
      <option value="">Select Device</option>

      @foreach ($devices as $device)
      <option value="{{ $device->id }}">
        {{ $device->product->brand }}
        - {{ $device->product->model_name }}

        ({{ $device->serial_number ?? $device->mac_address }})
      </option>
      @endforeach
    </select>
  </div>

  <div>
    <label>Organization:</label>
    <select name="organization_id" required>
      <option value="">Select Organization</option>

      @foreach ($organizations as $organization)
      <option value="{{ $organization->id }}">
        {{ $organization->name }}
      </option>
      @endforeach
    </select>
  </div>

  <div>
    <label>Delivery Date:</label>
    <input
      type="date"
      name="delivery_date"
      value="{{ old('delivery_date', date('Y-m-d')) }}"
      required>
  </div>

  <div>
    <label>Remarks:</label>
    <textarea name="remarks">{{ old('remarks') }}</textarea>
  </div>

  <button type="submit">Save Transaction</button>

  <a href="{{ route('router-transactions.index') }}">Cancel</a>
</form>

@endsection