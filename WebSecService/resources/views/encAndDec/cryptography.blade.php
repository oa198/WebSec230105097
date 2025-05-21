@extends('layouts.master')

@section('title', 'Cryptography Utility')

@section('content')
    <h1>Cryptography Utility</h1>
    <div class="form-container">
        <form method="GET" action="{{ route('cryptography') }}">
            @csrf
            <textarea name="data" placeholder="Enter text to process" required>{{ old('data', $data) }}</textarea>
            <select name="action">
                <option value="Encrypt" {{ $action === 'Encrypt' ? 'selected' : '' }}>Encrypt</option>
                <option value="Decrypt" {{ $action === 'Decrypt' ? 'selected' : '' }}>Decrypt</option>
                <option value="Hash" {{ $action === 'Hash' ? 'selected' : '' }}>Hash</option>
                <option value="Sign" {{ $action === 'Sign' ? 'selected' : '' }}>Sign</option>
                <option value="Verify" {{ $action === 'Verify' ? 'selected' : '' }}>Verify</option>
            </select>
            <input type="text" name="result" value="{{ $result }}" placeholder="Result (for Verify)">
            <button type="submit">Submit</button>
        </form>
    </div>
    <div class="result">
        <p><strong>Result Status:</strong> {{ $status }}</p>
        @if($result) <p><strong>Result:</strong> {{ $result }}</p> @endif
    </div>
@endsection
