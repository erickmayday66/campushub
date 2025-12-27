<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | CampusHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/student/change-password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
    <main class="main-content">
        <div class="container">
            <header class="header">
                <h1>
                    <i class="fas fa-lock" aria-hidden="true"></i> Change Password
                </h1>
                <p>Update your password to keep your account secure</p>
            </header>

            <section class="change-password-card" aria-labelledby="change-password-heading">
                <h2 id="change-password-heading">Update Your Password</h2>

                @if ($errors->any())
                    <div class="alert-card alert-error" role="alert" aria-live="assertive">
                        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('student.change-password.update') }}" aria-label="Change password form">
                    @csrf
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon" aria-hidden="true"></i>
                            <input type="password" name="new_password" id="new_password" required aria-describedby="new-password-help">
                        </div>
                        <p id="new-password-help" class="form-help">Use at least 8 characters, including letters, numbers, and symbols</p>
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon" aria-hidden="true"></i>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" aria-label="Update password">
                        <i class="fas fa-check" aria-hidden="true"></i> Update Password
                    </button>
                </form>
            </section>
        </div>
    </main>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        const savedTheme = localStorage.getItem('theme');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            body.classList.add('dark-theme');
            themeToggle.checked = true;
        }

        themeToggle.addEventListener('change', function() {
            body.classList.toggle('dark-theme', this.checked);
            localStorage.setItem('theme', this.checked ? 'dark' : 'light');
        });
    </script>
</body>
</html>