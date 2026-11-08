@extends('layouts.app')

@section('content')

<h2>Create New Organization</h2>

<form action="{{ route('organizations.store') }}" method="POST">

  @csrf

  <div>
    <label>Organization Name:</label>
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
    <label>Address:</label>
    <textarea name="address">{{ old('address') }}</textarea>

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
      value="{{ old('phone') }}"
      maxlength="30">

    @error('phone')
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

  <button type="submit">Save Organization</button>

  <a href="{{ route('organizations.index') }}">Cancel</a>

</form>

@endsection