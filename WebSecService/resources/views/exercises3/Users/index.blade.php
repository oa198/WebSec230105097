@extends('layouts.master')

@section('title', 'Users List')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Users Management</h5>
        <a href="{{ route('exercises3.Users.create') }}" class="btn btn-primary">Create User</a>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Filter Form (unchanged) -->
        <div class="mb-4">
            <form action="{{ route('exercises3.Users.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ request('name') }}" placeholder="Filter by name...">
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                           value="{{ request('email') }}" placeholder="Filter by email...">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            Filter
                        </button>
                        <a href="{{ route('exercises3.Users.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('exercises3.Users.show', $user->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('exercises3.Users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('exercises3.Users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
