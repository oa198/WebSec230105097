@extends('layouts.master')
@section('title', 'Products')
@section('content')

<div class="row mt-2 mb-4">
    <div class="col col-10">
        <h1>Products Inventory</h1>
    </div>
    <div class="col col-2">
        @can('add_products')
        <a href="{{ route('products.create') }}" class="btn btn-success btn-sm form-control">
            <i class="fas fa-plus"></i> Add Product
        </a>
        @endcan
    </div>
</div>


@if(auth()->check() && auth()->user()->hasRole('Customer'))
<div class="alert alert-info mb-4">
    <i class="fas fa-wallet"></i> <strong>Available Credit:</strong> ${{ number_format(auth()->user()->credit, 2, '.', ',') }}
</div>
@endif

<div class="row">
    @foreach($products as $product)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-img-top-container" style="height: 200px; overflow: hidden;">
                <img src="{{ asset('image/' . $product->photo) }}"
                     class="card-img-top img-fluid p-2"
                     alt="{{ $product->name }}"
                     style="object-fit: contain; height: 100%; width: 100%;">
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Model: {{ $product->model }}</h6>
                <div class="product-meta mb-3">
                    <span class="badge bg-primary">Code: {{ $product->code }}</span>
                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} ms-2">
                        Stock: {{ $product->stock }}
                    </span>
                </div>
                <p class="card-text text-truncate">{{ $product->description }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-primary mb-0">${{ number_format($product->price, 2, '.', ',') }}</h4>

                    <div class="btn-group">
                        @can('edit_products')
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="btn btn-sm btn-outline-secondary">
                           <i class="fas fa-edit"></i>
                        </a>
                        @endcan

                        @can('delete_products')
                        <form action="{{ route('products.delete', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>

                @if(auth()->check() && auth()->user()->hasRole('Customer'))
                    @if($product->stock > 0)
                        @if(auth()->user()->credit >= $product->price)
                            <form action="{{ route('products.buy', $product->id) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="input-group">
                                    <input type="number"
                                           name="quantity"
                                           value="1"
                                           min="1"
                                           max="{{ $product->stock }}"
                                           class="form-control form-control-sm">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-cart-plus"></i> Buy
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-warning mt-3 p-2">
                                <small>
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Need ${{ number_format($product->price - auth()->user()->credit, 2, '.', ',') }} more
                                </small>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-danger mt-3 p-2">
                            <small>
                                <i class="fas fa-times-circle"></i> Out of stock
                            </small>
                        </div>
                    @endif
                @endif
            </div>
            <div class="card-footer bg-transparent">
                <small class="text-muted">
                    Last updated: {{ $product->updated_at ? $product->updated_at->diffForHumans() : 'Never' }}
                </small>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
