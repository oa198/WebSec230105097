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
                        <label class="form-label">Student</label>
                        <input type="text" class="form-control" value="{{ $grade->user->name }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Course</label>
                        <input type="text" class="form-control"
                               value="{{ $grade->course_code }} - {{ $grade->course->name }}" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Credit Hours</label>
                        <input type="number" class="form-control"
                               value="{{ $grade->course->credit_hours }}" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select class="form-select @error('grade') is-invalid @enderror" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            @foreach(array_keys(App\Models\Grade::$gradePoints) as $gradeOption)
                            <option value="{{ $gradeOption }}" {{ old('grade', $grade->grade) == $gradeOption ? 'selected' : '' }}>
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
                            <option value="{{ $termOption }}" {{ old('term', $grade->term) == $termOption ? 'selected' : '' }}>
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
                               id="year" name="year" value="{{ old('year', $grade->year) }}"
                               min="2000" max="2099" required>
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Grade
                    </button>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
