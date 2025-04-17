@extends('layouts.app')

@section('title', 'Grade Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Grade Details</h5>
            <div>
                <a href="{{ route('exercises3.Grades.edit', $grade->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('exercises3.Grades.destroy', $grade->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this grade?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Course Code:</th>
                            <td>{{ $grade->course_code }}</td>
                        </tr>
                        <tr>
                            <th>Course Name:</th>
                            <td>{{ $grade->course_name }}</td>
                        </tr>
                        <tr>
                            <th>Credit Hours:</th>
                            <td>{{ $grade->credit_hours }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Grade:</th>
                            <td>{{ $grade->grade }}</td>
                        </tr>
                        <tr>
                            <th>Term:</th>
                            <td>Term {{ $grade->term }}</td>
                        </tr>
                        <tr>
                            <th>Year:</th>
                            <td>{{ $grade->year }}</td>
                        </tr>
                        <tr>
                            <th>Grade Points:</th>
                            <td>{{ number_format($grade->grade_point, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Quality Points:</th>
                            <td>{{ number_format($grade->quality_points, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('exercises3.Grades.index') }}" class="btn btn-secondary">Back to All Grades</a>
            </div>
        </div>
    </div>
</div>
@endsection
