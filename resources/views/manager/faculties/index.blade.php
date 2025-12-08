<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Manage Faculties | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manager/style.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Light theme variables (matching dashboard) */
            --background: #f5f7fb;
            --card-bg: #ffffff;
            --text-color: #343a40;
            --table-header-bg: #f8f9fa;
            --table-border: #e9ecef;
            --success-bg: #d4edda;
            --success-text: #155724;
            --transition-speed: 0.3s;
            --border-radius: 10px;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            --primary-color: #4361ee;
            --warning-color: #f8961e;
            --danger-color: #e74c3c;
            --success-color: #28a745;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --sidebar-width: 260px;
            --navbar-height: 70px;
        }

        [data-theme="dark"] {
            /* Dark theme variables */
            --background: #1a1d29;
            --card-bg: #242731;
            --text-color: #e0e0e0;
            --table-header-bg: #2c303a;
            --table-border: #373b47;
            --success-bg: #2d7a62;
            --success-text: #e0e0e0;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            --gray-100: #2c303a;
            --gray-200: #373b47;
            --gray-300: #4a4f5c;
            --gray-600: #adb5bd;
        }

        body {
            background-color: var(--background);
            color: var(--text-color);
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        /* Main content container */
        .container {
            padding: calc(var(--navbar-height) + 30px) 30px 30px 30px;
            width: 100%;
            min-height: 100vh;
            transition: padding-left var(--transition-speed) ease;
        }

        .sidebar.open ~ .container {
            padding-left: calc(var(--sidebar-width) + 30px);
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            transition: color var(--transition-speed);
        }

        .header h3 i {
            color: var(--warning-color);
            margin-right: 8px;
        }

        /* Card */
        .card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid var(--table-border);
            transition: background-color var(--transition-speed), border-color var(--transition-speed);
        }

        .card-body {
            padding: 25px;
        }

        /* Table */
        .table {
            width: 100%;
            color: var(--text-color);
            transition: color var(--transition-speed);
        }

        .table thead {
            background: var(--table-header-bg);
            color: var(--gray-600);
            transition: background-color var(--transition-speed);
        }

        .table th, .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid var(--table-border);
            transition: border-color var(--transition-speed);
        }

        .table tbody tr:hover {
            background: var(--gray-100);
        }

        [data-theme="dark"] .table tbody tr:hover {
            background: var(--gray-200);
        }

        .table .text-muted {
            color: var(--gray-600);
        }

        /* Buttons */
        .btn {
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #3b55d1;
        }

        .btn-outline-secondary {
            background: transparent;
            color: var(--gray-600);
            border: 1px solid var(--gray-300);
        }

        .btn-outline-secondary:hover {
            background: var(--gray-100);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-danger {
            background: transparent;
            color: var(--danger-color);
            border: 1px solid var(--danger-color);
        }

        .btn-outline-danger:hover {
            background: var(--danger-color);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .container {
                padding: calc(var(--navbar-height) + 20px) 20px 20px 20px;
            }

            .sidebar.open ~ .container {
                padding-left: calc(var(--sidebar-width) + 20px);
            }
        }

        @media (max-width: 576px) {
            .header h3 {
                font-size: 1.3rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .btn-primary {
                width: 100%;
                justify-content: center;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table th, .table td {
                font-size: 0.85rem;
                padding: 8px 10px;
            }
        }
    </style>
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
            <li><a href="{{ route('manager.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('manager.elections.index') }}"><i class="fas fa-vote-yea"></i> Elections</a></li>
            <li><a href="{{ route('manager.candidates.index') }}"><i class="fas fa-users"></i> Candidates</a></li>
            <li><a href="{{ route('manager.faculties.index') }}" class="active"><i class="fas fa-university"></i> Faculties</a></li>
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
    <div class="container">
        <div class="header">
            <h3><i class="fas fa-university"></i> Faculties</h3>
            <a href="{{ route('manager.faculties.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Add Faculty
            </a>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faculties as $index => $faculty)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $faculty->name }}</td>
                                <td>{{ $faculty->code }}</td>
                                <td>{{ $faculty->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('manager.faculties.edit', $faculty->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('manager.faculties.destroy', $faculty->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No faculties found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const container = document.querySelector('.container');
        const navbar = document.querySelector('.navbar');

        // Toggle sidebar visibility
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            // Update container padding based on sidebar state
            if (sidebar.classList.contains('open')) {
                container.style.paddingLeft = `calc(var(--sidebar-width) + 30px)`;
            } else {
                container.style.paddingLeft = '30px';
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

        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        themeToggle.innerHTML = `<i class="fas fa-${savedTheme === 'light' ? 'moon' : 'sun'}"></i>`;
    </script>
</body>
</html>