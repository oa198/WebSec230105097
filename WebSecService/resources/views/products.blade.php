@extends('layouts.master')

@section('title', 'Product Catalog')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Product Catalog</h3>

    <div class="row">
        @forelse ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if (!empty($product['image']))
                    <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">{{ $product['description'] }}</p>
                    <p class="card-text"><strong>${{ number_format($product['price'], 2) }}</strong></p>
                    <form action="{{ route('cart.add', $product['id']) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">No products available at the moment. Please check back later.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection
