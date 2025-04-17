@extends('layouts.master')

@section('title', 'Edit Grade')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Grade</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('exercises3.Grades.update', $grade->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="course_code" class="form-label">Course Code</label>
                        <input type="text" class="form-control" id="course_code" name="course_code"
                               value="{{ old('course_code', $grade->course_code) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="course_name" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="course_name" name="course_name"
                               value="{{ old('course_name', $grade->course_name) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="credit_hours" class="form-label">Credit Hours</label>
                        <input type="number" class="form-control" id="credit_hours" name="credit_hours"
                               value="{{ old('credit_hours', $grade->credit_hours) }}" min="1" max="5" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select class="form-select" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            @foreach(array_keys(App\Models\Grade::$gradePoints) as $gradeOption)
                            <option value="{{ $gradeOption }}"
                                {{ old('grade', $grade->grade) == $gradeOption ? 'selected' : '' }}>
                                {{ $gradeOption }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="term" class="form-label">Term</label>
                        <select class="form-select" id="term" name="term" required>
                            <option value="">Term</option>
                            @foreach([1, 2, 3] as $termOption)
                            <option value="{{ $termOption }}"
                                {{ old('term', $grade->term) == $termOption ? 'selected' : '' }}>
                                {{ $termOption }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" name="year"
                               value="{{ old('year', $grade->year) }}" min="2000" max="2099" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Grade</button>
                    <a href="{{ route('exercises3.Grades.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
