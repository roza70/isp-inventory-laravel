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

{{-- Error Message --}}
@if(session('error'))
<p style="color: red;">
  {{ session('error') }}
</p>
@endif

{{-- Device Search and Filter --}}
<h3>Search and Filter Devices</h3>

<form action="{{ route('devices.index') }}" method="GET">

  <label>Model Name:</label>
  <input
    type="text"
    name="model_name"
    value="{{ request('model_name') }}"
    placeholder="Enter model name">

  <br><br>

  <label>Serial Number:</label>
  <input
    type="text"
    name="serial_number"
    value="{{ request('serial_number') }}"
    placeholder="Enter serial number">

  <br><br>

  <label>Status:</label>
  <select name="status">
    <option value="">All Statuses</option>
    <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
    <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
    <option value="faulty" {{ request('status') == 'faulty' ? 'selected' : '' }}>Faulty</option>
    <option value="written_off" {{ request('status') == 'written_off' ? 'selected' : '' }}>Written Off</option>
    <option value="wasted" {{ request('status') == 'wasted' ? 'selected' : '' }}>Wasted</option>
  </select>

  <br><br>

  <label>Organization:</label>
  <select name="organization_id">
    <option value="">All Organizations</option>

    @foreach ($organizations as $organization)
    <option
      value="{{ $organization->id }}"
      {{ request('organization_id') == $organization->id ? 'selected' : '' }}>
      {{ $organization->name }}
    </option>
    @endforeach
  </select>

  <br><br>

  <button type="submit">Search / Filter</button>

  <a href="{{ route('devices.index') }}">Clear Filters</a>

</form>

<br>

{{-- All Devices --}}
<h3>All Devices</h3>

<p>Matching Devices: {{ $devices->count() }}</p>

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