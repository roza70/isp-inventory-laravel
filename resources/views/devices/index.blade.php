@extends('layouts.app')

@section('content')

<h2>Device Management</h2>

@if(session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

<h3>All Devices</h3>

<a href="{{ route('devices.create') }}">
  + Add New Device
</a>

<br><br>

<table border="1" cellpadding="10">

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

    <td>{{ ucfirst(str_replace('_', ' ', $device->status)) }}</td>

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