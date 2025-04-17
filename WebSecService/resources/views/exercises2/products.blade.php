@extends('layouts.master')

@section('title', 'Product Catalog')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Our Products</h2>

    <div class="row">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">{{ $product['description'] }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 text-primary">${{ number_format($product['price'], 2) }}</span>
                        <button class="btn btn-sm btn-outline-primary add-to-cart"
                                data-id="{{ $product['id'] }}">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



@endsection
