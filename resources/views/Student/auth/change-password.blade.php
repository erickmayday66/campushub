<!-- resources/views/student/auth/change-password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
    <h2>Change Your Password</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.password.update') }}" method="POST">
        @csrf
        <label>New Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Update Password</button>
    </form>
</body>
</html>
