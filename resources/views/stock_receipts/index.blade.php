@extends('layouts.app')

@section('content')

<h2>Stock Receiving History</h2>

@if(session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

<a href="{{ route('stock-receipts.create') }}">
  + Receive New Device
</a>

<table border="1" cellpadding="10" cellspacing="0">
  <thead>
    <tr>
      <th>Product</th>
      <th>Serial Number</th>
      <th>MAC Address</th>
      <th>Condition</th>
      <th>Warehouse</th>
      <th>Received Date</th>
      <th>Remarks</th>
    </tr>
  </thead>

  <tbody>
    @forelse($stockReceipts as $receipt)
    <tr>
      <td>
        {{ $receipt->device->product->brand }}
        - {{ $receipt->device->product->model_name }}
      </td>

      <td>{{ $receipt->device->serial_number ?? 'N/A' }}</td>

      <td>{{ $receipt->device->mac_address ?? 'N/A' }}</td>

      <td>{{ ucfirst($receipt->device->condition) }}</td>

      <td>{{ $receipt->warehouse->name }}</td>

      <td>{{ $receipt->received_date }}</td>

      <td>{{ $receipt->remarks ?? 'N/A' }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="7">No receiving records found.</td>
    </tr>
    @endforelse
  </tbody>
</table>

@endsection