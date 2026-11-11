@extends('layouts.app')

@section('content')

<h2>Faulty Device Register</h2>


@if (session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

<h3>Currently Faulty Devices: {{ $totalFaulty }}</h3>

<a href="{{ route('faulty-devices.create') }}">
  + Register Faulty Device
</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>Product</th>
    <th>Serial Number</th>
    <th>MAC Address</th>
    <th>Fault Date</th>
    <th>Fault Description</th>
    <th>Resolution Status</th>
    <th>Remarks</th>
    <th>Action</th>
  </tr>

  @forelse ($faultyDevices as $faulty)
  <tr>
    <td>{{ $faulty->device->product->model_name }}</td>
    <td>{{ $faulty->device->serial_number ?? 'N/A' }}</td>
    <td>{{ $faulty->device->mac_address ?? 'N/A' }}</td>
    <td>{{ $faulty->fault_date }}</td>
    <td>{{ $faulty->fault_description }}</td>
    <td>{{ ucfirst(str_replace('_', ' ', $faulty->resolution_status)) }}</td>
    <td>{{ $faulty->remarks ?? 'N/A' }}</td>
    <td>
      <a href="{{ route('faulty-devices.edit', $faulty->id) }}">
        Update Resolution
      </a>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="8">No faulty devices found.</td>
  </tr>
  @endforelse
</table>

@endsection