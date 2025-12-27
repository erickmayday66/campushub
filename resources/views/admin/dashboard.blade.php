<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #2d3b8e;
            --primary-dark: #1e2a78;
            --primary-light: #4a5ccc;
            --secondary-color: #1a1d2e;
            --accent-color: #3a86ff;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --info-color: #3498db;
            --danger-color: #e74c3c;
            --light-color: #f8fafc;
            --dark-color: #121212;
            --gray-100: #f5f7fa;
            --gray-200: #e4e7eb;
            --gray-300: #cbd2d9;
            --gray-600: #616e7c;
            --gray-800: #323f4b;
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --transition-speed: 0.3s;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --box-shadow-lg: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ===== Navbar ===== */
        .navbar {
            width: 100%;
            height: var(--navbar-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            padding: 0 30px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1100;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.8);
        }

        #toggle-btn {
            font-size: 20px;
            background-color: rgba(45, 59, 142, 0.1);
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            margin-right: 20px;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #toggle-btn:hover {
            background-color: rgba(45, 59, 142, 0.2);
            transform: rotate(90deg);
        }

        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-title::before {
            content: '';
            display: block;
            width: 8px;
            height: 30px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light));
            border-radius: 4px;
        }

        .user-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-badge {
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.3s;
        }

        .notification-badge:hover {
            background: white;
            color: var(--primary-color);
        }

        .notification-badge::after {
            content: '3';
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            background: rgba(45, 59, 142, 0.05);
            padding: 8px 15px 8px 8px;
            border-radius: 30px;
            transition: all 0.3s;
            font-size: 0.95rem;
            border: 1px solid rgba(45, 59, 142, 0.1);
        }

        .user-badge:hover {
            background: rgba(45, 59, 142, 0.1);
        }

        .user-badge .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-logout {
            background: rgba(231, 76, 60, 0.05);
            color: var(--danger-color);
            border: 1px solid rgba(231, 76, 60, 0.1);
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: rgba(231, 76, 60, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.2);
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            transition: transform var(--transition-speed) ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 5px 0 30px rgba(0, 0, 0, 0.05);
            border-right: 1px solid rgba(255, 255, 255, 0.8);
            display: flex;
            flex-direction: column;
            padding-top: var(--navbar-height);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-header {
            text-align: center;
            padding: 30px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.5);
        }

        .avatar-large {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2.2rem;
            color: white;
            font-weight: 600;
            border: 4px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--secondary-color);
        }

        .sidebar-header p {
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar-nav {
            list-style: none;
            padding: 20px 15px;
            flex: 1;
        }

        .sidebar-nav li {
            margin-bottom: 8px;
        }

        .sidebar-nav li a {
            color: var(--gray-600);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 15px;
            border-radius: var(--border-radius);
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
        }

        .sidebar-nav li a:hover {
            background: rgba(45, 59, 142, 0.05);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar-nav li a.active {
            background: linear-gradient(90deg, rgba(45, 59, 142, 0.1) 0%, rgba(45, 59, 142, 0.05) 100%);
            color: var(--primary-color);
            font-weight: 600;
            border-left: 4px solid var(--primary-color);
        }

        .sidebar-nav li a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-nav li a .badge {
            margin-left: auto;
            background: var(--primary-color);
            color: white;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .logout-item {
            padding: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.5);
        }

        .logout-item button {
            width: 100%;
            text-align: left;
            padding: 12px 15px;
            font-weight: 500;
            color: var(--gray-600);
            transition: all 0.3s;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .logout-item button:hover {
            background: rgba(231, 76, 60, 0.05);
            color: #e74c3c;
        }

        /* ===== Main Content ===== */
        .main-content {
            padding: calc(var(--navbar-height) + 30px) 30px 30px;
            margin-left: 0;
            transition: margin-left var(--transition-speed) ease;
            width: 100%;
            min-height: 100vh;
        }

        .sidebar.open ~ .main-content {
            margin-left: var(--sidebar-width);
        }

        .dashboard-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .dashboard-header h1 {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
            font-size: 2rem;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dashboard-header h1::before {
            content: '';
            display: block;
            width: 6px;
            height: 40px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light));
            border-radius: 3px;
        }

        .dashboard-header p {
            color: var(--gray-600);
            font-size: 1.1rem;
            max-width: 700px;
            line-height: 1.7;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-lg);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        }
        
        .stat-card:nth-child(2)::before {
            background: linear-gradient(90deg, var(--success-color), #27ae60);
        }
        
        .stat-card:nth-child(3)::before {
            background: linear-gradient(90deg, var(--warning-color), #e67e22);
        }
        
        .stat-card:nth-child(4)::before {
            background: linear-gradient(90deg, var(--info-color), #2980b9);
        }
        
        .stat-card .value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .stat-card .trend {
            font-size: 0.9rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .trend.up {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }
        
        .trend.down {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }
        
        .stat-card .label {
            font-size: 0.95rem;
            color: var(--gray-600);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .stat-card .icon {
            position: absolute;
            top: 25px;
            right: 25px;
            font-size: 2.5rem;
            color: rgba(0, 0, 0, 0.05);
            z-index: 0;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--primary-color);
            background: rgba(45, 59, 142, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .action-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            text-align: center;
            height: 100%;
            text-decoration: none;
            color: inherit;
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-lg);
        }
        
        .action-icon {
            padding: 30px 20px;
            font-size: 2.5rem;
            color: white;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            position: relative;
        }
        
        .action-content {
            padding: 25px 20px;
            flex-grow: 1;
        }
        
        .action-content h3 {
            margin-bottom: 12px;
            font-weight: 700;
            color: var(--secondary-color);
            font-size: 1.2rem;
        }
        
        .action-content p {
            color: var(--gray-600);
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        /* Color variations for admin-specific cards */
        .action-card:nth-child(1) .action-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        }
        
        .action-card:nth-child(2) .action-icon {
            background: linear-gradient(135deg, var(--success-color), #27ae60);
        }
        
        .action-card:nth-child(3) .action-icon {
            background: linear-gradient(135deg, var(--warning-color), #e67e22);
        }
        
        .action-card:nth-child(4) .action-icon {
            background: linear-gradient(135deg, var(--info-color), #2980b9);
        }
        
        .action-card:nth-child(5) .action-icon {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
        }
        
        .action-card:nth-child(6) .action-icon {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        
        .badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 500;
            backdrop-filter: blur(4px);
        }
        
        /* Analytics Chart */
        .analytics-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        
        /* Activity Feed */
        .activity-feed {
            list-style: none;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-content p {
            margin-bottom: 5px;
            font-size: 0.95rem;
        }
        
        .activity-time {
            font-size: 0.8rem;
            color: var(--gray-600);
        }
        
        /* Quick Actions Section */
        .quick-actions {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .quick-action {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-radius: var(--border-radius);
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.2s;
            text-decoration: none;
            color: var(--gray-800);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        
        .quick-action:hover {
            background: rgba(45, 59, 142, 0.05);
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .quick-action i {
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(45, 59, 142, 0.1);
            border-radius: 10px;
            color: var(--primary-color);
        }
        
        .quick-action span {
            font-weight: 500;
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .action-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .quick-actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: calc(var(--navbar-height) + 20px) 20px 20px;
            }
            
            .user-actions {
                gap: 10px;
            }
            
            .user-badge span {
                display: none;
            }
            
            .logout-text {
                display: none;
            }
            
            .btn-logout {
                padding: 8px 12px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .navbar {
                padding: 0 20px;
            }
            
            .navbar-title {
                font-size: 1.2rem;
            }
            
            .dashboard-header h1 {
                font-size: 1.6rem;
            }
            
            .action-grid {
                grid-template-columns: 1fr;
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
            <li><a href="#"><i class="fas fa-cog"></i> System Settings</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Analytics</a></li>
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
            <a href="#" class="quick-action">
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
            <button id="close-add-entry" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:20px; cursor:pointer;">&times;</button>
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
            <div class="section-title" style="margin-top:30px; font-size:1.25rem; font-weight:600; color:#2c3e50; display:flex; align-items:center; gap:8px;">
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
                            <p style="margin:0; color:#2c3e50;">{{ $activity->message }}</p>
                            <div class="activity-time" style="font-size:0.85rem; color:#7f8c8d;">{{ $activity->timeAgo }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal & Sidebar Scripts -->
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

        // Initialize analytics chart
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        const analyticsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'User Activity',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: '#2d3b8e',
                    backgroundColor: 'rgba(45, 59, 142, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'System Usage',
                    data: [28, 48, 40, 19, 86, 27, 90],
                    borderColor: '#3a86ff',
                    backgroundColor: 'rgba(58, 134, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
    <script>
    const openBtn = document.getElementById('open-add-entry');
    const modal = document.getElementById('add-entry-modal');
    const closeBtn = document.getElementById('close-add-entry');

    openBtn.addEventListener('click', (e) => {
        e.preventDefault();
        modal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if(e.target == modal) {
            modal.style.display = 'none';
        }
    });
</script>


</body>
</html>