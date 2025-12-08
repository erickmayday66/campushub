<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote in {{ $election->title }} | Student Dashboard | CampusHub</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/vote.css') }}">
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
                <h1>
                    <i class="fas fa-users" aria-hidden="true"></i> Vote in {{ $election->title }}
                </h1>
                <p>Scope: <span class="badge bg-{{ $election->scope === 'department' ? 'info' : 'primary' }}">{{ ucfirst($election->scope) }}</span></p>
                
            </header>

            @if(session('error'))
                <div class="alert-card alert-error" role="alert" aria-live="assertive">
                    <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('student.elections.vote', $election->id) }}" method="POST" aria-label="Vote for a candidate in {{ $election->title }}">
                @csrf
                @if($candidates->isEmpty())
                    <section class="no-candidates" aria-labelledby="no-candidates-heading">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <h2 id="no-candidates-heading">No Candidates Available</h2>
                        <p class="text-muted">No candidates are registered for this election.</p>
                    </section>
                @else
                    <div class="candidate-grid">
                        @foreach($candidates as $candidate)
                            <section class="candidate-card" aria-labelledby="candidate-{{ $candidate->id }}-heading">
                                <div class="candidate-image">
                                    @if($candidate->image)
                                        <img src="{{ asset('storage/' . $candidate->image) }}" alt="{{ $candidate->student->name ?? 'Candidate' }} photo" class="candidate-img">
                                    @else
                                        <div class="candidate-placeholder">
                                            <i class="fas fa-user-circle" aria-hidden="true"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="candidate-body">
                                    <h2 id="candidate-{{ $candidate->id }}-heading" class="candidate-title">
                                        {{ $candidate->student->name ?? 'Unknown Student' }}
                                    </h2>
                                    <p class="candidate-id">{{ $candidate->student->registration_number ?? 'N/A' }}</p>
                                    <div class="candidate-policies">{!! nl2br(e($candidate->policies ?? 'No policies provided')) !!}</div>
                                    <label class="candidate-select" for="candidate{{ $candidate->id }}">
                                        <input type="radio" name="candidate_id" id="candidate{{ $candidate->id }}" value="{{ $candidate->id }}" required aria-label="Select {{ $candidate->student->name ?? 'candidate' }}">
                                        <span class="select-text">Select this candidate</span>
                                    </label>
                                </div>
                            </section>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" aria-label="Submit vote for selected candidate">
                            <i class="fas fa-check" aria-hidden="true"></i> Submit Vote
                        </button>
                    </div>
                @endif
            </form>

            <div class="back-link">
                <a href="{{ route('student.elections') }}" class="btn btn-outline-secondary" aria-label="Return to elections page">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Elections
                </a>
            </div>
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