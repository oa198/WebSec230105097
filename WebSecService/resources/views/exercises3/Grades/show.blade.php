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
                    <label class="form-label">Student Name</label>
                    <input type="text" class="form-control" value="{{ $grade->user->name }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Code</label>
                    <input type="text" class="form-control" value="{{ $grade->course_code }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Name</label>
                    <input type="text" class="form-control" value="{{ $grade->course->name }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Credit Hours</label>
                    <input type="text" class="form-control" value="{{ $grade->course->credit_hours }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Grade</label>
                    <input type="text" class="form-control" value="{{ $grade->grade }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Grade Points</label>
                    <input type="text" class="form-control" value="{{ number_format($grade->grade_point, 2) }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Quality Points</label>
                    <input type="text" class="form-control" value="{{ number_format($grade->quality_points, 2) }}" disabled>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Term</label>
                    <input type="text" class="form-control" value="{{ $grade->term }}" disabled>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Year</label>
                    <input type="text" class="form-control" value="{{ $grade->year }}" disabled>
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
