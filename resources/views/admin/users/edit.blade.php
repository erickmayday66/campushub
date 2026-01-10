<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/admin/user_edit.css') }}">
    
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
            <a href="{{ route('admin.users.index') }}" class="active"><i class="fas fa-user-cog"></i> User Management</a>
            <a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> Student Management</a>
            <a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a>
            <a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a>
            <a href="#"><i class="fas fa-cog"></i> System Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="header-card">
            <h1>Edit User Account</h1>
            <p>Update user information and access level. Changes take effect immediately.</p>
        </div>

        <div class="form-card">

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required placeholder="Full name">
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required placeholder="user@example.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Access Level</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Full Access)</option>
                        <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Manager (Limited Access)</option>
                    </select>
                </div>

                <!-- Cancel left — Update right -->
                <div style="display: flex; gap: 24px; justify-content: space-between; align-items: center; margin-top: 32px;">
                    <a href="{{ route('admin.users.index') }}" class="btn-cancel">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        Update User
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

        // Load saved theme or detect system preference
        if (localStorage.getItem('theme') === 'dark' || 
           (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            body.classList.add('dark-theme');
        }

        // Listen for system theme changes (only if user hasn't manually set it)
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