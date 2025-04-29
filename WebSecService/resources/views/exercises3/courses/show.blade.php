@extends('layouts.master')

@section('title', 'Course Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Course Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="course_code" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="course_code" name="course_code" value="{{ $course->course_code }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="course_name" name="course_name" value="{{ $course->course_name }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="credit_hours" class="form-label">Credit Hours</label>
                    <input type="number" class="form-control" id="credit_hours" name="credit_hours" value="{{ $course->credit_hours }}" disabled>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Courses List
                </a>
                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Course
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
