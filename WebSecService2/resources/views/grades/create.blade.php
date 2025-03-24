@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Grade</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grades.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Student Name</label>
            <input type="text" name="student_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Score</label>
            <input type="number" name="score" class="form-control" min="0" max="100" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Term</label>
            <input type="text" name="term" class="form-control" required placeholder="e.g., Fall 2024">
        </div>

        <div class="mb-3">
            <label class="form-label">Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success">Save Grade</button>
    </form>
</div>
@endsection
