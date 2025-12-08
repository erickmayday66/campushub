<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Faculties | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
        }

        /* Navbar */
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
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* Sidebar */
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
            padding: calc(70px + 40px) 40px 100px;
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

        .card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(16px);
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--shadow);
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
            color: var(--primary);
            font-weight: 600;
            padding: 16px;
            text-align: left;
        }
        td {
            background: white;
            padding: 18px 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-radius: 12px;
        }
        tr:hover td { background: #f8f9ff; }

        .btn-sm {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
        }
        .btn-outline-secondary { background: rgba(108,117,125,0.1); color: #6c757d; border: none; }
        .btn-outline-danger { background: rgba(231,76,60,0.1); color: var(--danger); border: none; }

        .alert-success {
            background: rgba(46,204,113,0.1);
            color: #16a085;
            border: 1px solid rgba(46,204,113,0.2);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }
        .alert-danger {
            background: rgba(231,76,60,0.1);
            color: var(--danger);
            border: 1px solid rgba(231,76,60,0.2);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }

        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 62px;
            height: 62px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
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
            background: var(--primary);
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
        .fab:hover .tooltip-text { opacity: 1; visibility: visible; right: 80px; }
        @media (max-width: 768px) { .fab .tooltip-text { display: none; } }
    </style>
</head>
<body>

    <!-- Navbar — Clean icon only, no "Menu" text -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
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
            <a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a>
            <a href="{{ route('admin.faculties.index') }}" class="active"><i class="fas fa-university"></i> Faculty Management</a>
            <a href="#"><i class="fas fa-cog"></i> System Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="header-card">
            <h1>Manage Faculties</h1>
            <p>View, add, edit, or remove university faculties and departments.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Faculties Table Card -->
        <div class="card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Created</th>
                            <th style="width: 140px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faculties as $index => $faculty)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>{{ $faculty->name }}</td>
                                <td><span class="badge bg-primary">{{ $faculty->code }}</span></td>
                                <td>{{ $faculty->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.faculties.edit', $faculty->id) }}" class="btn btn-sm btn-outline-secondary">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.faculties.destroy', $faculty->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this faculty?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-university fa-3x mb-3 opacity-25"></i><br>
                                    No faculties found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <a href="{{ route('admin.faculties.create') }}" class="fab" title="Add Faculty">
        <i class="fas fa-plus"></i>
        <span class="tooltip-text">Add Faculty</span>
    </a>

    <script>
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
    </script>
</body>
</html>