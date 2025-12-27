<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Management | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2d3b8e;
            --primary-dark: #1e2a78;
            --primary-light: #4a5ccc;
            --secondary-color: #1a1d2e;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --gray-600: #616e7c;
            --gray-800: #323f4b;
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --transition-speed: 0.3s;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            --box-shadow-lg: 0 15px 40px rgba(0,0,0,0.12);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ==================== NAVBAR ==================== */
        .navbar {
            width: 100%;
            height: var(--navbar-height);
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0; left: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.8);
        }
        #toggle-btn {
            font-size: 20px;
            background: rgba(45,59,142,0.1);
            border: none;
            color: var(--primary-color);
            width: 40px; height: 40px;
            border-radius: 10px;
            cursor: pointer;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        #toggle-btn:hover { background: rgba(45,59,142,0.2); transform: rotate(90deg); }

        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
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
        .notification-badge {
            position: relative;
            width: 40px; height: 40px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            cursor: pointer;
        }
        .notification-badge:hover { color: var(--primary-color); }
        .notification-badge::after {
            content: '{{ $unreadCount ?? "0" }}';
            position: absolute;
            top: -5px; right: -5px;
            background: var(--danger-color);
            color: white;
            width: 20px; height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(45,59,142,0.05);
            padding: 8px 15px 8px 8px;
            border-radius: 30px;
            border: 1px solid rgba(45,59,142,0.1);
            font-weight: 500;
        }
        .user-badge .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-logout {
            background: rgba(231,76,60,0.05);
            color: var(--danger-color);
            border: 1px solid rgba(231,76,60,0.1);
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .btn-logout:hover { background: rgba(231,76,60,0.1); transform: translateY(-2px); }

        /* ==================== SIDEBAR (SCROLLABLE + LOGOUT AT BOTTOM) ==================== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            transform: translateX(-100%);
            transition: transform var(--transition-speed) ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 5px 0 30px rgba(0,0,0,0.05);
            border-right: 1px solid rgba(255,255,255,0.8);
            padding-top: var(--navbar-height);
            overflow: hidden;
        }
        .sidebar.open { transform: translateX(0); }

        .sidebar-header {
            text-align: center;
            padding: 30px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,255,0.5);
            flex-shrink: 0;
        }
        .avatar-large {
            width: 90px; height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            font-size: 2.2rem;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(255,255,255,0.8);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .sidebar-nav {
            list-style: none;
            padding: 10px 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar-nav::-webkit-scrollbar { width: 6px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(45,59,142,0.2);
            border-radius: 10px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(45,59,142,0.4); }
        .sidebar-nav { scrollbar-width: thin; scrollbar-color: rgba(45,59,142,0.3) transparent; }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: var(--gray-600);
            text-decoration: none;
            margin: 4px 15px;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-nav li a:hover {
            background: rgba(45,59,142,0.05);
            color: var(--primary-color);
            transform: translateX(5px);
        }
        .sidebar-nav li a.active {
            background: linear-gradient(90deg, rgba(45,59,142,0.1), rgba(45,59,142,0.05));
            color: var(--primary-color);
            font-weight: 600;
            border-left: 4px solid var(--primary-color);
        }
        .sidebar-nav i { margin-right: 12px; width: 20px; text-align: center; font-size: 1.1rem; }

        /* Logout at the bottom */
        .logout-item {
            padding: 15px;
            border-top: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,0.5);
            flex-shrink: 0;
        }
        .logout-item button {
            width: 100%;
            text-align: left;
            padding: 14px 20px;
            background: transparent;
            border: none;
            color: var(--gray-600);
            font-weight: 500;
            border-radius: var(--border-radius);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
        }
        .logout-item button:hover {
            background: rgba(231,76,60,0.05);
            color: var(--danger-color);
            transform: translateX(5px);
        }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            margin-left: 0;
            padding: calc(var(--navbar-height) + 30px) 30px 100px;
            transition: margin-left var(--transition-speed) ease;
            min-height: 100vh;
        }
        .sidebar.open ~ .main-content { margin-left: var(--sidebar-width); }

        .dashboard-header {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.8);
        }
        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
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

        .card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 28px;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255,255,255,0.8);
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }
        th {
            background: rgba(45,59,142,0.05);
            color: var(--primary-color);
            font-weight: 600;
            padding: 16px;
            text-align: left;
        }
        td {
            background: white;
            padding: 20px 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-radius: 12px;
        }
        tr:hover td { background: #f8f9ff; }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-outline-secondary { background: rgba(108,117,125,0.1); color: #6c757d; border: 1px solid rgba(108,117,125,0.2); }
        .btn-outline-danger { background: rgba(231,76,60,0.1); color: var(--danger-color); border: 1px solid rgba(231,76,60,0.2); }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .alert-success { background: rgba(46,204,113,0.1); color: var(--success-color); border: 1px solid rgba(46,204,113,0.2); }
        .alert-danger { background: rgba(231,76,60,0.1); color: var(--danger-color); border: 1px solid rgba(231,76,60,0.2); }

        /* ==================== FAB (EXACTLY AS YOUR ORIGINAL DASHBOARD) ==================== */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 62px;
            height: 62px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 10px 30px rgba(45,59,142,0.4);
            z-index: 1000;
            transition: all 0.3s;
            text-decoration: none;
        }
        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(45,59,142,0.5);
        }
        .fab .tooltip-text {
            position: absolute;
            right: 75px;
            background: var(--primary-color);
            color: white;
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .fab:hover .tooltip-text {
            opacity: 1;
            visibility: visible;
            right: 80px;
        }
        @media (max-width: 768px) { .fab .tooltip-text { display: none; } }

        @media (max-width: 768px) {
            .main-content { padding: calc(var(--navbar-height) + 20px) 20px 90px; }
            .user-badge span, .logout-text { display: none; }
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
            <div class="notification-badge">
                <i class="fas fa-bell"></i>
            </div>
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

    <!-- Sidebar with Logout at Bottom -->
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
            <li><a href="{{ route('admin.results.index') }}"><i class="fas fa-poll"></i> Election Results</a></li>
            <li><a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a></li>
            <li><a href="{{ route('admin.courses.index') }}" class="active"><i class="fas fa-book"></i> Course Management</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Analytics</a></li>
            <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>

        <!-- Logout Button in Sidebar -->
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
            <h1>Course Management</h1>
            <p>View, add, edit, or remove academic courses and their details.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Code</th>
                            <th>Duration (Years)</th>
                            <th>Faculty</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>{{ $course->name }}</td>
                                <td><span style="background:var(--primary-color); color:white; padding:4px 10px; border-radius:20px; font-size:0.85rem;">{{ $course->code }}</span></td>
                                <td>{{ $course->duration_years }}</td>
                                <td>{{ $course->faculty->name ?? '—' }}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-outline-secondary" style="margin-right:8px;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:80px 20px; color:#95a5a6;">
                                    <i class="fas fa-book-open fa-4x mb-4 opacity-25"></i><br>
                                    No courses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FAB - Exactly like your original dashboard -->
    <a href="{{ route('admin.courses.create') }}" class="fab">
        <i class="fas fa-plus"></i>
        <span class="tooltip-text">Add Course</span>
    </a>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));

        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('open') && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') sidebar.classList.remove('open');
        });
    </script>
</body>
</html>