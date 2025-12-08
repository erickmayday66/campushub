<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('css/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/student/login.css') }}" rel="stylesheet">
</head>
<body class="student-login-bg">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4" style="max-width: 450px; width: 100%;">
            
            <div class="text-center mb-4">
                <!-- Logo Placeholder -->
                <img src="{{ asset('images/logo.png') }}" alt="CampusHub Logo" style="max-height: 70px;">
                <h3 class="mt-2 text-primary">Student Login</h3>
                <p class="text-muted small">Vote smart. Vote secure.</p>
            </div>

            <form method="POST" action="{{ route('student.login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-id-card"></i> Registration Number</label>
                    <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" placeholder="2023/0001"  required>
                    @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary rounded-pill" type="submit">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Only currently enrolled students are allowed to vote.</small>
            </div>
        </div>
    </div>

    <!-- Optional JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
