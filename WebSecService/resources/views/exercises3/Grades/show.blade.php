@extends('layouts.master')

@section('title', 'Grade Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Grade Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="course_code" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="course_code" name="course_code" value="{{ $grade->course_code }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="course_name" name="course_name" value="{{ $grade->course_name }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="credit_hours" class="form-label">Credit Hours</label>
                    <input type="number" class="form-control" id="credit_hours" name="credit_hours" value="{{ $grade->credit_hours }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="grade" class="form-label">Grade</label>
                    <input type="text" class="form-control" id="grade" name="grade" value="{{ $grade->grade }}" disabled>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="term" class="form-label">Term</label>
                    <input type="text" class="form-control" id="term" name="term" value="{{ $grade->term }}" disabled>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="text" class="form-control" id="year" name="year" value="{{ $grade->year }}" disabled>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('exercises3.Grades.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Grades List
                </a>
                <a href="{{ route('exercises3.Grades.edit', $grade->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Grade
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
