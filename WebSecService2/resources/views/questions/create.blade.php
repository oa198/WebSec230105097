@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create MCQ</h2>
    <form action="{{ route('questions.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Question</label>
        <input type="text" name="question" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Option A</label>
        <input type="text" name="option_a" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Option B</label>
        <input type="text" name="option_b" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Option C</label>
        <input type="text" name="option_c" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Option D</label>
        <input type="text" name="option_d" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Correct Answer</label>
        <select name="correct_answer" class="form-control" required>
            <option value="option_a">A</option>
            <option value="option_b">B</option>
            <option value="option_c">C</option>
            <option value="option_d">D</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
@endsection
