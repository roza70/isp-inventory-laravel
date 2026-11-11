@extends('layouts.app')

@section('content')

<h2>Router Transaction History</h2>

@if(session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

<a href="{{ route('router-transactions.create') }}">
  + Record New Transaction
</a>

<table border="1" cellpadding="10" cellspacing="0">
  <thead>
    <tr>
      <th>Product</th>
      <th>Serial Number</th>
      <th>MAC Address</th>
      <th>Organization</th>
      <th>Address</th>
      <th>Delivery Date</th>
      <th>Status</th>
      <th>Remarks</th>
    </tr>
  </thead>

  <tbody>
    @forelse($transactions as $transaction)
    <tr>
      <td>
        {{ $transaction->device->product->brand }}
        - {{ $transaction->device->product->model_name }}
      </td>

      <td>
        {{ $transaction->device->serial_number ?? 'N/A' }}
      </td>

      <td>
        {{ $transaction->device->mac_address ?? 'N/A' }}
      </td>

      <td>{{ $transaction->organization->name }}</td>

      <td>
        {{ $transaction->organization->address ?? 'N/A' }}
      </td>

      <td>{{ $transaction->delivery_date }}</td>

      <td>{{ ucfirst($transaction->status) }}</td>

      <td>{{ $transaction->remarks ?? 'N/A' }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="8">No transactions found.</td>
    </tr>
    @endforelse
  </tbody>
</table>

@endsection