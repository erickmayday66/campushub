<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Election Results | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">

    <style>
        :root {
            --primary-color: #2d3b8e;
            --primary-light: #4a5ccc;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --gray-600: #616e7c;
            --gray-800: #323f4b;
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
            transition: background 0.4s, color 0.4s;
        }

        /* ====================== DARK THEME ====================== */
        body.dark-theme {
            background: #0a0a0a;
            color: #e0e0e0;
        }

        body.dark-theme .navbar,
        body.dark-theme .sidebar,
        body.dark-theme .dashboard-header,
        body.dark-theme .card {
            background: rgba(18, 18, 18, 0.95) !important;
            backdrop-filter: blur(10px);
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        body.dark-theme .sidebar-header,
        body.dark-theme .logout-item {
            background: rgba(18, 18, 18, 0.5);
            border-color: rgba(255, 255, 255, 0.05);
        }

        body.dark-theme th {
            background: rgba(45, 59, 142, 0.2) !important;
            color: var(--primary-light);
        }

        body.dark-theme td {
            background: #1e1e1e !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        body.dark-theme tr:hover td {
            background: #252525 !important;
        }

        /* Text & badges */
        body.dark-theme h1,
        body.dark-theme strong,
        body.dark-theme .dashboard-header h1 {
            color: #ffffff !important;
        }

        body.dark-theme p,
        body.dark-theme .sidebar-header p,
        body.dark-theme .alert-success,
        body.dark-theme .alert-danger {
            color: #cccccc !important;
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

        body.dark-theme .btn-logout:hover {
            background: rgba(45, 59, 142, 0.2);
        }

        body.dark-theme .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        }

        body.dark-theme .btn-primary:hover {
            box-shadow: 0 8px 20px rgba(45, 59, 142, 0.5);
        }

        body.dark-theme .alert-success {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
            border-color: rgba(46, 204, 113, 0.3);
        }

        body.dark-theme .alert-danger {
            background: rgba(231, 76, 60, 0.15);
            color: #ff8c8c;
            border-color: rgba(231, 76, 60, 0.3);
        }

        /* Scope badge */
        body.dark-theme span[style*="background: var(--primary-color)"] {
            background: var(--primary-light) !important;
            opacity: 0.9;
        }

        /* Empty state */
        body.dark-theme .no-results {
            color: #888;
        }

        /* Original Light Styles (unchanged below) */
        .navbar {
            width: 100%; height: var(--navbar-height);
            background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);
            position: fixed; top: 0; left: 0; z-index: 1100;
            display: flex; align-items: center; padding: 0 30px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.8);
        }
        #toggle-btn {
            font-size: 20px; background: rgba(45,59,142,0.1); border: none; color: var(--primary-color);
            width: 40px; height: 40px; border-radius: 10px; cursor: pointer; margin-right: 20px;
            display: flex; align-items: center; justify-content: center; transition: all 0.3s;
        }
        #toggle-btn:hover { background: rgba(45,59,142,0.2); transform: rotate(90deg); }

        .navbar-title {
            font-size: 1.5rem; font-weight: 700; color: var(--primary-color);
            display: flex; align-items: center; gap: 10px;
        }
        .navbar-title::before {
            content: ''; width: 8px; height: 30px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light));
            border-radius: 4px;
        }

        .user-actions { margin-left: auto; display: flex; align-items: center; gap: 15px; }
        .notification-badge {
            position: relative; width: 40px; height: 40px; background: white; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; color: var(--gray-600);
        }
        .notification-badge::after {
            content: '{{ $unreadCount ?? "0" }}'; position: absolute; top: -5px; right: -5px;
            background: var(--danger-color); color: white; width: 20px; height: 20px; border-radius: 50%;
            font-size: 0.7rem; font-weight: 600; display: flex; align-items: center; justify-content: center;
        }
        .user-badge {
            display: flex; align-items: center; gap: 12px; background: rgba(45,59,142,0.05);
            padding: 8px 15px 8px 8px; border-radius: 30px; border: 1px solid rgba(45,59,142,0.1);
        }
        .user-badge .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); color: white;
            display: flex; align-items: center; justify-content: center; font-weight: 600;
        }
        .btn-logout {
            background: rgba(231,76,60,0.05); color: var(--danger-color);
            border: 1px solid rgba(231,76,60,0.1); padding: 8px 15px; border-radius: 30px;
            font-weight: 500; display: flex; align-items: center; gap: 8px; cursor: pointer;
        }
        .btn-logout:hover { background: rgba(231,76,60,0.1); transform: translateY(-2px); }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            height: 100vh;
            position: fixed; top: 0; left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 5px 0 30px rgba(0,0,0,0.05);
            border-right: 1px solid rgba(255,255,255,0.8);
            padding-top: var(--navbar-height);
            overflow-y: auto;
        }
        .sidebar.open { transform: translateX(0); }

        .sidebar-header {
            text-align: center; padding: 30px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,0.5);
        }
        .avatar-large {
            width: 90px; height: 90px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white; font-size: 2.2rem; margin: 0 auto 15px;
            display: flex; align-items: center; justify-content: center;
            border: 4px solid rgba(255,255,255,0.8); box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .sidebar-nav {
            list-style: none; padding: 20px 15px;
        }
        .sidebar-nav li a {
            color: var(--gray-600); text-decoration: none;
            display: flex; align-items: center; padding: 14px 15px;
            border-radius: var(--border-radius);
            transition: all 0.2s; font-weight: 500; font-size: 0.95rem;
        }
        .sidebar-nav li a:hover {
            background: rgba(45,59,142,0.05); color: var(--primary-color);
            transform: translateX(5px);
        }
        .sidebar-nav li a.active {
            background: linear-gradient(90deg, rgba(45,59,142,0.1), rgba(45,59,142,0.05));
            color: var(--primary-color); font-weight: 600;
            border-left: 4px solid var(--primary-color);
        }
        .sidebar-nav i { margin-right: 12px; width: 20px; text-align: center; font-size: 1.1rem; }

        .logout-item {
            padding: 15px;
            border-top: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,0.5);
        }
        .logout-item button {
            width: 100%; text-align: left; padding: 12px 15px;
            font-weight: 500; color: var(--gray-600); transition: all 0.3s;
            border-radius: var(--border-radius); display: flex; align-items: center; gap: 10px;
            background: transparent; border: none; cursor: pointer; font-size: 0.95rem;
        }
        .logout-item button:hover {
            background: rgba(231,76,60,0.05); color: var(--danger-color);
        }

        .main-content {
            margin-left: 0; padding: calc(var(--navbar-height) + 30px) 30px 100px;
            transition: margin-left 0.3s ease; min-height: 100vh;
        }
        .sidebar.open ~ .main-content { margin-left: var(--sidebar-width); }

        .dashboard-header {
            background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);
            border-radius: var(--border-radius); padding: 30px;
            box-shadow: var(--box-shadow); margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.8);
        }
        .dashboard-header h1 {
            font-size: 2rem; font-weight: 700; color: var(--secondary-color);
            margin-bottom: 10px; display: flex; align-items: center; gap: 15px;
        }
        .dashboard-header h1::before {
            content: ''; width: 6px; height: 40px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light)); border-radius: 3px;
        }

        .card {
            background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);
            border-radius: var(--border-radius); padding: 28px;
            box-shadow: var(--box-shadow); border: 1px solid rgba(255,255,255,0.8);
            margin-bottom: 30px;
        }

        table { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
        th { background: rgba(45,59,142,0.05); color: var(--primary-color); font-weight: 600; padding: 16px; text-align: left; }
        td { background: white; padding: 20px 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px; }
        tr:hover td { background: #f8f9ff; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white; border: none; padding: 10px 20px; border-radius: 12px;
            font-weight: 600; font-size: 0.9rem; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(45,59,142,0.3); }

        .alert-success {
            background: rgba(46,204,113,0.1); color: var(--success-color);
            border: 1px solid rgba(46,204,113,0.2); border-radius: 12px;
            padding: 16px 20px; margin-bottom: 25px; font-weight: 500;
        }
        .alert-danger {
            background: rgba(231,76,60,0.1); color: var(--danger-color);
            border: 1px solid rgba(231,76,60,0.2); border-radius: 12px;
            padding: 16px 20px; margin-bottom: 25px; font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle menu">
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
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="logout-text">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="avatar-large"><i class="fas fa-user-shield"></i></div>
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->role ?? 'Administrator' }}</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-user-cog"></i> User Management</a></li>
            <li><a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> Student Management</a></li>
            <li><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a></li>
            <li><a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a></li>
            <li><a href="{{ route('admin.results.index') }}" class="active"><i class="fas fa-poll"></i> Election Results</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> System Settings</a></li>
        </ul>
        <div class="logout-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="dashboard-header">
            <h1>All Elections - Vote Results</h1>
            <p>View detailed results for all completed and ongoing elections.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Election Title</th>
                            <th>Scope</th>
                            <th>Duration</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($elections as $election)
                            <tr>
                                <td><strong>{{ $election->title }}</strong></td>
                                <td>
                                    <span style="background: var(--primary-color); color: white; padding: 6px 14px; border-radius: 30px; font-size: 0.9rem;">
                                        {{ ucfirst($election->scope) }}
                                    </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y') }}
                                    <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y') }}
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('admin.results.show', $election) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> View Results
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center; padding:80px 20px; color:#95a5a6;">
                                    <i class="fas fa-poll fa-4x mb-4 opacity-25"></i><br>
                                    No elections available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));

        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') sidebar.classList.remove('open');
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