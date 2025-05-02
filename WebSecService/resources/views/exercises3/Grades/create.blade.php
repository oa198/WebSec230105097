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
                <div class="col-md-6 mb-3">
                    <label for="user_id" class="form-label">Student</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                        <option value="">Select Student</option>
                        @foreach($users->filter(function($user) { return $user->hasRole('students'); }) as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                    <div class="col-md-6 mb-3">
                        <label for="course_code" class="form-label">Course</label>
                        <select class="form-select @error('course_code') is-invalid @enderror" id="course_code" name="course_code" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->code }}" data-credit-hours="{{ $course->credit_hours }}">
                                {{ $course->code }} - {{ $course->name }} ({{ $course->credit_hours }} hrs)
                            </option>
                            @endforeach
                        </select>
                        @error('course_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="credit_hours" class="form-label">Credit Hours</label>
                        <input type="number" class="form-control" id="credit_hours" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select class="form-select @error('grade') is-invalid @enderror" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            @foreach(array_keys(App\Models\Grade::$gradePoints) as $gradeOption)
                            <option value="{{ $gradeOption }}">{{ $gradeOption }}</option>
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
                            <option value="{{ $termOption }}">{{ $termOption }}</option>
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

<script>
document.getElementById('course_code').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById('credit_hours').value = selectedOption.dataset.creditHours || '';
});
</script>
@endsection
