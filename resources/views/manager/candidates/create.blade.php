<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Register Candidate | CampusHub</title>
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
            --table-border: #e9ecef;
            --success-bg: #d4edda;
            --success-text: #155724;
            --transition-speed: 0.3s;
            --border-radius: 10px;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            --primary-color: #4361ee;
            --warning-color: #f8961e;
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
            margin-bottom: 2rem;
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
            max-width: 600px;
            margin: 0 auto;
        }

        .card-body {
            padding: 30px;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: block;
            transition: color var(--transition-speed);
        }

        .form-control, .form-select, .form-file {
            width: 100%;
            padding: 10px 15px;
            font-size: 0.95rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            background: var(--card-bg);
            color: var(--text-color);
            transition: border-color var(--transition-speed), background-color var(--transition-speed), color var(--transition-speed), box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus, .form-file:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .form-control::placeholder {
            color: var(--gray-600);
        }

        .form-control:hover, .form-select:hover, .form-file:hover {
            border-color: var(--primary-color);
        }

        .form-file {
            height: auto;
        }

        .d-none {
            display: none;
        }

        /* Student info */
        .student-info {
            background: var(--gray-100);
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            transition: background-color var(--transition-speed);
        }

        [data-theme="dark"] .student-info {
            background: var(--gray-200);
        }

        .student-info div {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .student-info strong {
            color: var(--text-color);
            font-weight: 500;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
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

        .button-group {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 2rem;
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

            .card {
                max-width: 100%;
            }

            .button-group {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
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
            <h3><i class="fas fa-users"></i> Register Candidate</h3>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('manager.candidates.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="studentSearch" class="form-label">Search Student</label>
                        <input type="text" id="studentSearch" onkeyup="filterStudents()" class="form-control" placeholder="Type student name or reg. number...">
                    </div>

                    <div class="form-group">
                        <label for="studentSelect" class="form-label">Select Student</label>
                        <select id="studentSelect" class="form-select" onchange="fillStudentInfo()">
                            <option value="">-- Select --</option>
                            @foreach ($students as $student)
                                <option 
                                    value="{{ $student->registration_number }}"
                                    data-name="{{ $student->name }}"
                                    data-course="{{ $student->course->name }}"
                                    data-faculty="{{ $student->course->faculty->name }}"
                                    data-course-id="{{ $student->course_id }}"
                                >
                                    {{ $student->name }} ({{ $student->registration_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="student-info" class="student-info d-none">
                        <div><strong>Name:</strong> <span id="student-name"></span></div>
                        <div><strong>Course:</strong> <span id="student-course"></span></div>
                        <div><strong>Faculty:</strong> <span id="student-faculty"></span></div>
                    </div>

                    <input type="hidden" id="student_regno" name="student_regno">
                    <input type="hidden" id="course_id" name="course_id">

                    <div class="form-group">
                        <label for="election_id" class="form-label">Election</label>
                        <select name="election_id" id="election_id" class="form-select" required>
                            <option value="">-- Select Election --</option>
                            @foreach ($elections as $election)
                                <option value="{{ $election->id }}">{{ $election->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="policies" class="form-label">Candidate Policies</label>
                        <textarea name="policies" id="policies" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Candidate Photo (optional)</label>
                        <input type="file" name="image" id="image" class="form-file" accept="image/*">
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Submit Candidate
                        </button>
                    </div>
                </form>
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

    
        // Student search and info display
        function filterStudents() {
            const input = document.getElementById('studentSearch');
            const filter = input.value.toLowerCase();
            const select = document.getElementById('studentSelect');
            const options = select.getElementsByTagName('option');

            for (let i = 0; i < options.length; i++) {
                const text = options[i].textContent || options[i].innerText;
                options[i].style.display = text.toLowerCase().includes(filter) ? '' : 'none';
            }
        }

        function fillStudentInfo() {
            const selectedOption = document.getElementById('studentSelect').selectedOptions[0];
            if (selectedOption && selectedOption.value) {
                document.getElementById('student-name').textContent = selectedOption.dataset.name;
                document.getElementById('student-course').textContent = selectedOption.dataset.course;
                document.getElementById('student-faculty').textContent = selectedOption.dataset.faculty;
                document.getElementById('student_regno').value = selectedOption.value;
                document.getElementById('course_id').value = selectedOption.dataset.courseId;
                document.getElementById('student-info').classList.remove('d-none');
            } else {
                document.getElementById('student-info').classList.add('d-none');
            }
        }

        
    </script>
</body>
</html>