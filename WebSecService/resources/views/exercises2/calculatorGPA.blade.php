@extends('layouts.master')

@section('title', 'GPA Calculator')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>GPA Calculator</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Available Courses</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Credits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                            <tr>
                                <td>{{ $course['code'] }}</td>
                                <td>{{ $course['title'] }}</td>
                                <td>{{ $course['credits'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5>Your Courses</h5>
                    <div id="course-container">
                        <div class="course-row mb-3 row">
                            <div class="col-md-5">
                                <select class="form-control course-select">
                                    @foreach($courses as $course)
                                    <option value="{{ $course['credits'] }}">{{ $course['code'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control grade" placeholder="Grade" min="0" max="4" step="0.1">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control credits" value="{{ $courses[0]['credits'] }}" readonly>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-sm btn-danger remove-btn" disabled>&times;</button>
                            </div>
                        </div>
                    </div>

                    <button id="add-course" class="btn btn-secondary btn-sm mb-3">+ Add Course</button>
                    <button id="calculate" class="btn btn-primary">Calculate GPA</button>

                    <div class="mt-4 p-3 bg-light">
                        <h5>Results</h5>
                        <p>Total Credits: <span id="total-credits">0</span></p>
                        <p>GPA: <span id="gpa">0.00</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new course row
    document.getElementById('add-course').addEventListener('click', function() {
        const container = document.getElementById('course-container');
        const firstRow = container.querySelector('.course-row');
        const newRow = firstRow.cloneNode(true);

        // Enable remove button for new row
        newRow.querySelector('.remove-btn').disabled = false;

        // Reset values
        newRow.querySelector('.grade').value = '';

        container.appendChild(newRow);
    });

    // Remove course row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-btn')) {
            const rows = document.querySelectorAll('.course-row');
            if (rows.length > 1) {
                e.target.closest('.course-row').remove();
            }
        }
    });

    // Update credits when course changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('course-select')) {
            const credits = e.target.value;
            e.target.closest('.row').querySelector('.credits').value = credits;
        }
    });

    // Calculate GPA
    document.getElementById('calculate').addEventListener('click', function() {
        let totalCredits = 0;
        let totalPoints = 0;
        let valid = true;

        document.querySelectorAll('.course-row').forEach(row => {
            const grade = parseFloat(row.querySelector('.grade').value);
            const credits = parseFloat(row.querySelector('.credits').value);

            if (isNaN(grade) || grade < 0 || grade > 4) {
                alert('Please enter valid grades (0-4) for all courses');
                valid = false;
                return;
            }

            totalCredits += credits;
            totalPoints += grade * credits;
        });

        if (valid) {
            const gpa = totalPoints / totalCredits;
            document.getElementById('total-credits').textContent = totalCredits;
            document.getElementById('gpa').textContent = gpa.toFixed(2);
        }
    });
});
</script>
@endsection
