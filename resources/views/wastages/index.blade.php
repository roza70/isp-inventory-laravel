@extends('layouts.app')

@section('content')

<h2>Wastage Management</h2>

@if (session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

<p>
  <strong>Total Wastage Records:</strong>
  {{ $totalWastages }}
</p>

<a href="{{ route('wastages.create') }}">
  + Register New Wastage
</a>

<br><br>

<h3>Wastage History</h3>

@if ($wastages->isEmpty())

<p>No wastage records found.</p>

@else

<table border="1" cellpadding="10" cellspacing="0">

  <thead>
    <tr>
      <th>ID</th>
      <th>Product</th>
      <th>Serial Number</th>
      <th>MAC Address</th>
      <th>Warehouse</th>
      <th>Wastage Date</th>
      <th>Reason</th>
      <th>Remarks</th>
    </tr>
  </thead>

  <tbody>

    @foreach ($wastages as $wastage)

    <tr>
      <td>{{ $wastage->id }}</td>

      <td>
        {{ $wastage->device->product->model_name }}
      </td>

      <td>
        {{ $wastage->device->serial_number ?? 'N/A' }}
      </td>

      <td>
        {{ $wastage->device->mac_address ?? 'N/A' }}
      </td>

      <td>
        {{ $wastage->device->warehouse->name ?? 'Not Assigned' }}
      </td>

      <td>
        {{ $wastage->wastage_date }}
      </td>

      <td>
        {{ $wastage->reason }}
      </td>

      <td>
        {{ $wastage->remarks ?? 'N/A' }}
      </td>
    </tr>

    @endforeach

  </tbody>

</table>

@endif

@endsection