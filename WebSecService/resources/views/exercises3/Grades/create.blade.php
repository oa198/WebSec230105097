@extends('layouts.master')

@section('title', 'Add New Grade')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Grade</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('exercises3.Grades.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="2">
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

                    <div class="col-md-4 mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select class="form-select @error('grade') is-invalid @enderror" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            @foreach(array_keys(App\Models\Grade::$gradePoints) as $gradeOption)
                            <option value="{{ $gradeOption }}" {{ old('grade') == $gradeOption ? 'selected' : '' }}>
                                {{ $gradeOption }}
                            </option>
                            @endforeach
                        </select>
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="term" class="form-label">Term</label>
                        <select class="form-select @error('term') is-invalid @enderror" id="term" name="term" required>
                            <option value="">Select</option>
                            @foreach([1, 2, 3] as $termOption)
                            <option value="{{ $termOption }}" {{ old('term') == $termOption ? 'selected' : '' }}>
                                {{ $termOption }}
                            </option>
                            @endforeach
                        </select>
                        @error('term')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control @error('year') is-invalid @enderror"
                               id="year" name="year" value="{{ old('year', date('Y')) }}"
                               min="2000" max="2099" required>
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Grade
                    </button>
                    <a href="{{ route('exercises3.Grades.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
