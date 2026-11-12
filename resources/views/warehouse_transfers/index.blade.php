@extends('layouts.app')

@section('content')
<h2>Warehouse Transfer History</h2>

@if (session('success'))
<p>{{ session('success') }}</p>
@endif

<a href="{{ route('warehouse-transfers.create') }}">
  + Transfer Device
</a>

<table border="1" cellpadding="10">
  <thead>
    <tr>
      <th>Product</th>
      <th>Serial / MAC</th>
      <th>From Warehouse</th>
      <th>To Warehouse</th>
      <th>Transfer Date</th>
      <th>Remarks</th>
    </tr>
  </thead>

  <tbody>
    @forelse ($transfers as $transfer)
    <tr>
      <td>
        {{ $transfer->device->product->brand }}
        -
        {{ $transfer->device->product->model_name }}
      </td>

      <td>
        {{ $transfer->device->serial_number
                            ?? $transfer->device->mac_address }}
      </td>

      <td>{{ $transfer->fromWarehouse->name }}</td>

      <td>{{ $transfer->toWarehouse->name }}</td>

      <td>{{ $transfer->transfer_date }}</td>

      <td>{{ $transfer->remarks ?? 'N/A' }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="6">No transfer history found.</td>
    </tr>
    @endforelse
  </tbody>
</table>
@endsection