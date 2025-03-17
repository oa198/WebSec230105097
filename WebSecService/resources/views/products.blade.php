@extends('layouts.master')

@section('title', 'Product Catalog')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Product Catalog</h3>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
            
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">{{ $product['description'] }}</p>
                    <p class="card-text"><strong>${{ number_format($product['price'], 2) }}</strong></p>
                    <button class="btn btn-primary">Add to Cart</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
