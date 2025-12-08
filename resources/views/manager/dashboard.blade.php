<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manager/style.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">CampusHub Manager</span>
        
        <!-- User Profile with Logout -->
        <div class="user-actions">
            <button class="theme-toggle" id="theme-toggle" aria-label="Toggle theme">
                <i class="fas fa-moon"></i>
            </button>
            <div class="user-badge">
                <i class="fas fa-user-circle"></i>
                <span>{{ auth()->user()->name ?? 'Manager' }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn btn-logout" aria-label="Logout">
                    <i class="fas fa-sign-out-alt"></i> <span class="logout-text">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h2>{{ auth()->user()->name }}</h2>
            <p>Election Manager</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('manager.dashboard') }}" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('manager.elections.index') }}"><i class="fas fa-vote-yea"></i> Elections</a></li>
            <li><a href="{{ route('manager.candidates.index') }}"><i class="fas fa-users"></i> Candidates</a></li>
            <li><a href="{{ route('manager.faculties.index') }}"><i class="fas fa-university"></i> Faculties</a></li>
            <li><a href="{{ route('manager.courses.index') }}"><i class="fas fa-book"></i> Courses</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="{{ route('manager.settings.edit') }}"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="#"><i class="fas fa-question-circle"></i> Support</a></li>
            <li class="logout-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn text-white" aria-label="Logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-tachometer-alt me-2"></i> Manager Dashboard</h1>
            <p>Welcome back! Here's an overview of your election management activities. You have 3 active elections and 12 pending tasks.</p>
        </div>

        <!-- Stats Overview -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="value">{{ $activeElections }}</div>
                <div class="label">Active Elections</div>
                <div class="icon"><i class="fas fa-vote-yea"></i></div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $totalCandidates }}</div>
                <div class="label">Total Candidates</div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $totalVotes }}</div>
                <div class="label">Votes Cast</div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <div class="stat-card">
                <div class="value">{{ $participationRate }}%</div>
                <div class="label">Participation Rate</div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>

        <div class="section-title">
            <i class="fas fa-th-large"></i> Management Modules
        </div>

        <!-- Action Cards Grid -->
        <div class="action-grid">            
            <a href="{{ route('manager.elections.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-vote-yea"></i>
                    <span class="badge">{{ $activeElections }} Active</span>
                </div>
                <div class="action-content">
                    <h3>Elections</h3>
                    <p>Create, configure, and monitor campus-wide election processes</p>
                </div>
            </a>
            
            <a href="{{ route('manager.candidates.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-users"></i>
                    <span class="badge">{{ $totalCandidates }} Profiles</span>
                </div>
                <div class="action-content">
                    <h3>Candidates</h3>
                    <p>Manage candidate profiles, positions, and campaign materials</p>
                </div>
            </a>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const navbar = document.querySelector('.navbar');
        const themeToggle = document.getElementById('theme-toggle');

        // Toggle sidebar visibility
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            document.body.classList.toggle('sidebar-open');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            const isSidebarOpen = sidebar.classList.contains('open');
            const isClickInsideSidebar = sidebar.contains(e.target);
            const isClickOnToggleBtn = toggleBtn.contains(e.target);
            
            if (isSidebarOpen && !isClickInsideSidebar && !isClickOnToggleBtn) {
                sidebar.classList.remove('open');
            }
        });

        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Make navbar sticky on scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 0) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
        });

        // Add active state to menu items
        document.querySelectorAll('.sidebar-nav li a').forEach(link => {
            link.addEventListener('click', function(e) {
                document.querySelectorAll('.sidebar-nav li a').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Theme toggle functionality
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            themeToggle.innerHTML = `<i class="fas fa-${newTheme === 'light' ? 'moon' : 'sun'}"></i>`;
            localStorage.setItem('theme', newTheme);
        });

        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        themeToggle.innerHTML = `<i class="fas fa-${savedTheme === 'light' ? 'moon' : 'sun'}"></i>`;
    </script>
</body>
</html>