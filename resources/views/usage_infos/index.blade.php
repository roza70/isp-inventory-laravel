@extends('layouts.app')

@section('content')

<h2>Device Usage History</h2>
@if(session('success'))
<div style="color: green; margin-bottom: 15px;">
  {{ session('success') }}
</div>
@endif

<table border="1" cellpadding="10" cellspacing="0">
  <thead>
    <tr>
      <th>Product</th>
      <th>Serial Number</th>
      <th>MAC Address</th>
      <th>Organization</th>
      <th>Issue Date</th>
      <th>Return Date</th>
      <th>Remarks</th>
      <th>Action</th>
    </tr>
  </thead>

  <tbody>
    @forelse($usageInfos as $usage)
    <tr>
      <td>{{ $usage->device->product->model_name }}</td>
      <td>{{ $usage->device->serial_number ?? 'N/A' }}</td>
      <td>{{ $usage->device->mac_address ?? 'N/A' }}</td>
      <td>{{ $usage->organization->name }}</td>
      <td>{{ $usage->issue_date }}</td>
      <td>{{ $usage->return_date ?? 'Not Returned' }}</td>
      <td>{{ $usage->remarks ?? 'N/A' }}</td>

      <td>
        @if($usage->return_date === null)
        <form action="{{ route('usage-infos.return', $usage->id) }}"
          method="POST">
          @csrf
          @method('PUT')

          <select name="warehouse_id" required>
            <option value="">Select Warehouse</option>

            @foreach($warehouses as $warehouse)
            <option value="{{ $warehouse->id }}">
              {{ $warehouse->name }}
            </option>
            @endforeach
          </select>

          <button type="submit">Return Device</button>
        </form>
        @else
        Returned
        @endif
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="8">No usage history found.</td>
    </tr>
    @endforelse
  </tbody>
</table>

@endsection