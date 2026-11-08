@extends('layouts.app')

@section('content')

<h2>Edit Warehouse</h2>

<form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">

  @csrf
  @method('PUT')

  <div>
    <label>Warehouse Name:</label>

    <input
      type="text"
      name="name"
      value="{{ old('name', $warehouse->name) }}"
      required
      maxlength="255">

    @error('name')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Location:</label>

    <textarea name="location">{{ old('location', $warehouse->location) }}</textarea>

    @error('location')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Remarks:</label>

    <textarea name="remarks">{{ old('remarks', $warehouse->remarks) }}</textarea>

    @error('remarks')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <button type="submit">Update Warehouse</button>

  <a href="{{ route('warehouses.index') }}">Cancel</a>

</form>

@endsection