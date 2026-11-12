@extends('layouts.app')

@section('content')

<h2>Stock Adjustment History</h2>

@if (session('success'))
<p style="color: green;">
  {{ session('success') }}
</p>
@endif

@if ($errors->any())
<div style="color: red;">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<a href="{{ route('stock-adjustments.create') }}">
  + New Stock Adjustment
</a>

<br><br>

<table border="1" cellpadding="10">
  <thead>
    <tr>
      <th>Product</th>
      <th>Serial / MAC</th>
      <th>Warehouse</th>
      <th>Adjustment Type</th>
      <th>Date</th>
      <th>Reason</th>
      <th>Remarks</th>
      <th>Approval Status</th>
      <th>Action By</th>
      <th>Approval Remarks</th>
      <th>Action</th>
    </tr>
  </thead>

  <tbody>
    @forelse ($adjustments as $adjustment)

    @php
    $product = $adjustment->product
    ?? $adjustment->device?->product;

    $warehouse = $adjustment->warehouse
    ?? $adjustment->device?->warehouse;

    $serialOrMac = $adjustment->serial_number
    ?? $adjustment->mac_address
    ?? $adjustment->device?->serial_number
    ?? $adjustment->device?->mac_address;
    @endphp

    <tr>
      <td>
        @if ($product)
        {{ $product->brand }} -
        {{ $product->model_name }}
        @else
        N/A
        @endif
      </td>

      <td>
        {{ $serialOrMac ?? 'N/A' }}
      </td>

      <td>
        {{ $warehouse->name ?? 'Not Assigned' }}
      </td>

      <td>
        {{ ucfirst($adjustment->adjustment_type) }}
      </td>

      <td>
        {{ $adjustment->adjustment_date?->format('Y-m-d') ?? 'N/A' }}
      </td>

      <td>
        {{ $adjustment->reason }}
      </td>

      <td>
        {{ $adjustment->remarks ?? 'N/A' }}
      </td>

      <td>
        {{ ucfirst($adjustment->approval_status) }}
      </td>

      <td>
        {{ $adjustment->approver->name ?? 'N/A' }}
      </td>

      <td>
        {{ $adjustment->approval_remarks ?? 'N/A' }}
      </td>

      <td>
        @if ($adjustment->approval_status === 'pending')

        <form
          action="{{ route('stock-adjustments.approve', $adjustment->id) }}"
          method="POST">
          @csrf

          <textarea
            name="approval_remarks"
            placeholder="Optional approval remarks"></textarea>

          <br>

          <button type="submit">
            Approve
          </button>
        </form>

        <br>

        <form
          action="{{ route('stock-adjustments.reject', $adjustment->id) }}"
          method="POST">
          @csrf

          <textarea
            name="approval_remarks"
            placeholder="Reason for rejection"
            required></textarea>

          <br>

          <button type="submit">
            Reject
          </button>
        </form>

        @else

        No action available

        @endif
      </td>
    </tr>

    @empty

    <tr>
      <td colspan="11">
        No stock adjustments found.
      </td>
    </tr>

    @endforelse
  </tbody>
</table>

@endsection