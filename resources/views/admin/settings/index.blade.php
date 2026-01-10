<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings | CampusHub Admin</title>

    <!-- Font Awesome & Google Fonts -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">

    <style>
        :root {
            --primary-color: #2d3b8e;
            --primary-dark: #1e2a78;
            --primary-light: #4a5ccc;
            --secondary-color: #1a1d2e;
            --accent-color: #3a86ff;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --info-color: #3498db;
            --danger-color: #e74c3c;
            --light-color: #f8fafc;
            --dark-color: #121212;
            --gray-100: #f5f7fa;
            --gray-200: #e4e7eb;
            --gray-300: #cbd2d9;
            --gray-600: #616e7c;
            --gray-800: #323f4b;
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --transition-speed: 0.3s;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --box-shadow-lg: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            transition: background 0.4s, color 0.4s;
        }

        /* ====================== DARK THEME ====================== */
        body.dark-theme {
            background: #0f0f0f;
            color: #e0e0e0;
        }

        body.dark-theme .navbar,
        body.dark-theme .sidebar,
        body.dark-theme .dashboard-header,
        body.dark-theme .settings-card {
            background: rgba(18, 18, 18, 0.95) !important;
            backdrop-filter: blur(10px);
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        body.dark-theme .sidebar-header {
            background: rgba(18, 18, 18, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        body.dark-theme .form-control {
            background: #1e1e1e;
            border-color: #444;
            color: #e0e0e0;
        }

        body.dark-theme .form-control:disabled {
            background: #252525;
            color: #888;
        }

        body.dark-theme .section-title,
        body.dark-theme .dashboard-header h1,
        body.dark-theme h2,
        body.dark-theme .toggle-info h4,
        body.dark-theme .form-label {
            color: #ffffff;
        }

        body.dark-theme .dashboard-header p,
        body.dark-theme .toggle-info p,
        body.dark-theme .sidebar-header p {
            color: #aaaaaa;
        }

        body.dark-theme .sidebar-nav li a {
            color: #bbbbbb;
        }

        body.dark-theme .sidebar-nav li a:hover,
        body.dark-theme .sidebar-nav li a.active {
            background: rgba(45, 59, 142, 0.2);
            color: var(--primary-light);
        }

        body.dark-theme .user-badge,
        body.dark-theme .btn-logout {
            background: rgba(45, 59, 142, 0.1);
            border-color: rgba(45, 59, 142, 0.2);
        }

        body.dark-theme .btn-logout {
            background: rgba(231, 76, 60, 0.1);
            border-color: rgba(231, 76, 60, 0.2);
        }

        body.dark-theme .section-title {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ====================== ORIGINAL LIGHT STYLES (unchanged) ====================== */
        /* Navbar */
        .navbar {
            width: 100%;
            height: var(--navbar-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1100;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.8);
        }

        #toggle-btn {
            font-size: 20px;
            background-color: rgba(45, 59, 142, 0.1);
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            margin-right: 20px;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #toggle-btn:hover {
            background-color: rgba(45, 59, 142, 0.2);
            transform: rotate(90deg);
        }

        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-title::before {
            content: '';
            width: 8px;
            height: 30px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light));
            border-radius: 4px;
        }

        .user-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            background: rgba(45, 59, 142, 0.05);
            padding: 8px 15px 8px 8px;
            border-radius: 30px;
            transition: all 0.3s;
            font-size: 0.95rem;
            border: 1px solid rgba(45, 59, 142, 0.1);
        }

        .user-badge .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout {
            background: rgba(231, 76, 60, 0.05);
            color: var(--danger-color);
            border: 1px solid rgba(231, 76, 60, 0.1);
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: rgba(231, 76, 60, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.2);
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            transition: transform var(--transition-speed) ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 5px 0 30px rgba(0, 0, 0, 0.05);
            border-right: 1px solid rgba(255, 255, 255, 0.8);
            padding-top: var(--navbar-height);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-header {
            text-align: center;
            padding: 30px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.5);
        }

        .avatar-large {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2.2rem;
            color: white;
            border: 4px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--secondary-color);
        }

        .sidebar-header p {
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar-nav {
            list-style: none;
            padding: 20px 15px;
        }

        .sidebar-nav li {
            margin-bottom: 8px;
        }

        .sidebar-nav li a {
            color: var(--gray-600);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 15px;
            border-radius: var(--border-radius);
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar-nav li a:hover {
            background: rgba(45, 59, 142, 0.05);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar-nav li a.active {
            background: linear-gradient(90deg, rgba(45, 59, 142, 0.1) 0%, rgba(45, 59, 142, 0.05) 100%);
            color: var(--primary-color);
            font-weight: 600;
            border-left: 4px solid var(--primary-color);
        }

        .sidebar-nav li a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            padding: calc(var(--navbar-height) + 30px) 30px 60px;
            margin-left: 0;
            transition: margin-left var(--transition-speed) ease;
            min-height: 100vh;
        }

        .sidebar.open ~ .main-content {
            margin-left: var(--sidebar-width);
        }

        .dashboard-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .dashboard-header h1 {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
            font-size: 2rem;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dashboard-header h1::before {
            content: '';
            width: 6px;
            height: 40px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light));
            border-radius: 3px;
        }

        .dashboard-header p {
            color: var(--gray-600);
            font-size: 1.1rem;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(480px, 1fr));
            gap: 30px;
        }

        .settings-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: all 0.3s;
        }

        .settings-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-lg);
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: var(--primary-color);
            background: rgba(45, 59, 142, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 10px;
            display: block;
            font-size: 0.98rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--gray-300);
            border-radius: 10px;
            font-size: 1rem;
            background: white;
            transition: all 0.3s;
        }

        .form-control:disabled {
            background: var(--gray-100);
            color: var(--gray-700);
            cursor: not-allowed;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 5px rgba(45, 59, 142, 0.12);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border: none;
            padding: 15px 36px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(45, 59, 142, 0.3);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(45, 59, 142, 0.4);
        }

        .toggle-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
        }

        .toggle-info h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 6px;
        }

        .toggle-info p {
            font-size: 0.95rem;
            color: var(--gray-600);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        input:checked + .slider {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: calc(var(--navbar-height) + 20px) 20px 40px;
            }

            .dashboard-header h1 {
                font-size: 1.7rem;
            }

            .user-badge span,
            .btn-logout span {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">CampusHub Admin</span>
        <div class="user-actions">
            <div class="user-badge">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="avatar-large"><i class="fas fa-user-shield"></i></div>
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ ucfirst(Auth::user()->role ?? 'Administrator') }}</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-user-cog"></i> User Management</a></li>
            <li><a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> Student Management</a></li>
            <li><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a></li>
            <li><a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a></li>
            <li><a href="{{ route('admin.results.index') }}"><i class="fas fa-poll"></i> Election Results</a></li>
            <li><a href="{{ route('admin.settings') }}" class="active"><i class="fas fa-cog"></i> System Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-cogs"></i> System Settings</h1>
            <p>Manage your account, security settings, and system preferences.</p>
        </div>

        <div class="settings-grid">
            <!-- Account Information -->
            <div class="settings-card">
                <div class="section-title">
                    <i class="fas fa-user-circle"></i> Account Information
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role ?? 'Administrator') }}" disabled>
                </div>
            </div>

            <!-- Security & Preferences -->
            <div class="settings-card">
                <div class="section-title">
                    <i class="fas fa-shield-alt"></i> Security & Preferences
                </div>

                <div class="form-group">
                    <a href="{{ route('admin.settings.password') }}" class="btn-primary">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </div>

                <div class="toggle-group">
                    <div class="toggle-info">
                        <h4>Dark Theme</h4>
                        <p>Enable dark mode across the admin panel</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" id="darkThemeToggle">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('open') && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Dark Theme Toggle
        const darkThemeToggle = document.getElementById('darkThemeToggle');
        const body = document.body;

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-theme');
            darkThemeToggle.checked = true;
        }

        // Toggle handler
        darkThemeToggle.addEventListener('change', () => {
            if (darkThemeToggle.checked) {
                body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>
</html>