@extends('layouts.app')

@section('content')

<h2>Edit Organization</h2>

<form action="{{ route('organizations.update', $organization->id) }}" method="POST">

  @csrf
  @method('PUT')

  <div>
    <label>Organization Name:</label>

    <input
      type="text"
      name="name"
      value="{{ old('name', $organization->name) }}"
      required
      maxlength="255">

    @error('name')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Address:</label>

    <textarea name="address">{{ old('address', $organization->address) }}</textarea>

    @error('address')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Phone:</label>

    <input
      type="text"
      name="phone"
      value="{{ old('phone', $organization->phone) }}"
      maxlength="30">

    @error('phone')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <div>
    <label>Remarks:</label>

    <textarea name="remarks">{{ old('remarks', $organization->remarks) }}</textarea>

    @error('remarks')
    <p style="color: red;">{{ $message }}</p>
    @enderror
  </div>

  <br>

  <button type="submit">Update Organization</button>

  <a href="{{ route('organizations.index') }}">Cancel</a>

</form>

@endsection