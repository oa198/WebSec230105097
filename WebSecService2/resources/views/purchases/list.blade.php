@extends('layouts.master')
@section('title', 'Purchase History')
@section('content')

<div class="row mt-2 mb-4">
    <div class="col col-10">
        <h1>Purchase History</h1>
    </div>
</div>

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
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Purchase Date</th>
                    <th>Status</th>
                    <th>Status Messages</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->product->name }}</td>
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
                                                    <strong>{{ $message->created_at->format('m/d/Y H:i') }}:</strong> {{ $message->message }}
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
                @empty
                <tr>
                    <td colspan="5" class="text-center">No purchases found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
