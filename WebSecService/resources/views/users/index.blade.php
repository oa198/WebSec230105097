@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Users List</h2>

    <!-- Search Form -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i> Search
            </button>
        </div>
    </form>

    <!-- Add User Button -->
    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-user-plus"></i> Add User
    </a>

    <!-- Users Table -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
