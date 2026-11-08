@extends('layouts.app')

@section('content')

<h2>Create New Warehouse</h2>

<form action="{{ route('warehouses.store') }}" method="POST">

  @csrf

  <div>
    <label>Warehouse Name:</label>

    <input
      type="text"
      name="name"
      value="{{ old('name') }}"
      required
      maxlength="255">

    @error('name')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Location:</label>

    <textarea name="location">{{ old('location') }}</textarea>

    @error('location')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Remarks:</label>

    <textarea name="remarks">{{ old('remarks') }}</textarea>

    @error('remarks')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <button type="submit">Save Warehouse</button>

  <a href="{{ route('warehouses.index') }}">Cancel</a>

</form>

@endsection