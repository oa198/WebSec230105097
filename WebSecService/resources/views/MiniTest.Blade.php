<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniTest - Supermarket Bill</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Supermarket Bill</h2>
        <table class="table table-bordered table-striped table-hover text-center">
    <thead class="table-primary">
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody class="table-light">
        @foreach ($bill as $item)
        <tr>
            <td>{{ $item['item'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>${{ number_format($item['price'], 2) }}</td>
            <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot class="table-warning">
        <tr>
            <td colspan="3" class="text-end fw-bold">Total Amount</td>
            <td class="fw-bold">
                ${{ number_format(collect($bill)->sum(fn($item) => $item['quantity'] * $item['price']), 2) }}
            </td>
        </tr>
    </tfoot>
</table>

    </div>
</body>
</html>


