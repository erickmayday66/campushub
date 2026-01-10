<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    
    <style>
        :root {
            --primary: #2d3b8e;
            --primary-light: #4a5ccc;
            --success: #2ecc71;
            --danger: #e74c3c;
            --gray-100: #f8fafc;
            --gray-200: #e4e7eb;
            --gray-300: #cbd2d9;
            --gray-600: #616e7c;
            --gray-800: #323f4b;
            --gray-900: #1e293b;
            --radius: 16px;
            --shadow: 0 15px 35px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            color: var(--gray-900);
            min-height: 100vh;
            transition: background 0.4s, color 0.4s;
        }

        /* ====================== DARK THEME ====================== */
        body.dark-theme {
            background: #0a0a0a;
            color: #e0e0e0;
        }

        body.dark-theme .navbar,
        body.dark-theme .sidebar,
        body.dark-theme .header-card,
        body.dark-theme .form-card {
            background: rgba(18, 18, 18, 0.95) !important;
            backdrop-filter: blur(12px);
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        body.dark-theme .sidebar-header {
            background: rgba(18, 18, 18, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        body.dark-theme .form-control,
        body.dark-theme .form-select {
            background: #1e1e1e;
            border-color: #444;
            color: #e0e0e0;
        }

        body.dark-theme .form-control:focus,
        body.dark-theme .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 5px rgba(45, 59, 142, 0.2);
        }

        /* Text readability */
        body.dark-theme h1,
        body.dark-theme .header-card h1,
        body.dark-theme .form-label,
        body.dark-theme strong {
            color: #ffffff !important;
        }

        body.dark-theme .header-card p,
        body.dark-theme .sidebar-header p {
            color: #aaaaaa !important;
        }

        body.dark-theme .sidebar-nav a {
            color: #bbbbbb;
        }

        body.dark-theme .sidebar-nav a:hover,
        body.dark-theme .sidebar-nav a.active {
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

        body.dark-theme .btn-cancel {
            background: rgba(255, 255, 255, 0.05);
            color: #cccccc;
            border-color: #444;
        }

        body.dark-theme .btn-cancel:hover {
            background: rgba(45, 59, 142, 0.2);
            color: var(--primary-light);
            border-color: var(--primary);
        }

        body.dark-theme .alert-danger {
            background: rgba(231, 76, 60, 0.15);
            color: #ff8c8c;
            border-color: rgba(231, 76, 60, 0.3);
        }

        body.dark-theme .alert-danger strong {
            color: #ffffff;
        }

        body.dark-theme .alert-danger ul li {
            color: #ffaaaa;
        }

        /* Original Light Styles (unchanged below) */
        .navbar {
            height: 70px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.8);
        }
        #toggle-btn {
            background: rgba(45,59,142,0.1);
            border: none;
            color: var(--primary);
            width: 40px; height: 40px;
            border-radius: 12px;
            cursor: pointer;
            margin-right: 20px;
            transition: var(--transition);
        }
        #toggle-btn:hover { background: rgba(45,59,142,0.2); transform: rotate(90deg); }

        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-title::before {
            content: '';
            width: 8px;
            height: 30px;
            background: linear-gradient(to bottom, var(--primary), var(--primary-light));
            border-radius: 4px;
        }

        .user-badge {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(45,59,142,0.05);
            padding: 8px 15px 8px 8px;
            border-radius: 30px;
            border: 1px solid rgba(45,59,142,0.1);
        }
        .user-badge .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-logout {
            background: rgba(231,76,60,0.05);
            color: var(--danger);
            border: 1px solid rgba(231,76,60,0.1);
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-logout:hover { background: rgba(231,76,60,0.1); transform: translateY(-2px); }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 5px 0 30px rgba(0,0,0,0.05);
            padding-top: 70px;
            border-right: 1px solid rgba(255,255,255,0.8);
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar-header { text-align: center; padding: 30px 20px; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .avatar-large {
            width: 90px; height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            font-size: 2.2rem;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(255,255,255,0.8);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: var(--gray-600);
            text-decoration: none;
            margin: 4px 16px;
            border-radius: 12px;
            font-weight: 500;
            transition: var(--transition);
        }
        .sidebar-nav a:hover { background: rgba(45,59,142,0.05); color: var(--primary); transform: translateX(5px); }
        .sidebar-nav a.active {
            background: linear-gradient(90deg, rgba(45,59,142,0.1), rgba(45,59,142,0.05));
            color: var(--primary);
            font-weight: 600;
            border-left: 4px solid var(--primary);
        }
        .sidebar-nav i { margin-right: 12px; width: 20px; text-align: center; }

        .main-content {
            margin-left: 0;
            padding: calc(70px + 40px) 40px 60px;
            transition: margin-left 0.3s ease;
        }
        .sidebar.open ~ .main-content { margin-left: 280px; }

        .header-card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: var(--shadow);
            margin-bottom: 32px;
            border: 1px solid rgba(255,255,255,0.8);
        }
        .header-card h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-card h1::before {
            content: '';
            width: 6px;
            height: 40px;
            background: linear-gradient(to bottom, var(--primary), var(--primary-light));
            border-radius: 4px;
        }

        .form-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(16px);
            border-radius: var(--radius);
            padding: 40px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255,255,255,0.8);
            max-width: 620px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 28px;
        }
        .form-label {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 10px;
            display: block;
            font-size: 0.95rem;
        }
        .form-control, .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--gray-300);
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            transition: var(--transition);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 5px rgba(45,59,142,0.12);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(45,59,142,0.3);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(45,59,142,0.4);
        }

        .btn-cancel {
            background: rgba(255,255,255,0.9);
            color: var(--gray-700);
            border: 1.5px solid var(--gray-300);
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
        }
        .btn-cancel:hover {
            background: rgba(45,59,142,0.05);
            color: var(--primary);
            border-color: var(--primary);
        }

        .alert-danger {
            background: rgba(231,76,60,0.1);
            color: var(--danger);
            border: 1px solid rgba(231,76,60,0.2);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <button id="toggle-btn"><i class="fas fa-bars"></i></button>
        <div class="navbar-title">CampusHub Admin</div>
        <div class="user-badge">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span>{{ Auth::user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="avatar-large"><i class="fas fa-user-shield"></i></div>
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ ucfirst(Auth::user()->role ?? 'Administrator') }}</p>
        </div>
        <div class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('admin.users.index') }}"><i class="fas fa-user-cog"></i> User Management</a>
            <a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> Student Management</a>
            <a href="{{ route('admin.courses.index') }}" class="active"><i class="fas fa-book"></i> Course Management</a>
            <a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a>
            <a href="#"><i class="fas fa-cog"></i> System Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="header-card">
            <h1>Add New Course</h1>
            <p>Create a new academic course with its code, duration, and assigned faculty.</p>
        </div>

        <div class="form-card">

            @if($errors->any())
                <div class="alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Course Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g., Computer Science">
                </div>

                <div class="form-group">
                    <label class="form-label">Course Code</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" required placeholder="e.g., CS">
                </div>

                <div class="form-group">
                    <label class="form-label">Duration (Years)</label>
                    <input type="number" name="duration_years" class="form-control" value="{{ old('duration_years') }}" min="1" max="10" required placeholder="e.g., 4">
                </div>

                <div class="form-group">
                    <label class="form-label">Faculty</label>
                    <select name="faculty_id" class="form-select" required>
                        <option value="" disabled {{ old('faculty_id') ? '' : 'selected' }}>Select Faculty</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                {{ $faculty->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: 24px; justify-content: space-between; align-items: center; margin-top: 32px;">
                    <a href="{{ route('admin.courses.index') }}" class="btn-cancel">
                        Back
                    </a>
                    <button type="submit" class="btn-primary">
                        Save Course
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sidebar toggle
        document.getElementById('toggle-btn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('toggle-btn');
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        // === DARK THEME AUTO-DETECTION & PERSISTENCE ===
        const body = document.body;

        if (localStorage.getItem('theme') === 'dark' || 
           (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            body.classList.add('dark-theme');
        }

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                if (e.matches) {
                    body.classList.add('dark-theme');
                } else {
                    body.classList.remove('dark-theme');
                }
            }
        });
    </script>
</body>
</html>