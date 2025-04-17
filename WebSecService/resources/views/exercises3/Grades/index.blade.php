@extends('layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Grades</h2>
        <a href="{{ route('exercises3.Grades.create') }}" class="btn btn-primary">Add Grade</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach($grades as $year => $terms)
        <h3 class="mt-4">{{ $year }}</h3>

        @foreach($terms as $term => $termGrades)
            <div class="card mb-4">
                <div class="card-header">
                    Term {{ $term }}
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Code</th>
                                <th>CH</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($termGrades as $grade)
                                <tr>
                                    <td>{{ $grade->course_name }}</td>
                                    <td>{{ $grade->course_code }}</td>
                                    <td>{{ $grade->credit_hours }}</td>
                                    <td>{{ $grade->grade }}</td>
                                    <td>
                                        <a href="{{ route('exercises3.Grades.edit', $grade->id) }}"
                                           class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('exercises3.Grades.destroy', $grade->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
@endsection
