@extends('layouts.master')

@section('title', 'Course Details')

@section('content')
<div class="container">
    <h2>Course Details</h2>
    <div class="mb-3">
        <strong>Course Code:</strong> {{ $course->code }}
    </div>
    <div class="mb-3">
        <strong>Course Name:</strong> {{ $course->name }}
    </div>
    <div class="mb-3">
        <strong>Credit Hours:</strong> {{ $course->credit_hours }}
    </div>
    <div class="mb-3">
        <strong>Description:</strong> {{ $course->description }}
    </div>
    <a href="{{ route('exercises3.courses.index') }}" class="btn btn-secondary">Back to Courses</a>
</div>
@endsection
