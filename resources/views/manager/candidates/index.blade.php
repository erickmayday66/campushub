<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Candidate List | CampusHub</title>
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

        /* Success alert */
        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            padding: 12px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: background-color var(--transition-speed), color var(--transition-speed);
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

        .table img {
            border-radius: 5px;
            object-fit: cover;
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

        .btn-success {
            background: var(--success-color);
            color: white;
            border: none;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-warning {
            background: var(--warning-color);
            color: white;
            border: none;
        }

        .btn-warning:hover {
            background: #e76f51;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.9rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .pagination a {
            color: var(--primary-color);
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: var(--gray-100);
            border-color: var(--primary-color);
        }

        [data-theme="dark"] .pagination a:hover {
            background: var(--gray-200);
        }

        .pagination .active a {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
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

            .btn-success {
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
            <li><a href="{{ route('manager.candidates.index') }}" class="active"><i class="fas fa-users"></i> Candidates</a></li>
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
    <div class="container">
        <div class="header">
            <h3><i class="fas fa-users"></i> Candidates List</h3>
            <a href="{{ route('manager.candidates.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Add Candidate
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reg No.</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Election</th>
                            <th>Image</th>
                            <th>Policies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $index => $candidate)
                            <tr>
                                <td>{{ $index + $candidates->firstItem() }}</td>
                                <td>{{ $candidate->student_regno }}</td>
                                <td>{{ $candidate->student->name ?? 'N/A' }}</td>
                                <td>{{ $candidate->student->course->name ?? 'N/A' }}</td>
                                <td>{{ $candidate->student->course->faculty->name ?? 'N/A' }}</td>
                                <td>{{ $candidate->election->title ?? 'N/A' }}</td>
                                <td>
                                    @if($candidate->image)
                                        <img src="{{ asset('storage/' . $candidate->image) }}" alt="Candidate Image" width="50" height="50">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($candidate->policies, 50) }}</td>
                                <td>
                                    <a href="{{ route('manager.candidates.edit', $candidate->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('manager.candidates.destroy', $candidate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this candidate?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No candidates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination">
            {{ $candidates->links() }}
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