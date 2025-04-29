@extends('layouts.master')

@section('title', 'User Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">User Details</h4>
                        <a href="{{ route('exercises3.Users.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                     class="img-thumbnail rounded-circle"
                                     alt="Profile Picture"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded-circle"
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x text-secondary"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>Name</h6>
                                    <p class="text-muted">{{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>Phone</h6>
                                    <p class="text-muted">{{ $user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>Role</h6>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'editor' ? 'warning' : 'primary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>Status</h6>
                                    <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <h5 class="mb-3">Additional Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6>Date of Birth</h6>
                                <p class="text-muted">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6>Gender</h6>
                                <p class="text-muted">{{ $user->gender ? ucfirst($user->gender) : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6>Address</h6>
                            <p class="text-muted">{{ $user->address ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <h5 class="mb-3">Academic Grades</h5>

                        @if($user->grades->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Course Code</th>
                                            <th>Course Name</th>
                                            <th>Credit Hours</th>
                                            <th>Grade</th>
                                            <th>Term</th>
                                            <th>Year</th>
                                            <th>Grade Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalCreditHours = 0;
                                            $totalQualityPoints = 0;
                                        @endphp

                                        @foreach($user->grades as $grade)
                                            <tr>
                                                <td>{{ $grade->course_code }}</td>
                                                <td>{{ $grade->course_name }}</td>
                                                <td>{{ $grade->credit_hours }}</td>
                                                <td>{{ $grade->grade }}</td>
                                                <td>Term {{ $grade->term }}</td>
                                                <td>{{ $grade->year }}</td>
                                                <td>{{ number_format($grade->quality_points, 2) }}</td>
                                            </tr>
                                            @php
                                                $totalCreditHours += $grade->credit_hours;
                                                $totalQualityPoints += $grade->quality_points;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2">Totals</th>
                                            <th>{{ $totalCreditHours }}</th>
                                            <th colspan="3">GPA</th>
                                            <th>
                                                @if($totalCreditHours > 0)
                                                    {{ number_format($totalQualityPoints / $totalCreditHours, 2) }}
                                                @else
                                                    0.00
                                                @endif
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                No grades recorded for this user.
                            </div>
                        @endif
                    </div>@extends('layouts.master')

@section('title', 'User Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">User Details</h4>
                        <a href="{{ route('exercises3.Users.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                     class="img-thumbnail rounded-circle"
                                     alt="Profile Picture"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                <div class="d-flex align-items-center justify-content-center bg-light rounded-circle"
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x text-secondary"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>Name</h6>
                                    <p class="text-muted">{{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>Phone</h6>
                                    <p class="text-muted">{{ $user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6>Role</h6>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'editor' ? 'warning' : 'primary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6>Status</h6>
                                    <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <h5 class="mb-3">Additional Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6>Date of Birth</h6>
                                <p class="text-muted">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6>Gender</h6>
                                <p class="text-muted">{{ $user->gender ? ucfirst($user->gender) : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6>Address</h6>
                            <p class="text-muted">{{ $user->address ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <h5 class="mb-3">Courses and Grades</h5>

                        @if($user->courses->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Course Code</th>
                                            <th>Course Name</th>
                                            <th>Credit Hours</th>
                                            <th>Grade</th>
                                            <th>Term</th>
                                            <th>Year</th>
                                            <th>Grade Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalCreditHours = 0;
                                            $totalQualityPoints = 0;
                                        @endphp

                                        @foreach($user->courses as $course)
                                            <tr>
                                                <td>{{ $course->course_code }}</td>
                                                <td>{{ $course->course_name }}</td>
                                                <td>{{ $course->credit_hours }}</td>
                                                <td>{{ $course->pivot->grade ?? 'N/A' }}</td>
                                                <td>Term {{ $course->pivot->term }}</td>
                                                <td>{{ $course->pivot->year }}</td>
                                                <td>{{ number_format($course->pivot->quality_points, 2) }}</td>
                                            </tr>
                                            @php
                                                $totalCreditHours += $course->credit_hours;
                                                $totalQualityPoints += $course->pivot->quality_points;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2">Totals</th>
                                            <th>{{ $totalCreditHours }}</th>
                                            <th colspan="3">GPA</th>
                                            <th>
                                                @if($totalCreditHours > 0)
                                                    {{ number_format($totalQualityPoints / $totalCreditHours, 2) }}
                                                @else
                                                    0.00
                                                @endif
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                No courses or grades recorded for this user.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('exercises3.Users.edit', $user->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <form action="{{ route('exercises3.Users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('exercises3.Users.edit', $user->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <form action="{{ route('exercises3.Users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
