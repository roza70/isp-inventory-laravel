@extends('layouts.app')

@section('content')
<h2>Stock Adjustment History</h2>

@if (session('success'))
<p>{{ session('success') }}</p>
@endif

<a href="{{ route('stock-adjustments.create') }}">
  + New Stock Adjustment
</a>

<table border="1" cellpadding="10">
  <thead>
    <tr>
      <th>Product</th>
      <th>Serial / MAC</th>
      <th>Adjustment Type</th>
      <th>Date</th>
      <th>Reason</th>
      <th>Remarks</th>
    </tr>
  </thead>

  <tbody>
    @forelse ($adjustments as $adjustment)
    <tr>
      <td>
        {{ $adjustment->device->product->brand }}
        -
        {{ $adjustment->device->product->model_name }}
      </td>

      <td>
        {{ $adjustment->device->serial_number
                            ?? $adjustment->device->mac_address }}
      </td>

      <td>
        {{ ucfirst($adjustment->adjustment_type) }}
      </td>

      <td>{{ $adjustment->adjustment_date }}</td>

      <td>{{ $adjustment->reason }}</td>

      <td>{{ $adjustment->remarks ?? 'N/A' }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="6">No stock adjustments found.</td>
    </tr>
    @endforelse
  </tbody>
</table>
@endsection