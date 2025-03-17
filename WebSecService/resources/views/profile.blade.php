<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>

<h2>Welcome, {{ $user->name }}</h2>
<p>Email: {{ $user->email }}</p>

<!-- فورم تحديث كلمة المرور -->
<h3>Change Password</h3>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('profile.updatePassword') }}" method="POST">
    @csrf
    <label>Current Password:</label>
    <input type="password" name="current_password" required>

    <label>New Password:</label>
    <input type="password" name="new_password" required>

    <label>Confirm New Password:</label>
    <input type="password" name="new_password_confirmation" required>

    <button type="submit">Update Password</button>
</form>

</body>
</html>
