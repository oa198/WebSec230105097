@extends('layouts.app')

@section('content')
<div class="container">
    <h2>GPA Simulator</h2>
    <form method="POST" action="/gpa-simulator">
        @csrf
        <div id="courses-container">
            <div class="course-row mb-3">
                <label>Course Name</label>
                <input type="text" name="courses[0][name]" class="form-control" required>

                <label>Credit Hours</label>
                <input type="number" name="courses[0][credits]" class="form-control" required>

                <label>GPA</label>
                <input type="number" step="0.1" name="courses[0][gpa]" class="form-control" required>
            </div>
        </div>

        <button type="button" id="add-course" class="btn btn-secondary">Add Course</button>
        <button type="submit" class="btn btn-primary">Calculate GPA</button>
    </form>

    @if(isset($finalGPA))
        <h3 class="mt-3">Final GPA: {{ $finalGPA }}</h3>
    @endif
</div>

<script>
    let courseCount = 1;
    document.getElementById('add-course').addEventListener('click', function() {
        let container = document.getElementById('courses-container');
        let newCourse = document.createElement('div');
        newCourse.classList.add('course-row', 'mb-3');
        newCourse.innerHTML = `
            <label>Course Name</label>
            <input type="text" name="courses[${courseCount}][name]" class="form-control" required>

            <label>Credit Hours</label>
            <input type="number" name="courses[${courseCount}][credits]" class="form-control" required>

            <label>GPA</label>
            <input type="number" step="0.1" name="courses[${courseCount}][gpa]" class="form-control" required>
        `;
        container.appendChild(newCourse);
        courseCount++;
    });
</script>
@endsection
