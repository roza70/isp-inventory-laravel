@extends('layouts.app')

@section('content')

<h2>Warehouse Transfer History</h2>

@if (session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

@if ($errors->any())
<div style="color: red;">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<a href="{{ route('warehouse-transfers.create') }}">
  + Transfer Device
</a>

<table border="1" cellpadding="10">
  <thead>
    <tr>
      <th>Product</th>
      <th>Serial / MAC</th>
      <th>From Warehouse</th>
      <th>To Warehouse</th>
      <th>Transfer Date</th>
      <th>Remarks</th>
      <th>Approval Status</th>
      <th>Approved By</th>
      <th>Approval Remarks</th>
      <th>Action</th>
    </tr>
  </thead>

  <tbody>
    @forelse ($transfers as $transfer)
    <tr>
      <td>
        {{ $transfer->device->product->brand }}
        -
        {{ $transfer->device->product->model_name }}
      </td>

      <td>
        {{ $transfer->device->serial_number
                        ?? $transfer->device->mac_address }}
      </td>

      <td>{{ $transfer->fromWarehouse->name }}</td>

      <td>{{ $transfer->toWarehouse->name }}</td>

      <td>{{ $transfer->transfer_date }}</td>

      <td>{{ $transfer->remarks ?? 'N/A' }}</td>

      <td>{{ ucfirst($transfer->approval_status) }}</td>

      <td>
        {{ $transfer->approver->name ?? 'N/A' }}
      </td>

      <td>
        {{ $transfer->approval_remarks ?? 'N/A' }}
      </td>

      <td>
        @if ($transfer->approval_status === 'pending')

        @if (auth()->user()->isAdmin())

        <form
          action="{{ route('warehouse-transfers.approve', $transfer) }}"
          method="POST"
          style="margin-bottom: 10px;">
          @csrf

          <input
            type="text"
            name="approval_remarks"
            placeholder="Approval remarks">

          <button type="submit">
            Approve
          </button>
        </form>

        <form
          action="{{ route('warehouse-transfers.reject', $transfer) }}"
          method="POST">
          @csrf

          <input
            type="text"
            name="approval_remarks"
            placeholder="Rejection reason">

          <button type="submit">
            Reject
          </button>
        </form>

        @else
        No permission
        @endif

        @else
        No action available
        @endif
      </td>
    </tr>

    @empty
    <tr>
      <td colspan="10">
        No transfer history found.
      </td>
    </tr>
    @endforelse
  </tbody>
</table>

@endsection