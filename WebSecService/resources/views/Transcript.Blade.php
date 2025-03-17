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

        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Course</th>
                    <th>Credit Hours</th>
                    <th>GPA</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student['courses'] as $course)
                <tr>
                    <td>{{ $course['name'] }}</td>
                    <td>{{ $course['credit_hours'] }}</td>
                    <td>{{ $course['gpa'] }}</td>
                    <td>{{ $course['grade'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="alert alert-warning text-center mt-3">
            <h4><strong>Total GPA:</strong> {{ $finalGPA }}</h4>
        </div>
    </div>
</body>
</html>
