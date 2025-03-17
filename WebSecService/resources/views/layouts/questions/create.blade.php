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
            <label class="form-label">Options</label>
            <input type="text" name="option_a" class="form-control mb-1" placeholder="Option A" required>
            <input type="text" name="option_b" class="form-control mb-1" placeholder="Option B" required>
            <input type="text" name="option_c" class="form-control mb-1" placeholder="Option C" required>
            <input type="text" name="option_d" class="form-control mb-1" placeholder="Option D" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correct Answer</label>
            <select name="correct_answer" class="form-control" required>
                <option value="option_a">Option A</option>
                <option value="option_b">Option B</option>
                <option value="option_c">Option C</option>
                <option value="option_d">Option D</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Question</button>
    </form>
</div>
@endsection
