@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create User</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_admin" value="1">
            <label class="form-check-label">Set as Admin</label>
        </div>
        <div class="form-check">
    <input class="form-check-input" type="checkbox" name="is_admin" value="1">
    <label class="form-check-label">Set as Admin</label>
</div>

        <button type="submit" class="btn btn-success">Create User</button>
    </form>
</div>
@endsection
