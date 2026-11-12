@extends('layouts.app')

@section('content')

<h2>Register Device Wastage</h2>

@if ($errors->any())
<div style="color: red;">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<form action="{{ route('wastages.store') }}" method="POST">

  @csrf

  <label>Select Device:</label><br>

  <select name="device_id" required>
    <option value="">Select Device</option>

    @foreach ($devices as $device)
    <option value="{{ $device->id }}"
      {{ old('device_id') == $device->id ? 'selected' : '' }}>

      {{ $device->product->model_name }}
      |
      SN: {{ $device->serial_number ?? 'N/A' }}
      |
      MAC: {{ $device->mac_address ?? 'N/A' }}
      |
      Warehouse: {{ $device->warehouse->name ?? 'Not Assigned' }}

    </option>
    @endforeach

  </select>

  <br><br>

  <label>Wastage Date:</label><br>

  <input
    type="date"
    name="wastage_date"
    value="{{ old('wastage_date', date('Y-m-d')) }}"
    required>

  <br><br>

  <label>Wastage Reason:</label><br>

  <textarea
    name="reason"
    required>{{ old('reason') }}</textarea>

  <br><br>

  <label>Remarks:</label><br>

  <textarea name="remarks">{{ old('remarks') }}</textarea>

  <br><br>

  <button type="submit">Register Wastage</button>

  <a href="{{ route('wastages.index') }}">Cancel</a>

</form>

@endsection