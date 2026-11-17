<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f172a">
    <title>@yield('title', 'SewaGame - Penyewaan Game PC & Android Premium')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Design System -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Modern Fixed Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-icon-box">
                <i class="bi bi-controller"></i>
            </span>
            <span>Sewa<span>Game</span></span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1 d-lg-none"></i> Beranda
                    </a>
                </li>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                <i class="bi bi-boxes me-1"></i> Kelola Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}" href="{{ route('admin.rentals.index') }}">
                                <i class="bi bi-calendar-check me-1"></i> Data Peminjaman
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pembeli.products.*') ? 'active' : '' }}" href="{{ route('pembeli.products.index') }}">
                                <i class="bi bi-grid me-1 d-lg-none"></i> Katalog Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pembeli.rentals.*') ? 'active' : '' }}" href="{{ route('pembeli.rentals.index') }}">
                                <i class="bi bi-clock-history me-1 d-lg-none"></i> Riwayat Sewa
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-grid me-1 d-lg-none"></i> Katalog Game
                        </a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-lg-center gap-2 pt-2 pt-lg-0">
                @auth
                    @if(Auth::user()->role === 'pembeli')
                        <li class="nav-item me-lg-2">
                            <a class="nav-link d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-white bg-opacity-10 text-white" href="{{ route('pembeli.carts.index') }}">
                                <i class="bi bi-bag"></i>
                                <span>Keranjang</span>
                                @php
                                    $cartCount = auth()->user()->carts()->count();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="cart-pill-badge">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-inline-flex align-items-center gap-2 text-white" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-avatar-circle">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="fw-semibold">{{ Auth::user()->name }}</span>
                            <span class="badge-subtle {{ Auth::user()->role === 'admin' ? 'badge-subtle-warning' : 'badge-subtle-info' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end shadow-lg mt-2">
                            <li class="px-3 py-2 border-bottom mb-1">
                                <small class="text-muted d-block">Login sebagai</small>
                                <strong class="text-truncate d-block" style="max-width: 200px;">{{ Auth::user()->email }}</strong>
                            </li>
                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('pembeli.rentals.index') }}">
                                        <i class="bi bi-clock-history me-2"></i> Riwayat Sewa
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('pembeli.carts.index') }}">
                                        <i class="bi bi-bag me-2"></i> Keranjang
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm w-100" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm w-100" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content Spacing for Fixed Navbar -->
<div style="height: 76px;"></div>

<!-- Notification Alerts -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm" style="background-color: #ecfdf5; color: #065f46; border-radius: 12px;" role="alert">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm" style="background-color: #eff6ff; color: #1e40af; border-radius: 12px;" role="alert">
            <i class="bi bi-info-circle-fill text-primary fs-5"></i>
            <div>{{ session('info') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm" style="background-color: #fff1f2; color: #9f1239; border-radius: 12px;" role="alert">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<!-- Main Content -->
<main class="flex-grow-1">
    @yield('content')
</main>

<!-- Modern Professional Footer -->
<footer class="footer-custom pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-5 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="brand-icon-box">
                        <i class="bi bi-controller"></i>
                    </span>
                    <span class="fs-4 fw-bold text-white">SewaGame</span>
                </div>
                <p class="text-secondary small mb-3" style="max-width: 420px; line-height: 1.7;">
                    Platform terpercaya penyewaan aplikasi game PC dan Android premium. Mainkan koleksi favorit Anda dengan lisensi resmi, aktivasi instan, dan harga paling terjangkau.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="footer-social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="footer-social-icon" aria-label="Discord"><i class="bi bi-discord"></i></a>
                    <a href="#" class="footer-social-icon" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="footer-social-icon" aria-label="GitHub"><i class="bi bi-github"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="text-white mb-3 text-uppercase fs-7 fw-bold tracking-wider">Navigasi</h6>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                    <li><a href="{{ route('home') }}" class="text-secondary hover-text-white">Beranda</a></li>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li><a href="{{ route('admin.products.index') }}" class="text-secondary hover-text-white">Kelola Produk</a></li>
                            <li><a href="{{ route('admin.rentals.index') }}" class="text-secondary hover-text-white">Kelola Peminjaman</a></li>
                        @else
                            <li><a href="{{ route('pembeli.products.index') }}" class="text-secondary hover-text-white">Katalog Produk</a></li>
                            <li><a href="{{ route('pembeli.carts.index') }}" class="text-secondary hover-text-white">Keranjang</a></li>
                            <li><a href="{{ route('pembeli.rentals.index') }}" class="text-secondary hover-text-white">Riwayat Sewa</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="text-secondary hover-text-white">Katalog Game</a></li>
                        <li><a href="{{ route('login') }}" class="text-secondary hover-text-white">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="text-secondary hover-text-white">Daftar Akun</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <h6 class="text-white mb-3 text-uppercase fs-7 fw-bold tracking-wider">Bantuan & Kontak</h6>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small text-secondary">
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope text-primary"></i>
                        <span>support@sewagame.com</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-whatsapp text-success"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock text-warning"></i>
                        <span>Layanan Aktif: 24/7 Online</span>
                    </li>
                </ul>
                <div class="mt-3 p-3 rounded-3" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08);">
                    <small class="text-secondary d-block"><i class="bi bi-shield-check text-success me-1"></i> Garansi Akses Penuh selama masa sewa aktif.</small>
                </div>
            </div>
        </div>

        <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.08);">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small text-secondary">
            <div>&copy; {{ date('Y') }} SewaGame. Seluruh hak cipta dilindungi undang-undang.</div>
            <div class="d-flex gap-3">
                <a href="#" class="text-secondary">Syarat & Ketentuan</a>
                <a href="#" class="text-secondary">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
