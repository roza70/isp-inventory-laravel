@extends('layouts.app')

@section('content')

<h2>Device Management</h2>

{{-- Inventory Summary --}}
<h3>Inventory Summary</h3>

<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>Total Devices</th>
    <td>{{ $totalDevices }}</td>
  </tr>
  <tr>
    <th>In Stock</th>
    <td>{{ $inStock }}</td>
  </tr>
  <tr>
    <th>In Use</th>
    <td>{{ $inUse }}</td>
  </tr>
  <tr>
    <th>Faulty</th>
    <td>{{ $faulty }}</td>
  </tr>
  <tr>
    <th>New Devices</th>
    <td>{{ $newDevices }}</td>
  </tr>
  <tr>
    <th>Old Devices</th>
    <td>{{ $oldDevices }}</td>
  </tr>
</table>

<br>

{{-- Product-wise Available Stock --}}
<h3>Available Stock Summary</h3>

<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>Product</th>
    <th>New Quantity</th>
    <th>Old Quantity</th>
    <th>Total Quantity</th>
  </tr>

  @forelse ($stockSummary as $summary)
  <tr>
    <td>{{ $summary['product']->model_name }}</td>
    <td>{{ $summary['new_quantity'] }}</td>
    <td>{{ $summary['old_quantity'] }}</td>
    <td>{{ $summary['total_quantity'] }}</td>
  </tr>
  @empty
  <tr>
    <td colspan="4">No available stock found.</td>
  </tr>
  @endforelse
</table>

<br>

{{-- Success Message --}}
@if(session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

{{-- All Devices --}}
<h3>All Devices</h3>

<a href="{{ route('devices.create') }}">
  + Add New Device
</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">

  <tr>
    <th>Product</th>
    <th>Serial Number</th>
    <th>MAC Address</th>
    <th>Condition</th>
    <th>Status</th>
    <th>Warehouse</th>
    <th>Actions</th>
  </tr>

  @forelse($devices as $device)

  <tr>
    <td>{{ $device->product->model_name }}</td>

    <td>{{ $device->serial_number ?? 'N/A' }}</td>

    <td>{{ $device->mac_address ?? 'N/A' }}</td>

    <td>{{ ucfirst($device->condition) }}</td>

    <td>
      {{ ucfirst(str_replace('_', ' ', $device->status)) }}
    </td>

    <td>{{ $device->warehouse->name ?? 'Not Assigned' }}</td>

    <td>
      <a href="{{ route('devices.show', $device->id) }}">
        View
      </a>

      |

      <a href="{{ route('devices.edit', $device->id) }}">
        Edit
      </a>

      |

      <form
        action="{{ route('devices.destroy', $device->id) }}"
        method="POST"
        style="display: inline;">

        @csrf
        @method('DELETE')

        <button
          type="submit"
          onclick="return confirm('Are you sure you want to delete this device?')">
          Delete
        </button>

      </form>
    </td>
  </tr>

  @empty

  <tr>
    <td colspan="7">No devices found.</td>
  </tr>

  @endforelse

</table>

@endsection