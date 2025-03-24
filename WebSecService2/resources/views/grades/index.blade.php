@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Grade List</h2>
    <a href="{{ route('grades.create') }}" class="btn btn-primary">Add Grade</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($gradesByTerm as $term => $data)
        <h3>Term: {{ $term }}</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Grade</th>
                    <th>Credit Hours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['grades'] as $grade)
                    <tr>
                        <td>{{ $grade->student_name }}</td>
                        <td>{{ $grade->subject }}</td>
                        <td>{{ $grade->score }}</td>
                        <td>{{ $grade->grade }}</td>
                        <td>{{ $grade->credit_hours }}</td>
                        <td>
                            <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4"><strong>Total Credit Hours:</strong></td>
                    <td><strong>{{ $data['totalCreditHours'] }}</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>GPA:</strong></td>
                    <td><strong>{{ $data['gpa'] }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <h3>Overall Cumulative GPA (CGPA): {{ number_format($cgpa, 2) }}</h3>
    <h3>Total Cumulative Credit Hours (CCH): {{ $cch }}</h3>
</div>
@endsection
