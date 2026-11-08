@extends('layouts.app')

@section('content')

<h2>Warehouse Details</h2>

<p>
  <strong>Warehouse Name:</strong>
  {{ $warehouse->name }}
</p>

<p>
  <strong>Location:</strong>
  {{ $warehouse->location ?? 'N/A' }}
</p>

<p>
  <strong>Remarks:</strong>
  {{ $warehouse->remarks ?? 'N/A' }}
</p>

<br>

<a href="{{ route('warehouses.edit', $warehouse->id) }}">
  Edit Warehouse
</a>

<br><br>

<a href="{{ route('warehouses.index') }}">
  Back to Warehouses
</a>

@endsection