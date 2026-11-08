@extends('layouts.app')

@section('content')

<h2>Warehouse Management</h2>

@if(session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

<h3>All Warehouses</h3>

<a href="{{ route('warehouses.create') }}">
  + Add New Warehouse
</a>

<br><br>

<table border="1" cellpadding="10">

  <tr>
    <th>Name</th>
    <th>Location</th>
    <th>Remarks</th>
    <th>Actions</th>
  </tr>

  @forelse($warehouses as $warehouse)

  <tr>
    <td>{{ $warehouse->name }}</td>
    <td>{{ $warehouse->location }}</td>
    <td>{{ $warehouse->remarks }}</td>

    <td>
      <a href="{{ route('warehouses.show', $warehouse->id) }}">
        View
      </a>

      |

      <a href="{{ route('warehouses.edit', $warehouse->id) }}">
        Edit
      </a>

      |

      <form
        action="{{ route('warehouses.destroy', $warehouse->id) }}"
        method="POST"
        style="display: inline;">
        @csrf
        @method('DELETE')

        <button
          type="submit"
          onclick="return confirm('Are you sure you want to delete this warehouse?')">
          Delete
        </button>
      </form>
    </td>
  </tr>

  @empty

  <tr>
    <td colspan="4">No warehouses found.</td>
  </tr>

  @endforelse

</table>

@endsection