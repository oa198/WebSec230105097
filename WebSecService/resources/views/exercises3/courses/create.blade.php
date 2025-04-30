@extends('layouts.master')

@section('title', 'Add Course')

@section('content')
<div class="container">
    <h2>Add New Course</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('exercises3.courses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Course Code</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Course Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="credit_hours" class="form-label">Credit Hours</label>
            <input type="number" name="credit_hours" id="credit_hours" class="form-control" value="{{ old('credit_hours') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Create Course</button>
    </form>
</div>
@endsection
