@extends('layouts.master')

@section('title', 'Simple Calculator')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Simple Calculator</h3>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <input type="number" id="num1" class="form-control mb-2" placeholder="Enter first number">
            <input type="number" id="num2" class="form-control mb-2" placeholder="Enter second number">
            <div class="mb-2">
                <button class="btn btn-primary" onclick="calculate('+')">+</button>
                <button class="btn btn-primary" onclick="calculate('-')">-</button>
                <button class="btn btn-primary" onclick="calculate('*')">*</button>
                <button class="btn btn-primary" onclick="calculate('/')">/</button>
            </div>
            <h4 class="mt-3">Result: <span id="result">0</span></h4>
        </div>
    </div>
</div>

<script>
    function calculate(op) {
        const num1 = parseFloat(document.getElementById('num1').value);
        const num2 = parseFloat(document.getElementById('num2').value);
        let result;

        if (isNaN(num1) || isNaN(num2)) {
            result = 'Please enter valid numbers.';
        } else {
            switch(op) {
                case '+':
                    result = num1 + num2;
                    break;
                case '-':
                    result = num1 - num2;
                    break;
                case '*':
                    result = num1 * num2;
                    break;
                case '/':
                    result = num2 !== 0 ? (num1 / num2).toFixed(2) : 'Cannot divide by zero';
                    break;
                default:
                    result = 'Invalid operation';
            }
        }

        document.getElementById('result').textContent = result;
    }
</script>
@endsection
