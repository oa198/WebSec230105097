@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Grades List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                    <tr>
                        <td>{{ $grade ['id'] }}</td>
                        <td>{{ $grade ['student_name'] }}</td>
                        <td>{{ $grade ['grade'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
