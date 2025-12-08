<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | CampusHub</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS -->
    @vite(['resources/css/student/style.css'])
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar">
        <button id="toggle-btn" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-title">Student Dashboard</span>
        
        <!-- User Profile with Logout -->
        
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        
        <ul class="sidebar-nav">
            <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('student.profile') }}" class="active"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="{{ route('student.settings') }}"><i class="fas fa-cogs"></i> Settings</a></li>
            <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-question-circle"></i> Help Center</a></li>
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
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    @vite(['resources/js/script.js'])
    @yield('scripts')
</body>
</html>