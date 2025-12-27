<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins & Managers | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2d3b8e;
            --primary-dark: #1e2a78;
            --primary-light: #4a5ccc;
            --secondary-color: #1a1d2e;
            --danger-color: #e74c3c;
            --gray-600: #616e7c;
            --gray-800: #323f4b;
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            --box-shadow-lg: 0 15px 40px rgba(0,0,0,0.12);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            color: var(--gray-800);
            min-height: 100vh;
            position: relative;
        }

        /* Navbar */
        .navbar {
            height: var(--navbar-height);
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
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
            font-size: 20px;
            background: rgba(45,59,142,0.1);
            border: none;
            color: var(--primary-color);
            width: 40px; height: 40px;
            border-radius: 10px;
            cursor: pointer;
            margin-right: 20px;
            transition: 0.3s;
        }
        #toggle-btn:hover { background: rgba(45,59,142,0.2); transform: rotate(90deg); }
        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        .user-actions { margin-left: auto; display: flex; align-items: center; gap: 15px; }
        .user-badge {
            display: flex; align-items: center; gap: 12px;
            background: rgba(45,59,142,0.05);
            padding: 8px 15px 8px 8px;
            border-radius: 30px;
            font-weight: 500;
            border: 1px solid rgba(45,59,142,0.1);
        }
        .user-badge .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white; font-weight: 600;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-logout {
            background: rgba(231,76,60,0.05);
            color: var(--danger-color);
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

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 5px 0 30px rgba(0,0,0,0.05);
            border-right: 1px solid rgba(255,255,255,0.8);
            padding-top: var(--navbar-height);
            overflow-y: auto;
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar-header { text-align: center; padding: 30px 20px; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .avatar-large {
            width: 90px; height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white; font-size: 2.2rem;
            margin: 0 auto 15px;
            display: flex; align-items: center; justify-content: center;
            border: 4px solid rgba(255,255,255,0.8);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .sidebar-nav a {
            display: flex; align-items: center;
            padding: 14px 15px;
            color: var(--gray-600);
            text-decoration: none;
            border-radius: var(--border-radius);
            margin: 0 15px 8px;
            font-weight: 500;
            transition: 0.2s;
        }
        .sidebar-nav a:hover { background: rgba(45,59,142,0.05); color: var(--primary-color); transform: translateX(5px); }
        .sidebar-nav a.active {
            background: linear-gradient(90deg, rgba(45,59,142,0.1), rgba(45,59,142,0.05));
            color: var(--primary-color);
            font-weight: 600;
            border-left: 4px solid var(--primary-color);
        }
        .sidebar-nav i { margin-right: 12px; width: 20px; text-align: center; }

        /* Main Content */
        .main-content {
            margin-left: 0;
            padding: calc(var(--navbar-height) + 30px) 30px 100px; /* Extra bottom padding for FAB */
            transition: margin-left 0.3s ease;
        }
        .sidebar.open ~ .main-content { margin-left: var(--sidebar-width); }

        .page-header {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.8);
        }
        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .page-header h1::before {
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
            padding: 25px;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255,255,255,0.8);
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
            text-align: left;
            padding: 15px;
        }
        td {
            background: white;
            padding: 18px 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        tr td:first-child { border-top-left-radius: var(--border-radius); border-bottom-left-radius: var(--border-radius); }
        tr td:last-child { border-top-right-radius: var(--border-radius); border-bottom-right-radius: var(--border-radius); }

        .action-buttons .btn {
            width: 38px; height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 4px;
            border: none;
        }
        .btn-warning { background: rgba(243,156,18,0.1); color: #f39c12; }
        .btn-danger { background: rgba(231,76,60,0.1); color: var(--danger-color); }
        .btn-secondary { background: rgba(108,117,125,0.1); color: var(--gray-600); }

        .alert {
            border-radius: var(--border-radius);
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        /* Floating Action Button (FAB) */
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
            font-size: 1.7rem;
            box-shadow: 0 10px 30px rgba(45,59,142,0.4);
            z-index: 1000;
            transition: all 0.3s ease;
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
            pointer-events: none;
        }
        .fab:hover .tooltip-text {
            opacity: 1;
            visibility: visible;
            right: 80px;
        }
        @media (max-width: 768px) {
            .fab { width: 56px; height: 56px; bottom: 20px; right: 20px; font-size: 1.5rem; }
            .fab .tooltip-text { display: none; }
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
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
                    <i class="fas fa-sign-out-alt"></i> <span class="logout-text">Logout</span>
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
        <div class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="active"><i class="fas fa-user-cog"></i> User Management</a>
            <a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> Student Management</a>
            <a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a>
            <a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a>
            <a href="#"><i class="fas fa-cog"></i> System Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="page-header">
            <h1><i class="fas fa-user-cog"></i> Manage Admins & Managers</h1>
            <p>View, edit, and delete system administrators and managers.</p>
        </div>

        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 140px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-primary text-white px-3 py-1 rounded-pill">{{ ucfirst($user->role) }}</span></td>
                                <td class="action-buttons text-center">
                                    @if(auth()->id() !== $user->id)
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;"
                                              onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled title="Cannot delete yourself">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <a href="{{ route('admin.users.create') }}" class="fab" aria-label="Add New User">
        <i class="fas fa-plus"></i>
        <span class="tooltip-text">Add New User</span>
    </a>

    <script>
        document.getElementById('toggle-btn').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-btn');
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>