<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Transcript</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Student Transcript</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5><strong>Student Name:</strong> {{ $student['name'] }}</h5>
                <h5><strong>Student ID:</strong> {{ $student['id'] }}</h5>
                <h5><strong>Department:</strong> {{ $student['department'] }}</h5>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <caption class="text-start text-muted">Academic Performance</caption>
                <thead class="table-dark">
                    <tr>
                        <th>Course</th>
                        <th>Credit Hours</th>
                        <th>GPA</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($student['courses'] as $course)
                    <tr>
                        <td>{{ $course['name'] }}</td>
                        <td>{{ $course['credit_hours'] }}</td>
                        <td>{{ number_format($course['gpa'], 2) }}</td>
                        <td>{{ $course['grade'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No courses available</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-warning fw-bold">
                        <td colspan="3">Total GPA</td>
                        <td>{{ number_format($finalGPA, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
