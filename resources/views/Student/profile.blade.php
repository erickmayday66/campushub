<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile | Student Dashboard | CampusHub</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <button id="toggle-btn" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">Student Dashboard</span>
        <div class="user-actions">
            <div class="user-badge" aria-label="User profile">
                <i class="fas fa-user-circle"></i>
                <span>{{ $student->name ?? 'Student' }}</span>
            </div>
            <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn btn-logout" aria-label="Log out">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="logout-text">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar" aria-label="Sidebar navigation">
        <div class="sidebar-header">
            <i class="fas fa-user-circle" aria-hidden="true"></i>
            <h2>Welcome, {{ explode(' ', $student->name)[0] ?? 'Student' }}</h2>
            <p class="text-muted small">{{ $student->registration_number }}</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> Dashboard</a></li>
            <li><a href="{{ route('student.elections') }}" class="{{ request()->routeIs('student.elections') ? 'active' : '' }}"><i class="fas fa-vote-yea" aria-hidden="true"></i> Elections</a></li>
            <li><a href="{{ route('student.profile') }}" class="{{ request()->routeIs('student.profile') ? 'active' : '' }}"><i class="fas fa-user" aria-hidden="true"></i> Profile</a></li>
            <li><a href="{{ route('student.settings') }}" class="{{ request()->routeIs('student.settings') ? 'active' : '' }}"><i class="fas fa-cogs" aria-hidden="true"></i> Settings</a></li>
            <li><a href="#"><i class="fas fa-question-circle" aria-hidden="true"></i> Help Center</a></li>
            <li class="logout-item">
                <form method="POST" action="{{ route('student.logout') }}">
                    @csrf
                    <button type="submit" class="btn text-white" aria-label="Log out">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="main-content">
        <div class="container">
            <header class="header">
                <h1>
                    <i class="fas fa-user" aria-hidden="true"></i> My Profile
                </h1>
                
            </header>

            <section class="profile-card" aria-labelledby="profile-heading">
                <div class="profile-banner">
                    <i class="fas fa-user-circle profile-avatar" aria-hidden="true"></i>
                </div>
                <div class="profile-body">
                    <h2 id="profile-heading" class="profile-title">{{ $student->name ?? 'Student' }}</h2>
                    <p class="profile-id">{{ $student->registration_number ?? 'N/A' }}</p>
                    <div class="profile-details">
                        <div class="profile-detail">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                            <div class="detail-content">
                                <span class="detail-label">Faculty</span>
                                <span class="detail-value">{{ $student->faculty->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="profile-detail">
                            <i class="fas fa-book" aria-hidden="true"></i>
                            <div class="detail-content">
                                <span class="detail-label">Course</span>
                                <span class="detail-value">{{ $student->course->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="profile-detail">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                            <div class="detail-content">
                                <span class="detail-label">Year Joined</span>
                                <span class="detail-value">{{ $student->registration_year ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="footer">
            <p>© {{ date('Y') }} Student Portal. All rights reserved.</p>
        </footer>
    </main>

    <script>
        // Sidebar Toggle
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const navbar = document.querySelector('.navbar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            document.body.classList.toggle('sidebar-open');
        });

        document.addEventListener('click', (e) => {
            const isSidebarOpen = sidebar.classList.contains('open');
            const isClickInsideSidebar = sidebar.contains(e.target);
            const isClickOnToggleBtn = toggleBtn.contains(e.target);
            
            if (isSidebarOpen && !isClickInsideSidebar && !isClickOnToggleBtn) {
                sidebar.classList.remove('open');
                document.body.classList.remove('sidebar-open');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                document.body.classList.remove('sidebar-open');
            }
        });

        window.addEventListener('scroll', () => {
            navbar.classList.toggle('sticky', window.scrollY > 0);
        });

        // Sidebar Navigation Active State
        document.querySelectorAll('.sidebar-nav li a').forEach(link => {
            link.addEventListener('click', function(e) {
                document.querySelectorAll('.sidebar-nav li a').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        const savedTheme = localStorage.getItem('theme');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        if (savedTheme === 'dark' || (!savedTheme && prefersDarkScheme.matches)) {
            body.classList.add('dark-theme');
            themeToggle.checked = true;
        }

        themeToggle.addEventListener('change', function() {
            body.classList.toggle('dark-theme', this.checked);
            localStorage.setItem('theme', this.checked ? 'dark' : 'light');
        });
    </script>
</body>
</html>