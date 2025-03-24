@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Supermarket Bill</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill as $item)
            <tr>
                <td>{{ $item['item'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>${{ number_format($item['price'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
