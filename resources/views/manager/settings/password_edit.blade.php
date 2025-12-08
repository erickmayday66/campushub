<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | CampusHub</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Light theme variables (matching manager dashboard) */
            --background: #f5f7fb;
            --card-bg: #ffffff;
            --text-color: #343a40;
            --table-border: #e9ecef;
            --success-bg: #d4edda;
            --success-text: #155724;
            --error-bg: #f8d7da;
            --error-text: #721c24;
            --transition-speed: 0.3s;
            --border-radius: 10px;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            --primary-color: #4361ee;
            --success-color: #28a745;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
        }

        [data-theme="dark"] {
            /* Dark theme variables */
            --background: #1a1d29;
            --card-bg: #242731;
            --text-color: #e0e0e0;
            --table-border: #373b47;
            --success-bg: #2d7a62;
            --success-text: #e0e0e0;
            --error-bg: #8b2d3a;
            --error-text: #f5c6cb;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            --gray-100: #2c303a;
            --gray-200: #373b47;
            --gray-300: #4a4f5c;
            --gray-600: #adb5bd;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-color);
            margin: 0;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        /* Main content */
        .main-content {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            transition: color var(--transition-speed);
        }

        .header h1 i {
            color: var(--primary-color);
            margin-right: 8px;
        }

        .header p {
            font-size: 1.1rem;
            color: var(--gray-600);
            margin: 0;
            transition: color var(--transition-speed);
        }

        /* Change password card */
        .change-password-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid var(--table-border);
            transition: background-color var(--transition-speed), border-color var(--transition-speed);
            padding: 30px;
        }

        .change-password-card h2 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            transition: color var(--transition-speed);
        }

        /* Alerts */
        .alert-card {
            padding: 12px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid var(--success-text);
        }

        .alert-error {
            background: var(--error-bg);
            color: var(--error-text);
            border: 1px solid var(--error-text);
        }

        .alert-card i {
            font-size: 1.1rem;
        }

        .alert-card ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .alert-card li {
            margin-bottom: 0.5rem;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: block;
            transition: color var(--transition-speed);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            color: var(--gray-600);
            font-size: 1rem;
            transition: color var(--transition-speed);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px 10px 40px;
            font-size: 0.95rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            background: var(--card-bg);
            color: var(--text-color);
            transition: border-color var(--transition-speed), background-color var(--transition-speed), color var(--transition-speed), box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .form-control:hover {
            border-color: var(--primary-color);
        }

        .form-help {
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-top: 0.5rem;
            transition: color var(--transition-speed);
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #3b55d1;
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
            color: var(--primary-color);
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        /* Theme toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .theme-toggle label {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .theme-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .theme-toggle .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-300);
            transition: .4s;
            border-radius: 24px;
        }

        .theme-toggle .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .theme-toggle input:checked + .slider {
            background-color: var(--primary-color);
        }

        .theme-toggle input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .main-content {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.6rem;
            }

            .header p {
                font-size: 1rem;
            }

            .change-password-card h2 {
                font-size: 1.2rem;
            }

            .button-group {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .theme-toggle {
                top: 15px;
                right: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="theme-toggle">
        <label for="themeToggle">
            <input type="checkbox" id="themeToggle" aria-label="Toggle dark mode">
            <span class="slider"></span>
        </label>
    </div>

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

                @if(session('success'))
                    <div class="alert-card alert-success" role="alert" aria-live="assertive">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-card alert-error" role="alert" aria-live="assertive">
                        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('manager.settings.password.update') }}" aria-label="Change password form">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon" aria-hidden="true"></i>
                            <input type="password" name="current_password" id="current_password" class="form-control" required autofocus aria-describedby="current-password-help">
                        </div>
                        <p id="current-password-help" class="form-help">Enter your current password</p>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon" aria-hidden="true"></i>
                            <input type="password" name="password" id="password" class="form-control" required aria-describedby="password-help">
                        </div>
                        <p id="password-help" class="form-help">Use at least 8 characters, including letters, numbers, and symbols</p>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon" aria-hidden="true"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('manager.settings.edit') }}" class="btn btn-secondary" aria-label="Back to settings">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Settings
                        </a>
                        <button type="submit" class="btn btn-primary" aria-label="Update password">
                            <i class="fas fa-check" aria-hidden="true"></i> Update Password
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.documentElement; // Use documentElement to set data-theme

        const savedTheme = localStorage.getItem('theme');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            body.setAttribute('data-theme', 'dark');
            themeToggle.checked = true;
        }

        themeToggle.addEventListener('change', function() {
            const newTheme = this.checked ? 'dark' : 'light';
            body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>