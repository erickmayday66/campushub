<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin & Manager Login | CampusHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link href="{{ asset('css/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/student/login.css') }}" rel="stylesheet">
</head>
<body class="admin-login-bg">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4" style="max-width: 450px; width: 100%;">
            
            <div class="text-center mb-4">
                <!-- Logo Placeholder -->
                <img src="{{ asset('images/logo.png') }}" alt="CampusHub Logo" style="max-height: 70px;">
                <h3 class="mt-2 text-primary">Admin / Manager Login</h3>
                <p class="text-muted small">Access the control panel</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary rounded-pill">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Only admin and election managers may access this panel.</small>
            </div>
        </div>
    </div>

    <!-- Optional JS -->
    <script src="{{ asset('css/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
