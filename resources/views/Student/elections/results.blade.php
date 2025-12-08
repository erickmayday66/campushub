<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results | Student Dashboard | CampusHub</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/results.css') }}">
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
                <h1><i class="fas fa-chart-bar" aria-hidden="true"></i> Election Results</h1>
                
            </header>

            @forelse ($results as $result)
                <section class="election-card" aria-labelledby="election-{{ $result['election']->id }}-heading">
                    <div class="election-header">
                        <i class="fas fa-vote-yea" aria-hidden="true"></i>
                        <h2 id="election-{{ $result['election']->id }}-heading">{{ $result['election']->title }}</h2>
                        <span class="badge bg-{{ $result['election']->scope === 'department' ? 'info' : 'primary' }}">
                            {{ ucfirst($result['election']->scope) }}
                        </span>
                    </div>
                    <div class="election-body">
                        @if ($result['candidates']->isEmpty())
                            <div class="no-results">
                                <i class="fas fa-info-circle" aria-hidden="true"></i>
                                <h3>No Results Available</h3>
                                <p>Election results will be published after voting concludes.</p>
                            </div>
                        @else
                            <table class="results-table" aria-describedby="election-{{ $result['election']->id }}-heading">
                                <thead>
                                    <tr>
                                        <th scope="col">Candidate</th>
                                        <th scope="col">Course</th>
                                        <th scope="col">Faculty</th>
                                        <th scope="col">Policies</th>
                                        <th scope="col">Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result['candidates'] as $candidateData)
                                        @php
                                            $candidate = $candidateData['candidate'];
                                            $student = $candidateData['student'];
                                            $votes = $candidateData['votes'];
                                            $isWinner = ($votes === $result['candidates']->max('votes') && $votes > 0);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="candidate-info">
                                                    <div class="candidate-avatar">
                                                        @if ($candidate->image)
                                                            <img src="{{ asset('storage/' . $candidate->image) }}" alt="{{ $student->name }} avatar" class="avatar-img">
                                                        @else
                                                            <i class="fas fa-user" aria-hidden="true"></i>
                                                        @endif
                                                    </div>
                                                    <div class="candidate-details">
                                                        <div class="candidate-name">{{ $student->name ?? 'N/A' }}</div>
                                                        <div class="candidate-id">{{ $student->registration_number ?? 'N/A' }}</div>
                                                        @if ($isWinner)
                                                            <span class="winner-badge">Winner</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $student->course->name ?? 'N/A' }}</td>
                                            <td>{{ $student->faculty->name ?? 'N/A' }}</td>
                                            <td class="policies">{!! nl2br(e($candidate->policies ?? 'No policies provided')) !!}</td>
                                            <td class="vote-count">{{ $votes }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </section>
            @empty
                <div class="no-results">
                    <i class="fas fa-calendar-times" aria-hidden="true"></i>
                    <h3>No Elections Found</h3>
                    <p>Check back later for election results.</p>
                </div>
            @endforelse
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