<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('includes/css/style.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">SaaS Platform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('privacy') ? 'active' : '' }}" href="{{ url('/privacy') }}">Privacy</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('terms') ? 'active' : '' }}" href="{{ url('/terms') }}">Terms</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <a class="btn btn-dark rounded-pill px-4 ms-2 " href="{{ route('onboarding.step1.show') }}">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span>&copy; 2025 SaaS Provisioning Platform. All Rights Reserved.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
