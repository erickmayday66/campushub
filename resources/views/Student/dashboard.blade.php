<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Student Dashboard | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">   
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">Student Dashboard</span>
        
        <!-- User Profile with Logout -->
        <div class="user-actions">
            <div class="user-badge">
                <i class="fas fa-user-circle"></i>
                <span>{{ $student->name ?? 'Student' }}</span>
            </div>
            <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
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
            <i class="fas fa-user-circle"></i>
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
                    <button type="submit" class="btn text-white" aria-label="Logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

                <!-- Main Content -->
                <div class="main-content" id="main-content">
                    <div class="container mt-4">
                        <div class="dashboard-header mb-4">
                            <h1>Election Dashboard</h1>
                            <p class="text-muted">Manage your voting activities and participation</p>
                        </div>

                        <!-- Quick Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-vote-yea"></i>
                    </div>
                    <div>
                        <h3>{{ $elections->count() }}</h3>
                        <p>Active Elections</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3>{{ $votesCasted }}</h3>
                        <p>Votes Casted</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3>{{ $pendingVotes->count() }}</h3>
                        <p>Pending Actions</p>
                    </div>
                </div>
            </div>
            <!-- Elections Section -->
            <div class="elections-section">
                <div class="section-header">
                    <h4>Available Elections</h4>
                    <div class="filter-options">
                        <button class="btn btn-sm btn-outline-secondary active">All</button>
                        <button class="btn btn-sm btn-outline-secondary">Active</button>
                        <button class="btn btn-sm btn-outline-secondary">Upcoming</button>
                    </div>
                </div>

                @if($elections->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h5>No ongoing elections</h5>
                        <p class="text-muted">Check back later for upcoming elections</p>
                    </div>
                @else
                    <div class="election-grid mt-3">
                        @foreach($elections as $election)
                        <div class="election-card">
                            <div class="election-header">
                                <h5>{{ $election->title }}</h5>
                                <span class="badge bg-{{ $election->scope === 'department' ? 'info' : 'primary' }}">
                                    {{ ucfirst($election->scope) }}
                                </span>
                            </div>
                            <div class="election-details">
                                <p><i class="fas fa-calendar-alt me-2"></i> {{ $election->start_date }} - {{ $election->end_date }}</p>
                                <p class="mb-0"><i class="fas fa-info-circle me-2"></i> {{ \Illuminate\Support\Str::limit($election->description, 80) }}</p>
                            </div>
                            <div class="election-actions">
                                <a href="{{ route('student.elections.show', $election->id) }}" class="btn btn-primary">
                                    <i class="fas fa-vote-yea me-1"></i> View Election
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const navbar = document.querySelector('.navbar');

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
                // Remove active class from all links
                document.querySelectorAll('.sidebar-nav li a').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Add active class to clicked link
                this.classList.add('active');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
        }
    });
    </script>
</body>
</html>