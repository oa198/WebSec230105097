@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Grade</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Student Name</label>
            <input type="text" name="student_name" class="form-control" value="{{ $grade->student_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" value="{{ $grade->subject }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Score</label>
            <input type="number" name="score" class="form-control" min="0" max="100" value="{{ $grade->score }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Term</label>
            <input type="text" name="term" class="form-control" value="{{ $grade->term }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" min="1" value="{{ $grade->credit_hours }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Grade</button>
    </form>
</div>
@endsection
