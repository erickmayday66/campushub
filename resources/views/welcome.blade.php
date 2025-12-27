<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusHub | University Voting Portal</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.min.css') }}">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #5c7cfa;
            --secondary: #3a50d4;
            --accent: #4cc9f0;
            --light: #f8fafc;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --shadow: rgba(99, 99, 99, 0.1);
            --success: #10b981;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f0f4f8, #e2e8f0);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            line-height: 1.5;
        }
        
        .container {
            width: 100%;
            max-width: 420px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(30deg);
            pointer-events: none;
        }
        
        .logo {
            position: relative;
            z-index: 2;
            margin-bottom: 15px;
        }
        
        .logo i {
            font-size: 2.5rem;
            background: rgba(255, 255, 255, 0.15);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 15px;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .tagline {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
            max-width: 320px;
            margin: 0 auto;
        }
        
        .content {
            padding: 30px;
        }
        
        .login-options {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .login-card {
            display: flex;
            align-items: center;
            background: var(--card-bg);
            border-radius: 12px;
            padding: 18px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: var(--text);
            box-shadow: 0 3px 10px var(--shadow);
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.15);
            border-color: var(--primary-light);
        }
        
        .login-card:hover::before {
            transform: scaleY(1);
        }
        
        .login-card i {
            font-size: 1.6rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-right: 15px;
            color: white;
        }
        
        .student i {
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }
        
        .admin i {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
        }
        
        .card-content {
            flex: 1;
        }
        
        .card-content h3 {
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: var(--text);
            font-weight: 600;
        }
        
        .card-content p {
            font-size: 0.85rem;
            color: var(--text-light);
        }
        
        .arrow {
            font-size: 1.1rem;
            color: var(--text-light);
            transition: all 0.3s ease;
        }
        
        .login-card:hover .arrow {
            color: var(--primary);
            transform: translateX(3px);
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }
        
        .feature {
            background: var(--light);
            border-radius: 10px;
            padding: 15px 10px;
            text-align: center;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        
        .feature:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.1);
            border-color: var(--primary-light);
        }
        
        .feature i {
            font-size: 1.4rem;
            color: var(--primary);
            margin-bottom: 10px;
            background: rgba(67, 97, 238, 0.1);
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        
        .feature h4 {
            font-size: 0.8rem;
            margin-bottom: 5px;
            color: var(--text);
            font-weight: 600;
        }
        
        .feature p {
            font-size: 0.7rem;
            color: var(--text-light);
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            background: var(--light);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            border: 1px solid var(--border);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 0.8rem;
            color: var(--text-light);
        }
        
        .university {
            font-weight: 600;
            color: var(--primary);
            margin-top: 5px;
        }
        
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
            }
            
            .header {
                padding: 20px 15px;
            }
            
            .content {
                padding: 20px;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-vote-yea"></i>
                <h1>CampusHub</h1>
                <p class="tagline">Secure • Transparent • Student-Driven</p>
            </div>
        </div>
        
        <div class="content">
            <div class="login-options">
                <a href="{{ route('student.login') }}" class="login-card student">
                    <i class="fas fa-user-graduate"></i>
                    <div class="card-content">
                        <h3>Student Portal</h3>
                        <p>Cast your vote and participate in elections</p>
                    </div>
                    <div class="arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('login') }}" class="login-card admin">
                    <i class="fas fa-user-shield"></i>
                    <div class="card-content">
                        <h3>Administrator Portal</h3>
                        <p>Manage elections and monitor results</p>
                    </div>
                    <div class="arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </div>
            
            </div>
            
            <footer>
                <p>CampusHub Voting System © 2025</p>
                <p class="university">St. John's University of Tanzania</p>
            </footer>
        </div>
    </div>
</body>
</html>