<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SewaGame - Penyewaan Aplikasi Game & Android')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 pt-5 bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-controller"></i> SewaGame
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">
                                <i class="bi bi-boxes"></i> Kelola Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.rentals.index') }}">
                                <i class="bi bi-calendar-check"></i> Peminjaman
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pembeli.products.index') }}">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('pembeli.carts.index') }}">
                                <i class="bi bi-cart3"></i> Cart
                                @php
                                    $cartCount = auth()->user()->carts()->count();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pembeli.rentals.index') }}">
                                <i class="bi bi-calendar-check"></i> Peminjaman
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                            <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'warning' : 'info' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-sm me-2 mt-1" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm mt-1" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-0 mb-3" role="alert">
        <div class="container">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show m-0 mb-3" role="alert">
        <div class="container">{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<main class="flex-grow-1">
     @yield('content')
 </main>

<footer class="bg-dark text-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>SewaGame - Penyewaan Aplikasi Game & Android</h5>
                <p class="mb-0">Platform penyewaan aplikasi game dan Android secara online dengan harga terjangkau.</p>
            </div>
            <div class="col-md-3">
                <h6>Kontak</h6>
                <ul class="list-unstyled mb-0">
                    <li><i class="bi bi-envelope"></i> support@sewagame.com</li>
                    <li><i class="bi bi-whatsapp"></i> +62 812-3456-7890</li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Ikuti Kami</h6>
                <div class="d-flex gap-2">
                    <a href="#" class="text-light"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-youtube fs-5"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-3">
        <div class="text-center">
            <small>&copy; {{ date('Y') }} SewaGame. All Rights Reserved.</small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

