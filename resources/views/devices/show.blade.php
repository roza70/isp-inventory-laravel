@extends('layouts.app')

@section('content')

<h2>Device Details</h2>

<table border="1" cellpadding="10">

  <tr>
    <th>Product</th>
    <td>{{ $device->product->brand }} - {{ $device->product->model_name }}</td>
  </tr>

  <tr>
    <th>Serial Number</th>
    <td>{{ $device->serial_number ?? 'N/A' }}</td>
  </tr>

  <tr>
    <th>MAC Address</th>
    <td>{{ $device->mac_address ?? 'N/A' }}</td>
  </tr>

  <tr>
    <th>Condition</th>
    <td>{{ ucfirst($device->condition) }}</td>
  </tr>

  <tr>
    <th>Status</th>
    <td>{{ ucfirst(str_replace('_', ' ', $device->status)) }}</td>
  </tr>

  <tr>
    <th>Warehouse</th>
    <td>{{ $device->warehouse->name ?? 'Not Assigned' }}</td>
  </tr>

  <tr>
    <th>Remarks</th>
    <td>{{ $device->remarks ?? 'N/A' }}</td>
  </tr>

</table>

<br>

<a href="{{ route('devices.index') }}">Back to Devices</a>

@endsection