<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Student | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/admin/student_create.css') }}">
    
    <style>
        
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
            <a href="{{ route('admin.students.index') }}" class="active"><i class="fas fa-users"></i> Student Management</a>
            <a href="{{ route('admin.results.index') }}"><i class="fas fa-poll"></i> Election Results</a>
            <a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a>
            <a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a>
            <a href="#"><i class="fas fa-cog"></i> System Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="header-card">
            <h1>Add New Student</h1>
            <p>Register a new student with their registration number, course, and secure credentials.</p>
        </div>

        <div class="form-card">

            @if ($errors->any())
                <div class="alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Registration Number</label>
                    <input type="text" name="registration_number" class="form-control" required placeholder="e.g. 2020/0100">
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="John Doe">
                </div>

                <div class="form-group">
                    <label class="form-label">Select Course</label>
                    <select name="course_id" class="form-select" required>
                        <option value="" disabled selected>-- Choose Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->faculty->name ?? 'No Faculty' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required minlength="6" placeholder="Minimum 6 characters">
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Re-type password">
                </div>

                <div style="display: flex; gap: 24px; justify-content: space-between; align-items: center; margin-top: 32px;">
                    <a href="{{ route('admin.students.index') }}" class="btn-cancel">
                        Back
                    </a>
                    <button type="submit" class="btn-primary">
                        Save Student
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