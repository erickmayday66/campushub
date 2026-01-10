<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Faculty | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/Faculty_edit.css') }}">
    
</head>
<body>

    <!-- Navbar -->
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
            <h1>Edit Faculty</h1>
            <p>Update the name and code of this faculty or department.</p>
        </div>

        <div class="form-card">

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.faculties.update', $faculty->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Faculty Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $faculty->name) }}" required placeholder="e.g., Faculty of Science">
                </div>

                <div class="form-group">
                    <label class="form-label">Faculty Code</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $faculty->code) }}" required placeholder="e.g., FSCI">
                </div>

                <div style="display: flex; gap: 24px; justify-content: space-between; align-items: center; margin-top: 32px;">
                    <a href="{{ route('admin.faculties.index') }}" class="btn-cancel">
                        Back
                    </a>
                    <button type="submit" class="btn-primary">
                        Update Faculty
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