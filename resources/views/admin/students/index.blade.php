<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            overflow-x: hidden;
        }

        /* === SAME NAVBAR & SIDEBAR AS BEFORE (kept for consistency) === */
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
        .notification-badge { position: relative; width: 40px; height: 40px; background: white; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; color: var(--gray-600); }
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
            width: var(--sidebar-width); background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            height: 100vh; position: fixed; top: 0; left: 0; transform: translateX(-100%);
            transition: transform 0.3s ease; z-index: 1000; display: flex; flex-direction: column;
            box-shadow: 5px 0 30px rgba(0,0,0,0.05); border-right: 1px solid rgba(255,255,255,0.8);
            padding-top: var(--navbar-height); overflow: hidden;
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar-header { text-align: center; padding: 30px 20px; border-bottom: 1px solid rgba(0,0,0,0.05); background: rgba(255,255,255,0.5); flex-shrink: 0; }
        .avatar-large { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); color: white; font-size: 2.2rem; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; border: 4px solid rgba(255,255,255,0.8); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        .sidebar-nav { list-style: none; padding: 10px 0; flex: 1; overflow-y: auto; }
        .sidebar-nav::-webkit-scrollbar { width: 6px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(45,59,142,0.2); border-radius: 10px; }
        .sidebar-nav li a {
            display: flex; align-items: center; padding: 14px 20px; color: var(--gray-600);
            text-decoration: none; margin: 4px 15px; border-radius: var(--border-radius); font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-nav li a:hover { background: rgba(45,59,142,0.05); color: var(--primary-color); transform: translateX(5px); }
        .sidebar-nav li a.active { background: linear-gradient(90deg, rgba(45,59,142,0.1), rgba(45,59,142,0.05)); color: var(--primary-color); font-weight: 600; border-left: 4px solid var(--primary-color); }
        .sidebar-nav i { margin-right: 12px; width: 20px; text-align: center; font-size: 1.1rem; }

        .logout-item { padding: 15px; border-top: 1px solid rgba(0,0,0,0.05); background: rgba(255,255,255,0.5); }
        .logout-item button { width: 100%; text-align: left; padding: 14px 20px; background: transparent; border: none; color: var(--gray-600); font-weight: 500; border-radius: var(--border-radius); cursor: pointer; display: flex; align-items: center; gap: 12px; }
        .logout-item button:hover { background: rgba(231,76,60,0.05); color: var(--danger-color); }

        .main-content {
            margin-left: 0; padding: calc(var(--navbar-height) + 30px) 30px 100px;
            transition: margin-left 0.3s ease; min-height: 100vh;
        }
        .sidebar.open ~ .main-content { margin-left: var(--sidebar-width); }

        .dashboard-header {
            background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); border-radius: var(--border-radius);
            padding: 30px; box-shadow: var(--box-shadow); margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.8);
        }
        .dashboard-header h1 {
            font-size: 2rem; font-weight: 700; color: var(--secondary-color); margin-bottom: 10px;
            display: flex; align-items: center; gap: 15px;
        }
        .dashboard-header h1::before {
            content: ''; width: 6px; height: 40px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light)); border-radius: 3px;
        }

        .card {
            background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); border-radius: var(--border-radius);
            padding: 28px; box-shadow: var(--box-shadow); border: 1px solid rgba(255,255,255,0.8);
            margin-bottom: 30px;
        }

        /* SEARCH BAR - BEAUTIFUL & RESPONSIVE */
        .search-container {
            position: relative; margin-bottom: 25px; max-width: 500px;
        }
        .search-input {
            width: 100%; padding: 14px 50px 14px 20px; border: 2px solid #e2e8f0;
            border-radius: 16px; font-size: 1rem; background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s;
        }
        .search-input:focus {
            outline: none; border-color: var(--primary-color);
            box-shadow: 0 0 0 5px rgba(45,59,142,0.15);
        }
        .search-icon {
            position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
            color: var(--primary-color); font-size: 1.3rem; pointer-events: none;
        }
        .search-results-count {
            margin-top: 8px; font-size: 0.95rem; color: var(--gray-600);
        }

        table { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
        th { background: rgba(45,59,142,0.05); color: var(--primary-color); font-weight: 600; padding: 16px; text-align: left; }
        td { background: white; padding: 20px 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px; }
        tr:hover td { background: #f8f9ff; }
        .no-results { text-align: center; padding: 60px 20px; color: #95a5a6; }
        .no-results i { font-size: 3rem; opacity: 0.3; margin-bottom: 15px; display: block; }

        .btn { padding: 8px 16px; border-radius: 8px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
        .btn-warning { background: rgba(243,156,18,0.1); color: #f39c12; border: 1px solid rgba(243,156,18,0.2); }
        .btn-danger { background: rgba(231,76,60,0.1); color: var(--danger-color); border: 1px solid rgba(231,76,60,0.2); }

        .alert-success {
            background: rgba(46,204,113,0.1); color: var(--success-color);
            border: 1px solid rgba(46,204,113,0.2); border-radius: 12px;
            padding: 16px 20px; margin-bottom: 25px; font-weight: 500;
        }

        .fab {
            position: fixed; bottom: 30px; right: 30px; width: 62px; height: 62px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; box-shadow: 0 10px 30px rgba(45,59,142,0.4); z-index: 1000;
            transition: all 0.3s; text-decoration: none;
        }
        .fab:hover { transform: scale(1.1); box-shadow: 0 15px 40px rgba(45,59,142,0.5); }
        .fab .tooltip-text {
            position: absolute; right: 75px; background: var(--primary-color); color: white;
            padding: 10px 18px; border-radius: 30px; font-size: 0.95rem; font-weight: 500;
            white-space: nowrap; opacity: 0; visibility: hidden; transition: all 0.3s ease;
        }
        .fab:hover .tooltip-text { opacity: 1; visibility: visible; right: 80px; }
        @media (max-width: 768px) { .fab .tooltip-text { display: none; } }
    </style>
</head>
<body>

    <!-- Navbar & Sidebar (same as before) -->
    <nav class="navbar">
        <button id="toggle-btn"><i class="fas fa-bars"></i></button>
        <span class="navbar-title">CampusHub Admin</span>
        <div class="user-actions">
            <div class="user-badge">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i><span class="logout-text">Logout</span></button>
            </form>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="avatar-large"><i class="fas fa-user-shield"></i></div>
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->role ?? 'Administrator' }}</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-user-cog"></i> User Management</a></li>
            <li><a href="{{ route('admin.students.index') }}" class="active"><i class="fas fa-users"></i> Student Management</a></li>
            <li><a href="{{ route('admin.results.index') }}"><i class="fas fa-poll"></i> Election Results</a></li>
            <li><a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a></li>
            <li><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a></li>
        </ul>
        <div class="logout-item">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="dashboard-header">
            <h1>Student Management</h1>
            <p>Manage all registered students across courses and faculties.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <!-- SEARCH BAR + IMPORT CARD -->
        <div class="card" style="border-left: 5px solid var(--success-color);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
                <h5 style="margin:0; color:var(--secondary-color);">Import Students from Excel</h5>
                <div style="width:50px; height:50px; background:rgba(46,204,113,0.1); color:var(--success-color); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                    <i class="fas fa-file-excel"></i>
                </div>
            </div>
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display:flex; gap:15px; align-items:end; flex-wrap:wrap;">
                    <div style="flex:1; min-width:280px;">
                        <label class="form-label fw-semibold">Excel File</label>
                        <input type="file" name="file" accept=".xlsx,.xls" class="form-control" required
                               style="padding:14px; border:2px dashed #cbd5e1; border-radius:12px; background:rgba(255,255,255,0.8);">
                        <small class="text-muted">.xlsx, .xls • Max 10MB</small>
                    </div>
                    <button type="submit" class="btn btn-success px-4 py-3 rounded-pill" style="font-weight:600;">
                        <i class="fas fa-file-import me-2"></i> Import
                    </button>
                </div>
            </form>
        </div>

        <!-- SEARCH BAR -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Search by name, registration number, course or faculty..." autocomplete="off">
            <i class="fas fa-search search-icon"></i>
            <div class="search-results-count" id="resultsCount">Showing <strong>{{ $students->count() }}</strong> students</div>
        </div>

        <!-- Students Table -->
        <div class="card">
            <div style="overflow-x:auto;">
                <table id="studentsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Reg. Number</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Joined</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($students as $student)
                            <tr data-search="{{ strtolower($student->name . ' ' . $student->registration_number . ' ' . ($student->course->name ?? '') . ' ' . ($student->course->faculty->name ?? '')) }}">
                                <td><strong>{{ $student->name }}</strong></td>
                                <td>{{ $student->registration_number }}</td>
                                <td>{{ $student->course->name ?? '—' }}</td>
                                <td>{{ $student->course->faculty->name ?? '—' }}</td>
                                <td>{{ $student->created_at->format('d M Y') }}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning" style="margin-right:8px;">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete {{ $student->name }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr id="noResults" class="no-results">
                                <td colspan="6"><i class="fas fa-users"></i><br>No students found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FAB -->
    <a href="{{ route('admin.students.create') }}" class="fab">
        <i class="fas fa-plus"></i>
        <span class="tooltip-text">Add Student</span>
    </a>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));

        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') sidebar.classList.remove('open'); });

        // LIVE SEARCH SCRIPT
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#studentsTable tbody tr[data-search]');
        const resultsCount = document.getElementById('resultsCount');
        const noResultsRow = document.getElementById('noResults');

        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();
            let visible = 0;

            tableRows.forEach(row => {
                const text = row.getAttribute('data-search');
                if (term === '' || text.includes(term)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            resultsCount.innerHTML = `Showing <strong>${visible}</strong> student${visible !== 1 ? 's' : ''}`;
            noResultsRow.style.display = visible === 0 ? '' : 'none';
        });
    </script>
</body>
</html>