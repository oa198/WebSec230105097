@extends('layouts.app')

@section('content')
<div class="container">
    <h2>MCQ Exam</h2>
    <form action="{{ route('exam.submit') }}" method="POST">
        @csrf
        @foreach($questions as $question)
            <div class="mb-3">
                <p><strong>{{ $question->question }}</strong></p>
                <label><input type="radio" name="answers[{{ $question->id }}]" value="A" required> {{ $question->option_a }}</label><br>
                <label><input type="radio" name="answers[{{ $question->id }}]" value="B"> {{ $question->option_b }}</label><br>
                <label><input type="radio" name="answers[{{ $question->id }}]" value="C"> {{ $question->option_c }}</label><br>
                <label><input type="radio" name="answers[{{ $question->id }}]" value="D"> {{ $question->option_d }}</label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-success">Submit Exam</button>
    </form>
</div>
@endsection
