@extends('layouts.master')

@section('title', 'Courses')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Courses</h2>
        <a href="{{ route('exercises3.courses.create') }}" class="btn btn-primary">Add Course</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credit Hours</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->code }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->credit_hours }}</td>
                <td>{{ $course->description }}</td>
                <td>
                    <a href="{{ route('exercises3.courses.show', $course->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('exercises3.courses.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('exercises3.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
