@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Transcript</h2>
    <p><strong>Name:</strong> {{ $student['name'] }}</p>
    <p><strong>ID:</strong> {{ $student['id'] }}</p>
    <p><strong>Department:</strong> {{ $student['department'] }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course</th>
                <th>Credit Hours</th>
                <th>GPA</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student['courses'] as $course)
            <tr>
                <td>{{ $course['name'] }}</td>
                <td>{{ $course['credit_hours'] }}</td>
                <td>{{ $course['gpa'] }}</td>
                <td>{{ $course['grade'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Final GPA:</strong> {{ $finalGPA }}</p>
</div>
@endsection
