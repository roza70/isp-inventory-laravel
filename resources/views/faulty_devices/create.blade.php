@extends('layouts.app')

@section('content')

<h2>Register Faulty Device</h2>

@if ($errors->any())
<div style="color: red;">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<form action="{{ route('faulty-devices.store') }}" method="POST">
  @csrf

  <label>Select Device:</label><br>
  <select name="device_id" required>
    <option value="">Select an in-stock device</option>

    @foreach ($devices as $device)
    <option value="{{ $device->id }}"
      {{ old('device_id') == $device->id ? 'selected' : '' }}>
      {{ $device->product->model_name }}
      | SN: {{ $device->serial_number ?? 'N/A' }}
      | MAC: {{ $device->mac_address ?? 'N/A' }}
    </option>
    @endforeach
  </select>

  <br><br>

  <label>Fault Date:</label><br>
  <input type="date" name="fault_date"
    value="{{ old('fault_date') }}" required>

  <br><br>

  <label>Fault Description:</label><br>
  <textarea name="fault_description" required>{{ old('fault_description') }}</textarea>

  <br><br>

  <label>Remarks:</label><br>
  <textarea name="remarks">{{ old('remarks') }}</textarea>

  <br><br>

  <button type="submit">Register Faulty Device</button>

  <a href="{{ route('faulty-devices.index') }}">Cancel</a>
</form>

@endsection