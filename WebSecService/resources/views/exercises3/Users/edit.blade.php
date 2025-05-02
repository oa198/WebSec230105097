@extends('layouts.master')

@section('title', 'Edit User: user -> name')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit User: {{$user -> name}}
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('exercises3.Users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Options</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="password_option"
                                       id="keep_password" value="keep">
                                <label class="form-check-label" for="keep_password">
                                    Keep current password
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="password_option"
                                       id="change_password" value="change" checked>
                                <label class="form-check-label" for="change_password">
                                    Set new password
                                </label>
                            </div>
                        </div>

                        <div id="password_fields" class="mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control"
                                           id="password" name="password" >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control"
                                           id="password_confirmation" name="password_confirmation" >
                                </div>
                            </div>
                            <div class="alert alert-info py-2">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Password must be at least 8 characters long
                                </small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end border-top pt-3 gap-2">
                            <a href="{{ route('exercises3.Users.profile', $user->id) }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordOption = document.querySelectorAll('input[name="password_option"]');
    const passwordFields = document.getElementById('password_fields');

    // Initially show password fields since "Set new password" is checked
    passwordFields.classList.remove('d-none');

    passwordOption.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'change') {
                passwordFields.classList.remove('d-none');
                document.getElementById('password').setAttribute('required', '');
                document.getElementById('password_confirmation').setAttribute('required', '');
            } else {
                passwordFields.classList.add('d-none');
                document.getElementById('password').removeAttribute('required');
                document.getElementById('password_confirmation').removeAttribute('required');
            }
        });
    });
});
</script>
@endsection
@endsection
