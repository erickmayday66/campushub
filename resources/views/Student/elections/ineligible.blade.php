<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting Not Allowed | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="alert-box">
            <i class="fas fa-ban icon"></i>
            <h2>Voting Not Allowed</h2>
            <p>
                You are no longer eligible to vote. According to your course duration, your voting period has ended.
            </p>
            <a href="{{ route('student.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </a>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('student.logout') }}" style="margin-top: 15px;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
