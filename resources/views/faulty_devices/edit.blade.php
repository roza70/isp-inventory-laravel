@extends('layouts.app')

@section('content')

<h2>Update Faulty Device Resolution</h2>

@if ($errors->any())
<div style="color: red;">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<h3>Device Information</h3>

<p>
  Product: {{ $faultyDevice->device->product->model_name }}
</p>

<p>
  Serial Number: {{ $faultyDevice->device->serial_number ?? 'N/A' }}
</p>

<p>
  MAC Address: {{ $faultyDevice->device->mac_address ?? 'N/A' }}
</p>

<p>
  Fault Description: {{ $faultyDevice->fault_description }}
</p>

<p>
  Current Resolution:
  {{ ucfirst(str_replace('_', ' ', $faultyDevice->resolution_status)) }}
</p>

@if (in_array($faultyDevice->resolution_status, ['repaired', 'written_off']))

<p style="color: red;">
  This faulty record is already closed and cannot be updated.
</p>

<a href="{{ route('faulty-devices.index') }}">Back to Faulty Devices</a>

@else

<form action="{{ route('faulty-devices.update', $faultyDevice->id) }}"
  method="POST">

  @csrf
  @method('PUT')

  <label>Resolution Status:</label><br>

  <select name="resolution_status" required>

    <option value="pending"
      {{ old('resolution_status', $faultyDevice->resolution_status) == 'pending' ? 'selected' : '' }}>
      Pending
    </option>

    <option value="under_repair"
      {{ old('resolution_status', $faultyDevice->resolution_status) == 'under_repair' ? 'selected' : '' }}>
      Under Repair
    </option>

    <option value="repaired"
      {{ old('resolution_status', $faultyDevice->resolution_status) == 'repaired' ? 'selected' : '' }}>
      Repaired
    </option>

    <option value="written_off"
      {{ old('resolution_status', $faultyDevice->resolution_status) == 'written_off' ? 'selected' : '' }}>
      Written Off
    </option>

  </select>

  <br><br>

  <label>Return Warehouse (Required if Repaired):</label><br>

  <select name="warehouse_id">

    <option value="">Select Warehouse</option>

    @foreach ($warehouses as $warehouse)

    <option value="{{ $warehouse->id }}"
      {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
      {{ $warehouse->name }}
    </option>

    @endforeach

  </select>

  <br><br>

  <label>Remarks:</label><br>

  <textarea name="remarks">{{ old('remarks', $faultyDevice->remarks) }}</textarea>

  <br><br>

  <button type="submit">Update Resolution</button>

  <a href="{{ route('faulty-devices.index') }}">Cancel</a>

</form>

@endif

@endsection