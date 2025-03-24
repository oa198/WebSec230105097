@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Simple Calculator</h2>
    <form method="POST" action="/calculator">
        @csrf
        <input type="number" name="num1" placeholder="Enter number 1" required>
        <input type="number" name="num2" placeholder="Enter number 2" required>
        <select name="operation">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">×</option>
            <option value="/">÷</option>
        </select>
        <button type="submit">Calculate</button>
    </form>

    @if(isset($result))
        <h3>Result: {{ $result }}</h3>
    @endif
</div>
@endsection
