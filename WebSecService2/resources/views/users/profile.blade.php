@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
<div class="row">
    <div class="m-4 col-sm-6">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-striped">
            <tr><th>Name</th><td>{{ $user->name }}</td></tr>
            <tr><th>Email</th><td>{{ $user->email }}</td></tr>
            <tr><th>Credit</th><td>${{ number_format($user->credit, 2) }}</td></tr>
            <tr><th>Roles</th><td>
                @foreach($user->roles as $role)
                    <span class="badge bg-primary">{{ $role->name }}</span>
                @endforeach
            </td></tr>
        </table>

        <h3>Purchased Products</h3>
        @if($user->purchases->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Purchase Date</th>
                        <th>Status</th>
                        <th>Status Updates</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->product->name }}</td>
                        <td>${{ number_format($purchase->purchase_price, 2) }}</td>
                        <td>{{ $purchase->quantity }}</td>
                        <td>{{ $purchase->created_at->format('m/d/Y') }}</td>
                        <td>
                            <span class="badge
                                @if($purchase->status == 'Pending') bg-warning text-dark
                                @elseif($purchase->status == 'Shipped') bg-info
                                @else bg-success
                                @endif">
                                {{ $purchase->status ?? 'Pending' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#statusMessages{{ $purchase->id }}" aria-expanded="false" aria-controls="statusMessages{{ $purchase->id }}">
                                <i class="fas fa-history"></i> View Updates ({{ $purchase->statusMessages->count() }})
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No purchases yet.</p>
        @endif
    </div>
</div>
@endsection
