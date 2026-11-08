@extends('layouts.app')

@section('content')

<h2>Organization Management</h2>

@if(session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

<h3>All Organizations</h3>

<a href="{{ route('organizations.create') }}">
  + Add New Organization
</a>

<br><br>

<table border="1" cellpadding="10">

  <tr>
    <th>Name</th>
    <th>Address</th>
    <th>Phone</th>
    <th>Remarks</th>
    <th>Actions</th>
  </tr>

  @forelse($organizations as $organization)

  <tr>
    <td>{{ $organization->name }}</td>

    <td>{{ $organization->address }}</td>

    <td>{{ $organization->phone }}</td>

    <td>{{ $organization->remarks }}</td>

    <td>
      <a href="{{ route('organizations.show', $organization->id) }}">
        View
      </a>

      |

      <a href="{{ route('organizations.edit', $organization->id) }}">
        Edit
      </a>

      |

      <form
        action="{{ route('organizations.destroy', $organization->id) }}"
        method="POST"
        style="display: inline;">
        @csrf
        @method('DELETE')

        <button
          type="submit"
          onclick="return confirm('Are you sure you want to delete this organization?')">
          Delete
        </button>
      </form>
    </td>
  </tr>

  @empty

  <tr>
    <td colspan="5">No organizations found.</td>
  </tr>

  @endforelse

</table>

@endsection