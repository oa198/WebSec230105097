@extends('layouts.master')

@section('title', 'Calculator')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Simple Calculator</h4>
            </div>
            <div class="card-body">
                <form id="calcForm">
                    <div class="mb-3">
                        <input type="number" step="any" class="form-control" id="num1" placeholder="First number" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" step="any" class="form-control" id="num2" placeholder="Second number" required>
                    </div>
                    <div class="btn-group mb-3 w-100">
                        <button type="button" class="btn btn-outline-primary operation" data-op="+">+</button>
                        <button type="button" class="btn btn-outline-primary operation" data-op="-">-</button>
                        <button type="button" class="btn btn-outline-primary operation" data-op="*">×</button>
                        <button type="button" class="btn btn-outline-primary operation" data-op="/">÷</button>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="result" placeholder="Result" readonly>
                    </div>
                    <div id="message" class="alert alert-danger d-none" role="alert"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.operation').click(function() {
        const num1 = parseFloat($('#num1').val());
        const num2 = parseFloat($('#num2').val());
        const op = $(this).data('op');
        const messageBox = $('#message');

        messageBox.addClass('d-none').text('');

        if (isNaN(num1) || isNaN(num2)) {
            messageBox.removeClass('d-none').text('Please enter both numbers.');
            $('#result').val('');
            return;
        }

        let result;
        switch(op) {
            case '+': result = num1 + num2; break;
            case '-': result = num1 - num2; break;
            case '*': result = num1 * num2; break;
            case '/':
                if (num2 === 0) {
                    messageBox.removeClass('d-none').text('Cannot divide by zero!');
                    $('#result').val('');
                    return;
                }
                result = num1 / num2;
                break;
        }

        $('#result').val(result.toFixed(2));
    });
});
</script>
@endpush
@endsection
