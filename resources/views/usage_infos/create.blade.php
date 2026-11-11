@extends('layouts.app')

@section('content')

<h2>Issue Device to Organization</h2>

<form action="{{ route('usage-infos.store') }}" method="POST">
  @csrf

  <label>Device:</label>
  <select name="device_id" required>
    <option value="">Select Device</option>

    @foreach($devices as $device)
    <option value="{{ $device->id }}">
      {{ $device->product->model_name }}
      - SN: {{ $device->serial_number ?? 'N/A' }}
      - MAC: {{ $device->mac_address ?? 'N/A' }}
    </option>
    @endforeach
  </select>

  <br><br>

  <label>Organization:</label>
  <select name="organization_id" required>
    <option value="">Select Organization</option>

    @foreach($organizations as $organization)
    <option value="{{ $organization->id }}">
      {{ $organization->name }}
    </option>
    @endforeach
  </select>

  <br><br>

  <label>Issue Date:</label>
  <input type="date" name="issue_date" required>

  <br><br>

  <label>Remarks:</label>
  <textarea name="remarks"></textarea>

  <br><br>

  <button type="submit">Issue Device</button>
</form>

@endsection