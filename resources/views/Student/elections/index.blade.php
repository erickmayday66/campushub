<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eligible Elections | Student Dashboard | CampusHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/elections.css') }}">
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
            <li><a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('student.elections') }}" class="{{ request()->routeIs('student.elections') ? 'active' : '' }}"><i class="fas fa-vote-yea"></i> Elections</a></li>
            <li><a href="{{ route('student.profile') }}" class="{{ request()->routeIs('student.profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="{{ route('student.settings') }}" class="{{ request()->routeIs('student.settings') ? 'active' : '' }}"><i class="fas fa-cogs"></i> Settings</a></li>
            <li><a href="#" class=""><i class="fas fa-question-circle"></i> Help Center</a></li>
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
                <h1><i class="fas fa-vote-yea" aria-hidden="true"></i> Eligible Elections</h1>
                
            </header>

            @if($elections->isEmpty())
                <section class="no-elections" aria-labelledby="no-elections-heading">
                    <i class="fas fa-calendar-times" aria-hidden="true"></i>
                    <h2 id="no-elections-heading">No Active Elections</h2>
                    <p class="text-muted">Check back later for upcoming elections.</p>
                </section>
            @else
                <div class="election-grid">
                    @foreach($elections as $election)
                        <section class="election-card" aria-labelledby="election-{{ $election->id }}-heading">
                            <div class="election-header">
                                <i class="fas fa-vote-yea" aria-hidden="true"></i>
                                <h2 id="election-{{ $election->id }}-heading">{{ $election->title }}</h2>
                                <span class="badge bg-{{ $election->scope === 'department' ? 'info' : 'primary' }}">
                                    {{ ucfirst($election->scope) }}
                                </span>
                            </div>
                            <div class="election-body">
                                <div class="election-details">
                                    <p><i class="fas fa-tag me-2" aria-hidden="true"></i> <strong>Category:</strong> {{ ucfirst($election->category) }}</p>
                                    <p><i class="fas fa-calendar-alt me-2" aria-hidden="true"></i> <strong>Start Date:</strong> {{ \Carbon\Carbon::parse($election->start_date)->format('d M Y') }}</p>
                                    <p><i class="fas fa-calendar-check me-2" aria-hidden="true"></i> <strong>End Date:</strong> {{ \Carbon\Carbon::parse($election->end_date)->format('d M Y') }}</p>
                                </div>
                                <div class="election-actions">
                                    <a href="{{ route('student.elections.show', $election->id) }}" class="btn btn-success" aria-label="Vote in {{ $election->title }}">
                                        <i class="fas fa-vote-yea me-1" aria-hidden="true"></i> Vote Now
                                    </a>
                                    <a href="{{ route('student.results') }}#election-{{ $election->id }}" class="btn btn-outline-secondary" aria-label="View results for {{ $election->title }}">
                                        <i class="fas fa-chart-bar me-1" aria-hidden="true"></i> View Results
                                    </a>
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            @endif

            <footer class="footer">
                <p>© {{ date('Y') }} Student Portal. All rights reserved.</p>
            </footer>
        </div>
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