<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Election Results | CampusHub Admin</title>
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
            padding: 20px 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-radius: 12px;
        }
        tr:hover td { background: #f8f9ff; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45,59,142,0.3);
        }

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
    </style>
</head>
<body>

    <!-- Navbar — Clean icon only -->
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
            <a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i>ors Management</a>
            <a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a>
            <a href="{{ route('admin.results.index') }}" class="active"><i class="fas fa-poll"></i> Election Results</a>
            <a href="#"><i class="fas fa-cog"></i> System Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="header-card">
            <h1>All Elections - Vote Results</h1>
            <p>View detailed results for all completed and ongoing elections.</p>
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

        <!-- Elections Table Card -->
        <div class="card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Election Title</th>
                            <th>Scope</th>
                            <th>Duration</th>
                            <th style="width: 160px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($elections as $election)
                            <tr>
                                <td><strong>{{ $election->title }}</strong></td>
                                <td>
                                    <span class="badge bg-info text-dark px-3 py-2 rounded-pill">
                                        {{ ucfirst($election->scope) }}
                                    </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($election->start_date)->format('M d, Y') }}
                                    <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($election->end_date)->format('M d, Y') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.results.show', $election) }}" class="btn btn-primary">
                                        View Results
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-poll fa-3x mb-3 opacity-25"></i><br>
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