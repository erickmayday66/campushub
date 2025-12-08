<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Manager Settings | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manager/style.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Light theme variables (matching dashboard) */
            --background: #f5f7fb;
            --card-bg: #ffffff;
            --text-color: #343a40;
            --table-border: #e9ecef;
            --success-bg: #d4edda;
            --success-text: #155724;
            --transition-speed: 0.3s;
            --border-radius: 10px;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            --primary-color: #4361ee;
            --warning-color: #f8961e;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --sidebar-width: 260px;
            --navbar-height: 70px;
        }

        [data-theme="dark"] {
            /* Dark theme variables */
            --background: #1a1d29;
            --card-bg: #242731;
            --text-color: #e0e0e0;
            --table-border: #373b47;
            --success-bg: #2d7a62;
            --success-text: #e0e0e0;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            --gray-100: #2c303a;
            --gray-200: #373b47;
            --gray-300: #4a4f5c;
            --gray-600: #adb5bd;
        }

        body {
            background-color: var(--background);
            color: var(--text-color);
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        /* Main content container */
        .container {
            padding: calc(var(--navbar-height) + 30px) 30px 30px 30px;
            width: 100%;
            min-height: 100vh;
            transition: padding-left var(--transition-speed) ease;
            max-width: 900px;
            margin: 0 auto;
        }

        .sidebar.open ~ .container {
            padding-left: calc(var(--sidebar-width) + 30px);
        }

        /* Header */
        .header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            transition: color var(--transition-speed);
        }

        .header p {
            font-size: 1.1rem;
            color: var(--gray-600);
            margin: 0;
            transition: color var(--transition-speed);
        }

        /* Card */
        .card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid var(--table-border);
            transition: background-color var(--transition-speed), border-color var(--transition-speed);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--gray-100);
            padding: 12px 20px;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-color);
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        .card-header i {
            color: var(--primary-color);
        }

        .card-body {
            padding: 20px;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--table-border);
            transition: border-color var(--transition-speed);
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
            transition: color var(--transition-speed);
        }

        .setting-desc {
            font-size: 0.9rem;
            color: var(--gray-600);
            transition: color var(--transition-speed);
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
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

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Buttons */
        .btn {
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            color: white;
            border: none;
            background: var(--primary-color);
        }

        .btn:hover {
            background: #3b55d1;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .container {
                padding: calc(var(--navbar-height) + 20px) 20px 20px 20px;
            }

            .sidebar.open ~ .container {
                padding-left: calc(var(--sidebar-width) + 20px);
            }
        }

        @media (max-width: 576px) {
            .header h1 {
                font-size: 1.6rem;
            }

            .header p {
                font-size: 1rem;
            }

            .card-header {
                font-size: 1.1rem;
            }

            .setting-title {
                font-size: 0.9rem;
            }

            .setting-desc {
                font-size: 0.8rem;
            }

            .setting-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .toggle-switch {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">CampusHub Manager</span>
        
        <!-- User Profile with Logout -->
        <div class="user-actions">
            <div class="user-badge">
                <i class="fas fa-user-circle"></i>
                <span>{{ auth()->user()->name ?? 'Manager' }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn btn-logout" aria-label="Logout">
                    <i class="fas fa-sign-out-alt"></i> <span class="logout-text">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h2>{{ auth()->user()->name }}</h2>
            <p>Election Manager</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('manager.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('manager.elections.index') }}"><i class="fas fa-vote-yea"></i> Elections</a></li>
            <li><a href="{{ route('manager.candidates.index') }}"><i class="fas fa-users"></i> Candidates</a></li>
            <li><a href="{{ route('manager.faculties.index') }}"><i class="fas fa-university"></i> Faculties</a></li>
            <li><a href="{{ route('manager.courses.index') }}"><i class="fas fa-book"></i> Courses</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="{{ route('manager.settings.edit') }}" class="active"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="#"><i class="fas fa-question-circle"></i> Support</a></li>
            <li class="logout-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn text-white" aria-label="Logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="header">
            <h1>Manager Settings</h1>
            <p>Manage your preferences and security settings</p>
        </div>

        <!-- Appearance Section -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-palette"></i>
                Appearance
            </div>
            <div class="card-body">
                <div class="setting-item">
                    <div>
                        <div class="setting-title">Dark Mode</div>
                        <div class="setting-desc">Switch to dark theme for better visibility in low-light conditions</div>
                    </div>
                    <label class="toggle-switch" for="themeToggle">
                        <input type="checkbox" id="themeToggle" aria-label="Toggle dark mode">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Security Section -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lock"></i>
                Security
            </div>
            <div class="card-body">
                <div class="setting-item">
                    <div>
                        <div class="setting-title">Password</div>
                        <div class="setting-desc">Update your account password for enhanced security</div>
                    </div>
                    <a href="{{ route('manager.settings.password.edit') }}" class="btn" aria-label="Go to change password form">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bell"></i>
                Notifications
            </div>
            <div class="card-body">
                <div class="setting-item">
                    <div>
                        <div class="setting-title">Email Notifications</div>
                        <div class="setting-desc">Receive important updates via email</div>
                    </div>
                    <label class="toggle-switch" for="emailToggle">
                        <input type="checkbox" id="emailToggle" checked aria-label="Toggle email notifications">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="setting-item">
                    <div>
                        <div class="setting-title">Push Notifications</div>
                        <div class="setting-desc">Get real-time alerts on your device</div>
                    </div>
                    <label class="toggle-switch" for="pushToggle">
                        <input type="checkbox" id="pushToggle" checked aria-label="Toggle push notifications">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const container = document.querySelector('.container');
        const navbar = document.querySelector('.navbar');
        const themeToggle = document.getElementById('themeToggle');
        const emailToggle = document.getElementById('emailToggle');
        const pushToggle = document.getElementById('pushToggle');

        // Toggle sidebar visibility
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            // Update container padding based on sidebar state
            if (sidebar.classList.contains('open')) {
                container.style.paddingLeft = `calc(var(--sidebar-width) + 30px)`;
            } else {
                container.style.paddingLeft = '30px';
            }
        });

        // Make navbar sticky on scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 0) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
        });

        // Add active state to menu items
        document.querySelectorAll('.sidebar-nav li a').forEach(link => {
            link.addEventListener('click', function(e) {
                document.querySelectorAll('.sidebar-nav li a').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Theme toggle functionality
        themeToggle.addEventListener('change', () => {
            const newTheme = themeToggle.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });

        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
            themeToggle.checked = (savedTheme === 'dark');
        }

        // Notification toggles (placeholder, as they are not functional yet)
        emailToggle.addEventListener('change', () => {
            // Add logic for email notifications if needed
        });

        pushToggle.addEventListener('change', () => {
            // Add logic for push notifications if needed
        });
    </script>
</body>
</html>