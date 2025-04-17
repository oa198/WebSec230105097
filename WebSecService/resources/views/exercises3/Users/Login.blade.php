@extends('layouts.master')

@section('content')
<form action="{{route('do_login')}}" method="post">
  {{ csrf_field() }}
  <div class="form-group">
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      <strong>Error!</strong> {{$error}}
      </div>
    @endforeach
  </div>
  <div class="form-group mb-2">
    <label for="model" class="form-label">Email:</label>
    <input type="email" class="form-control" placeholder="email" name="email" required>
  </div>
  <div class="form-group mb-2">
    <label for="model" class="form-label">Password:</label>
    <label for="model" class="form-label">Password:</label>
    <input type="password" class="form-control" placeholder="password" name="password" required>
  </div>
  <div class="form-group mb-2">
    <button type="submit" class="btn btn-primary">Login</button>
  </div>
</form>
@endsection
