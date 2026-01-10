<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">CampusHub Admin</span>
        
        <!-- User Profile with Logout -->
        <div class="user-actions">
            <div class="user-badge">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span>{{ Auth::user()->name }}</span>
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
            <div class="avatar-large">
                <i class="fas fa-user-shield"></i>
            </div>
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->role ?? 'System Administrator' }}</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-user-cog"></i> User Management</a></li>
            <li><a href="{{ route('admin.students.index') }}"><i class="fas fa-users"></i> Student Management</a></li>
            <li><a href="{{ route('admin.results.index') }}"><i class="fas fa-poll"></i> Election Results</a></li>
            <li><a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a></li>
            <li><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a></li>
            <li><a href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
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
            <h1>Admin Dashboard</h1>
            <p>Welcome back, {{ Auth::user()->name }}! Here's an overview of system-wide activities and administrative controls. 
            You have {{ $unreadCount ?? 0 }} new notifications and 12 pending tasks.</p>
        </div>

        <!-- Stats Overview -->
        <div class="stats-container">
            <a href="{{ route('admin.users.index') }}" class="stat-card-link" style="text-decoration: none; color: inherit;">
                <div class="stat-card">
                    <div class="value">{{ number_format($totalUsers) }} <span class="trend up">+12%</span></div>
                    <div class="label"><i class="fas fa-users"></i> Total Users</div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </a>

            <a href="{{ route('admin.students.index') }}" class="stat-card-link" style="text-decoration: none; color: inherit;">
                <div class="stat-card">
                    <div class="value">{{ number_format($activeStudents) }} <span class="trend up">+5%</span></div>
                    <div class="label"><i class="fas fa-user-graduate"></i> Active Students</div>
                    <div class="icon"><i class="fas fa-user-graduate"></i></div>
                </div>
            </a>

            <div class="stat-card">
                <div class="value">{{ $activeElections }} <span class="trend down">-2</span></div>
                <div class="label"><i class="fas fa-vote-yea"></i> Active Elections</div>
                <div class="icon"><i class="fas fa-vote-yea"></i></div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="section-title">
                <i class="fas fa-bolt"></i> Quick Actions
            </div>
            <div class="quick-actions-grid">
                <a href="#" class="quick-action" id="open-add-entry">
                    <i class="fas fa-user-plus"></i>
                    <span>Add New User</span>
                </a>

                <a href="#" class="quick-action">
                    <i class="fas fa-file-export"></i>
                    <span>Export Reports</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="quick-action">
                    <i class="fas fa-cog"></i>
                    <span>System Settings</span>
                </a>
                <a href="#" class="quick-action">
                    <i class="fas fa-shield-alt"></i>
                    <span>Security Logs</span>
                </a>
            </div>
        </div>

        <!-- Modal (hidden by default) -->
        <div id="add-entry-modal" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
            <div style="background: #fff; padding: 30px; border-radius: 10px; width: 300px; text-align: center; position: relative;">
                <h3>Add New Entry</h3>
                <p>What do you want to add?</p>
                <a href="{{ route('admin.users.create') }}" style="display:block; margin: 10px 0; padding: 10px; background-color:#007bff; color:#fff; border-radius:5px; text-decoration:none;">Add New User</a>
                <a href="{{ route('admin.students.create') }}" style="display:block; margin: 10px 0; padding: 10px; background-color:#28a745; color:#fff; border-radius:5px; text-decoration:none;">Add New Student</a>
                <button id="close-add-entry" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:20px; cursor:pointer;">×</button>
            </div>
        </div>

        <div class="dashboard-grid">
            <div>
                <div class="section-title">
                    <i class="fas fa-th-large"></i> Administration Modules
                </div>

                <!-- Action Cards Grid -->
                <div class="action-grid">
                    <a href="{{ route('admin.users.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-user-cog"></i>
                            <span class="badge">{{ number_format($totalUsers) }} Users</span>
                        </div>
                        <div class="action-content">
                            <h3>User Management</h3>
                            <p>Manage all system users, roles, permissions, and access controls</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.students.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-users"></i>
                            <span class="badge">{{ number_format($activeStudents) }} Students</span>
                        </div>
                        <div class="action-content">
                            <h3>Student Management</h3>
                            <p>Manage student accounts, enrollment, and academic information</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.results.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-poll"></i>
                            <span class="badge">{{ number_format($resultCount) }} Results</span>
                        </div>
                        <div class="action-content">
                            <h3>Election Results</h3>
                            <p>View, analyze, and export election results and voting statistics</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.faculties.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-university"></i>
                            <span class="badge">{{ number_format($facultyCount) }} Faculties</span>
                        </div>
                        <div class="action-content">
                            <h3>Faculty Management</h3>
                            <p>Manage university faculties, departments, and organizational structure</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <div>
                <!-- Recent Activity -->
                <div class="section-title" style="margin-top:30px; font-size:1.25rem; font-weight:600; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-list" style="color:#16a085;"></i> Recent Activity
                </div>

                <div class="analytics-card" style="margin-top:15px; padding:20px; background:#fff; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
                    <ul class="activity-feed" style="list-style:none; padding:0; margin:0;">
                        @foreach($recentActivities as $activity)
                        <li class="activity-item" style="display:flex; gap:12px; align-items:flex-start; margin-bottom:15px;">
                            <div class="activity-icon" style="min-width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px; background: {{ $activity->color }};">
                                <i class="fas {{ $activity->icon }}"></i>
                            </div>
                            <div class="activity-content">
                                <p style="margin:0;">{{ $activity->message }}</p>
                                <div class="activity-time" style="font-size:0.85rem; ">{{ $activity->timeAgo }}</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            const isSidebarOpen = sidebar.classList.contains('open');
            const isClickInsideSidebar = sidebar.contains(e.target);
            const isClickOnToggleBtn = toggleBtn.contains(e.target);
            
            if (isSidebarOpen && !isClickInsideSidebar && !isClickOnToggleBtn) {
                sidebar.classList.remove('open');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Dark Theme Toggle
        const darkThemeToggle = document.getElementById('darkThemeToggle');
        const body = document.body;

        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-theme');
            darkThemeToggle.checked = true;
        }

        darkThemeToggle.addEventListener('change', () => {
            if (darkThemeToggle.checked) {
                body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            }
        });

        // Modal Scripts
        const openBtn = document.getElementById('open-add-entry');
        const modal = document.getElementById('add-entry-modal');
        const closeBtn = document.getElementById('close-add-entry');

        if (openBtn) {
            openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                modal.style.display = 'flex';
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        
    </script>
    <script>
        // Get modal and buttons
        const addEntryModal = document.getElementById('add-entry-modal');
        const openAddEntryBtn = document.getElementById('open-add-entry');
        const closeAddEntryBtn = document.getElementById('close-add-entry');

        // Open modal
        openAddEntryBtn.addEventListener('click', function(e) {
            e.preventDefault(); // prevent default link behavior
            addEntryModal.style.display = 'flex';
        });

        // Close modal
        closeAddEntryBtn.addEventListener('click', function() {
            addEntryModal.style.display = 'none';
        });

        // Close modal if click outside the modal content
        addEntryModal.addEventListener('click', function(e) {
            if (e.target === addEntryModal) {
                addEntryModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>