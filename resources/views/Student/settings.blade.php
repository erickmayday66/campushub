<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Student Dashboard | CampusHub</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <button id="toggle-btn" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">Student Dashboard</span>
        
        <!-- User Profile and Logout -->
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
            <!-- Header -->
            <header class="header">
                <h1>Account Settings</h1>
                <p>Manage your preferences and security settings</p>
            </header>

            <!-- Appearance Section -->
            <section class="card" aria-labelledby="appearance-heading">
                <div class="card-header">
                    <i class="fas fa-palette" aria-hidden="true"></i>
                    <h2 id="appearance-heading">Appearance</h2>
                </div>
                <div class="card-body">
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-title">Dark Mode</div>
                            <div class="setting-desc">Switch to dark theme for better visibility in low-light conditions</div>
                        </div>
                        <label class="toggle-switch" for="themeToggle">
                            <input type="checkbox" id="themeToggle" aria-label="Toggle dark mode">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Security Section -->
            <section class="card" aria-labelledby="security-heading">
                <div class="card-header">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <h2 id="security-heading">Security</h2>
                </div>
                <div class="card-body">
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-title">Password</div>
                            <div class="setting-desc">Update your account password for enhanced security</div>
                        </div>
                        <a href="{{ route('student.password.change') }}" class="btn btn-primary" aria-label="Go to change password form">
                            <i class="fas fa-key" aria-hidden="true"></i> Change Password
                        </a>
                    </div>
                </div>
            </section>

            <!-- Notifications Section -->
            <section class="card" aria-labelledby="notifications-heading">
                <div class="card-header">
                    <i class="fas fa-bell" aria-hidden="true"></i>
                    <h2 id="notifications-heading">Notifications</h2>
                </div>
                <div class="card-body">
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-title">Email Notifications</div>
                            <div class="setting-desc">Receive important updates via email</div>
                        </div>
                        <label class="toggle-switch" for="emailToggle">
                            <input type="checkbox" id="emailToggle" checked aria-label="Toggle email notifications">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-title">Push Notifications</div>
                            <div class="setting-desc">Get real-time alerts on your device</div>
                        </div>
                        <label class="toggle-switch" for="pushToggle">
                            <input type="checkbox" id="pushToggle" checked aria-label="Toggle push notifications">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>© {{ date('Y') }} Student Portal. All rights reserved.</p>
        </footer>

        <!-- Notification -->
        <div class="notification" id="notification" role="alert" aria-live="polite">
            <i class="fas fa-check-circle" aria-hidden="true"></i>
            <span>Settings updated successfully!</span>
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
            showNotification('Theme updated successfully!');
        });

        // Notification Functionality
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.querySelector('span').textContent = message;
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Change Password Button
        document.getElementById('changePasswordBtn').addEventListener('click', () => {
            showNotification('Password change initiated. Check your email!');
        });

        // Other Toggle Switches
        document.querySelectorAll('.toggle-switch input:not(#themeToggle)').forEach(switchEl => {
            switchEl.addEventListener('change', () => {
                showNotification('Settings updated successfully!');
            });
        });
    </script>
</body>
</html>