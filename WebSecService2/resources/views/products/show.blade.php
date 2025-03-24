@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Product Details</h2>

    <div class="card">
        <div class="card-body">
            <h3>{{ $product->name }}</h3>
            <p><strong>Code:</strong> {{ $product->code }}</p>
            <p><strong>Price:</strong> ${{ $product->price }}</p>
            <p><strong>Model:</strong> {{ $product->model }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>

            @if($product->photo)
                <img src="{{ asset('storage/' . $product->photo) }}" width="200">
            @endif

            <br><br>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
