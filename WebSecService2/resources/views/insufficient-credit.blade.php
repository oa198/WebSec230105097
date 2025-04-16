@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger">
                <h4>Insufficient Credit</h4>
                <p>You don't have enough credit to complete this purchase.</p>
                <p>Current Credit: ${{ number_format(auth()->user()->credit, 2) }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
</div>
@endsection
