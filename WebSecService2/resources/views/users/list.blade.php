@extends('layouts.master')
@section('title', 'Users')
@section('content')

<div class="row mt-2">
    <div class="col col-10">
        <h1>Users Management</h1>
    </div>
    @can('create_employees')
    <div class="col col-2 text-end">
        <a href="{{ route('users.create') }}" class="btn btn-success">Create Employee</a>
    </div>
    @endcan
</div>

<form method="GET" action="{{ route('users') }}">
    <div class="row mt-3">
        <div class="col col-sm-3">
            <input name="keywords" type="text" class="form-control"
                   placeholder="Search by name or email" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-3">
            <select name="role" class="form-select">
                <option value="">All Users</option>
                <option value="Customer" {{ request()->role == 'Customer' ? 'selected' : '' }}>Customers</option>
                <option value="Employee" {{ request()->role == 'Employee' ? 'selected' : '' }}>Employees</option>
                <option value="Admin" {{ request()->role == 'Admin' ? 'selected' : '' }}>Admins</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col col-sm-2">
            <a href="{{ route('users') }}" class="btn btn-danger w-100">Reset</a>
        </div>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif

<div class="card mt-3">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Credit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge
                                @if($role->name == 'Admin') bg-danger
                                @elseif($role->name == 'Employee') bg-warning text-dark
                                @else bg-primary
                                @endif">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        @if($user->hasRole('Customer'))
                            ${{ number_format($user->credit, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            @can('edit_users')
                            <a href="{{ route('users_edit', $user->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @if(auth()->user()->can('add_credit') && $user->hasRole('Customer'))
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#creditModal{{ $user->id }}">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                            @endif

                            @if(auth()->user()->can('track_delivery') && $user->hasRole('Customer'))
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#statusModal{{ $user->id }}">
                                <i class="fas fa-truck"></i>
                            </button>
                            @endif

                            @can('delete_users')
                            <form action="{{ route('users_delete', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>

                        <!-- Add Credit Modal -->
                        @if(auth()->user()->can('add_credit') && $user->hasRole('Customer'))
                        <div class="modal fade" id="creditModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('users.add_credit', $user->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Credit to {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Current Credit</label>
                                                <input type="text" class="form-control"
                                                       value="${{ number_format($user->credit, 2) }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount to Add</label>
                                                <input type="number" name="amount" class="form-control"
                                                       min="0.01" step="0.01" max="9999999.99" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Add Credit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Status Management Modal -->
                        @if(auth()->user()->can('track_delivery') && $user->hasRole('Customer'))
                        <div class="modal fade" id="statusModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Manage Purchase Status for {{ $user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($user->purchases->count() > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Purchase Date</th>
                                                        <th>Status</th>
                                                        <th>Status Messages</th>
                                                        <th>Add Message</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->purchases as $purchase)
                                                    <tr>
                                                        <td>{{ $purchase->product->name }}</td>
                                                        <td>{{ $purchase->quantity }}</td>
                                                        <td>{{ $purchase->created_at->format('m/d/Y') }}</td>
                                                        <td>
                                                            <form action="{{ route('purchases.update_status', $purchase->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                                                    <option value="Pending" {{ $purchase->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="Shipped" {{ $purchase->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                                                    <option value="Delivered" {{ $purchase->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#statusMessages{{ $purchase->id }}" aria-expanded="false" aria-controls="statusMessages{{ $purchase->id }}">
                                                                <i class="fas fa-history"></i> ({{ $purchase->statusMessages->count() }})
                                                            </button>
                                                            <div class="collapse mt-2" id="statusMessages{{ $purchase->id }}">
                                                                <div class="card card-body">
                                                                    @if($purchase->statusMessages->count() > 0)
                                                                        <ul class="list-group list-group-flush">
                                                                            @foreach($purchase->statusMessages as $message)
                                                                                <li class="list-group-item">
                                                                                    <small>
                                                                                    <strong>{{ Carbon\Carbon::parse($message->created_at)->format('m/d/Y H:i') }}:</strong>

                                                                                    </small>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <small class="text-muted">No status updates yet.</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('purchases.add_status_message', $purchase->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" name="message" class="form-control" placeholder="Add status message" required>
                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No purchases found for this user.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
