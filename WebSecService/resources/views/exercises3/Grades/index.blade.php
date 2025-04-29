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
                <div class="card-header">Term {{ $term }}</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Credit Hours</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($termGrades as $grade)
                                <tr>
                                    <td>{{ $grade->course_code }}</td>
                                    <td>{{ $grade->course_name }}</td>
                                    <td>{{ $grade->credit_hours }}</td>
                                    <td>{{ $grade->grade }}</td>
                                    <td>
                                        <a href="{{ route('exercises3.Grades.edit', $grade->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('exercises3.Grades.destroy', $grade->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
