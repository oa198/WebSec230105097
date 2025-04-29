@extends('layouts.master')

@section('title', 'Add New Course')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Course</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="course_code" class="form-label">Course Code</label>
                        <input type="text" class="form-control @error('course_code') is-invalid @enderror"
                               id="course_code" name="course_code" value="{{ old('course_code') }}" required>
                        @error('course_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="course_name" class="form-label">Course Name</label>
                        <input type="text" class="form-control @error('course_name') is-invalid @enderror"
                               id="course_name" name="course_name" value="{{ old('course_name') }}" required>
                        @error('course_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="credit_hours" class="form-label">Credit Hours</label>
                        <input type="number" class="form-control @error('credit_hours') is-invalid @enderror"
                               id="credit_hours" name="credit_hours" value="{{ old('credit_hours') }}"
                               min="1" max="5" required>
                        @error('credit_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Course
                    </button>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
