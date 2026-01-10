<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management | CampusHub Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/admin/student_index.css') }}">


</head>
<body>

    <!-- Navbar & Sidebar -->
    <nav class="navbar">
        <button id="toggle-btn"><i class="fas fa-bars"></i></button>
        <span class="navbar-title">CampusHub Admin</span>
        <div class="user-actions">
            <div class="user-badge">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i><span class="logout-text">Logout</span></button>
            </form>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="avatar-large"><i class="fas fa-user-shield"></i></div>
            <h2>{{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->role ?? 'Administrator' }}</p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-user-cog"></i> User Management</a></li>
            <li><a href="{{ route('admin.students.index') }}" class="active"><i class="fas fa-users"></i> Student Management</a></li>
            <li><a href="{{ route('admin.results.index') }}"><i class="fas fa-poll"></i> Election Results</a></li>
            <li><a href="{{ route('admin.faculties.index') }}"><i class="fas fa-university"></i> Faculty Management</a></li>
            <li><a href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i> Course Management</a></li>
        </ul>
        <div class="logout-item">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <div class="dashboard-header">
            <h1>Student Management</h1>
            <p>Manage all registered students across courses and faculties.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <!-- Import Card -->
        <div class="card" style="border-left: 5px solid var(--success-color);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
                <h5 style="margin:0; color:var(--secondary-color);">Import Students from Excel</h5>
                <div style="width:50px; height:50px; background:rgba(46,204,113,0.1); color:var(--success-color); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                    <i class="fas fa-file-excel"></i>
                </div>
            </div>
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display:flex; gap:15px; align-items:end; flex-wrap:wrap;">
                    <div style="flex:1; min-width:280px;">
                        <label class="form-label fw-semibold">Excel File</label>
                        <input type="file" name="file" accept=".xlsx,.xls" class="form-control" required
                               style="padding:14px; border:2px dashed #cbd5e1; border-radius:12px; background:rgba(255,255,255,0.8);">
                        <small class="text-muted">.xlsx, .xls • Max 10MB</small>
                    </div>
                    <button type="submit" class="btn btn-success px-4 py-3 rounded-pill" style="font-weight:600;">
                        <i class="fas fa-file-import me-2"></i> Import
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Search by name, registration number, course or faculty..." autocomplete="off">
            <i class="fas fa-search search-icon"></i>
            <div class="search-results-count" id="resultsCount">Showing <strong>{{ $students->count() }}</strong> students</div>
        </div>

        <!-- Students Table -->
        <div class="card">
            <div style="overflow-x:auto;">
                <table id="studentsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Reg. Number</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Joined</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($students as $student)
                            <tr data-search="{{ strtolower($student->name . ' ' . $student->registration_number . ' ' . ($student->course->name ?? '') . ' ' . ($student->course->faculty->name ?? '')) }}">
                                <td><strong>{{ $student->name }}</strong></td>
                                <td>{{ $student->registration_number }}</td>
                                <td>{{ $student->course->name ?? '—' }}</td>
                                <td>{{ $student->course->faculty->name ?? '—' }}</td>
                                <td>{{ $student->created_at->format('d M Y') }}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning" style="margin-right:8px;">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete {{ $student->name }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr id="noResults" class="no-results">
                                <td colspan="6"><i class="fas fa-users"></i><br>No students found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FAB -->
    <a href="{{ route('admin.students.create') }}" class="fab">
        <i class="fas fa-plus"></i>
        <span class="tooltip-text">Add Student</span>
    </a>

    <script>
        // Sidebar toggle
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));

        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') sidebar.classList.remove('open'); });

        // Live search
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#studentsTable tbody tr[data-search]');
        const resultsCount = document.getElementById('resultsCount');
        const noResultsRow = document.getElementById('noResults');

        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();
            let visible = 0;

            tableRows.forEach(row => {
                const text = row.getAttribute('data-search');
                if (term === '' || text.includes(term)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            resultsCount.innerHTML = `Showing <strong>${visible}</strong> student${visible !== 1 ? 's' : ''}`;
            noResultsRow.style.display = visible === 0 ? '' : 'none';
        });

        // === DARK THEME AUTO-DETECTION & PERSISTENCE ===
        const body = document.body;

        if (localStorage.getItem('theme') === 'dark' || 
           (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            body.classList.add('dark-theme');
        }

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                if (e.matches) {
                    body.classList.add('dark-theme');
                } else {
                    body.classList.remove('dark-theme');
                }
            }
        });
    </script>
</body>
</html>