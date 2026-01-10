<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Management | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/Faculty_index.css') }}">
    
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

    <!-- Sidebar with Logout -->
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
            <li><a href="{{ route('admin.faculties.index') }}" class="active"><i class="fas fa-university"></i> Faculty Management</a></li>
            <li><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Analytics</a></li>
            <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
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
            <h1>Faculty Management</h1>
            <p>View, add, edit, or remove university faculties and departments.</p>
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
                            <th>Name</th>
                            <th>Code</th>
                            <th>Created</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faculties as $faculty)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>{{ $faculty->name }}</td>
                                <td><span style="background:var(--primary-color); color:white; padding:4px 10px; border-radius:20px; font-size:0.85rem;">{{ $faculty->code }}</span></td>
                                <td>{{ $faculty->created_at->format('d M Y') }}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('admin.faculties.edit', $faculty->id) }}" class="btn btn-outline-secondary" style="margin-right:8px;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.faculties.destroy', $faculty->id) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Delete this faculty?');">
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
                                <td colspan="5" style="text-align:center; padding:80px 20px; color:#95a5a6;">
                                    <i class="fas fa-university fa-4x mb-4 opacity-25"></i><br>
                                    No faculties found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FAB -->
    <a href="{{ route('admin.faculties.create') }}" class="fab">
        <i class="fas fa-plus"></i>
        <span class="tooltip-text">Add Faculty</span>
    </a>

    <script>
        // Sidebar toggle
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