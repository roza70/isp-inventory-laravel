@extends('layouts.app')

@section('content')

<h2>Organization Details</h2>

<p>
  <strong>Organization Name:</strong>
  {{ $organization->name }}
</p>

<p>
  <strong>Address:</strong>
  {{ $organization->address ?? 'N/A' }}
</p>

<p>
  <strong>Phone:</strong>
  {{ $organization->phone ?? 'N/A' }}
</p>

<p>
  <strong>Remarks:</strong>
  {{ $organization->remarks ?? 'N/A' }}
</p>

<br>

<a href="{{ route('organizations.edit', $organization->id) }}">
  Edit Organization
</a>

<br><br>

<a href="{{ route('organizations.index') }}">
  Back to Organizations
</a>

@endsection