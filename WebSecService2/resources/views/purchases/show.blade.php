@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Purchase {{ $product->name }}</div>

                <div class="card-body">
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Available Stock:</strong> {{ $product->stock }}</p>
                    <p><strong>Your Credit:</strong> ${{ number_format($userCredit, 2) }}</p>

                    <form method="POST" action="{{ route('purchases.store', $product) }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="number"
                                   class="form-control @error('quantity') is-invalid @enderror"
                                   id="quantity"
                                   name="quantity"
                                   min="1"
                                   max="{{ $product->stock }}"
                                   value="{{ old('quantity', 1) }}"
                                   required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Confirm Purchase</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
