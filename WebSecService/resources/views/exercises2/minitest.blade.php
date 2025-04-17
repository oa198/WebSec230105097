@extends('layouts.master')

@section('title', 'Supermarket Bill')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0 text-center">Supermarket Bill</h4>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">Item</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($marks as $item)
                    <tr>
                        <td>{{ $item['item'] }}</td>
                        <td class="text-center">{{ $item['quantity'] }}</td>
                        <td class="text-end">${{ number_format($item['price'], 2) }}</td>
                        <td class="text-end">${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total Amount</td>
                        <td class="text-end fw-bold">
                            ${{ number_format(collect($marks)->sum(fn($item) => $item['quantity'] * $item['price']), 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
