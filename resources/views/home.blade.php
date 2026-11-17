@extends('layouts.app')

@section('title', 'SewaGame - Rental Game PC & Android Premium')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Hero Banner -->
    <div class="hero-banner mb-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7 position-relative z-1">
                <span class="badge-subtle badge-subtle-primary text-white border-0 bg-white bg-opacity-10 px-3 py-2 mb-3">
                    <i class="bi bi-stars text-warning"></i> Platform Rental Game & App No. 1
                </span>
                <h1 class="hero-title mb-3">
                    Sewa Game PC & Android Premium <br class="d-none d-md-block">
                    <span style="background: linear-gradient(135deg, #a5b4fc, #38bdf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Hemat & Tanpa Ribet</span>
                </h1>
                <p class="text-slate-300 fs-5 mb-4 text-white text-opacity-75" style="max-width: 540px; font-weight: 400; line-height: 1.6;">
                    Akses ratusan game original dan aplikasi Android tanpa perlu membeli lisensi permanen yang mahal. Cukup sewa mingguan, unduh, dan langsung main!
                </p>
                
                <div class="d-flex flex-wrap gap-3">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-boxes"></i> Kelola Katalog Produk
                            </a>
                            <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-light px-4 py-2">
                                <i class="bi bi-calendar-check"></i> Data Peminjaman
                            </a>
                        @else
                            <a href="{{ route('pembeli.products.index') }}" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-grid-fill"></i> Jelajahi Katalog Produk
                            </a>
                            <a href="{{ route('pembeli.rentals.index') }}" class="btn btn-outline-light px-4 py-2">
                                <i class="bi bi-clock-history"></i> Riwayat Sewa Saya
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-lightning-charge-fill"></i> Mulai Sewa Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light px-4 py-2">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk Akun
                        </a>
                    @endauth
                </div>

                <div class="d-flex flex-wrap gap-4 mt-4 pt-3 border-top border-white border-opacity-10 text-white text-opacity-75 small">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i> Aktivasi Cepat
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i> Akun / Link Resmi
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i> Dukungan Admin 24/7
                    </div>
                </div>
            </div>

            <div class="col-lg-5 text-center d-none d-lg-block position-relative z-1">
                <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <i class="bi bi-controller text-white" style="font-size: 8rem; opacity: 0.9; filter: drop-shadow(0 20px 30px rgba(79, 70, 229, 0.4));"></i>
                    <div class="mt-3">
                        <h5 class="text-white fw-bold mb-1">Instant Access & Cloud Sync</h5>
                        <p class="text-white text-opacity-50 small mb-0">Nikmati game favorit dengan performa maksimal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Pillars -->
    <div class="row g-3 g-md-4 mb-5">
        <div class="col-12 col-md-4">
            <div class="card card-clean card-hover h-100 p-4">
                <div class="stat-icon-wrapper stat-icon-primary mb-3">
                    <i class="bi bi-controller"></i>
                </div>
                <h5 class="fw-bold mb-2">Katalog Game Lengkap</h5>
                <p class="text-muted small mb-0">
                    Mulai dari game petualangan, aksi, hingga simulasi. Nikmati pengalaman bermain game AAA dan indie ternama dengan harga sangat terjangkau.
                </p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-clean card-hover h-100 p-4">
                <div class="stat-icon-wrapper stat-icon-success mb-3">
                    <i class="bi bi-phone"></i>
                </div>
                <h5 class="fw-bold mb-2">Aplikasi Android Premium</h5>
                <p class="text-muted small mb-0">
                    Kebutuhan tools produktivitas, editing, dan utilitas Android tersedia siap pakai tanpa hambatan iklan atau fitur terkunci.
                </p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-clean card-hover h-100 p-4">
                <div class="stat-icon-wrapper stat-icon-warning mb-3">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h5 class="fw-bold mb-2">Aman, Legal & Terpercaya</h5>
                <p class="text-muted small mb-0">
                    Proses peminjaman transparan. Link unduh langsung diverifikasi admin dan dapat diakses dengan mudah selama masa aktif sewa berlangsung.
                </p>
            </div>
        </div>
    </div>

    <!-- Featured Products Showcase (Live from DB) -->
    @php
        try {
            $featuredProducts = \Illuminate\Support\Facades\Schema::hasTable('products')
                ? \App\Models\Product::latest()->take(3)->get()
                : collect();
        } catch (\Throwable $e) {
            $featuredProducts = collect();
        }
    @endphp
    @if($featuredProducts->count() > 0)
        <div class="mb-5">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Produk Unggulan Pilihan</h3>
                    <p class="text-muted small mb-0">Pilihan game dan aplikasi paling populer yang siap Anda sewa hari ini.</p>
                </div>
                @auth
                    @if(Auth::user()->role === 'pembeli')
                        <a href="{{ route('pembeli.products.index') }}" class="btn btn-outline-primary btn-sm align-self-start align-self-sm-auto">
                            Lihat Semua Produk <i class="bi bi-arrow-right"></i>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm align-self-start align-self-sm-auto">
                        Lihat Semua Produk <i class="bi bi-arrow-right"></i>
                    </a>
                @endauth
            </div>

            <div class="row g-3 g-md-4 row-cols-1 row-cols-sm-2 row-cols-lg-3">
                @foreach($featuredProducts as $item)
                    <div class="col">
                        <div class="product-card h-100">
                            <div class="product-thumb-wrapper">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="product-thumb-img" alt="{{ $item->name }}">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light text-muted">
                                        <i class="bi bi-controller fs-1 opacity-50"></i>
                                        <small class="mt-1">SewaGame Preview</small>
                                    </div>
                                @endif

                                @if($item->label)
                                    <div class="product-badge-overlay">
                                        <span class="badge-subtle {{ $item->label === 'game' ? 'badge-subtle-primary' : 'badge-subtle-success' }}">
                                            <i class="bi {{ $item->label === 'game' ? 'bi-controller' : 'bi-phone' }}"></i>
                                            {{ ucfirst($item->label) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body p-3 p-md-4 d-flex flex-column">
                                <h5 class="fw-bold mb-2 text-truncate" title="{{ $item->name }}">{{ $item->name }}</h5>
                                <p class="text-muted small flex-grow-1 mb-3" style="line-height: 1.6;">
                                    {{ \Illuminate\Support\Str::limit($item->description, 75) }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <span class="product-price-tag">Rp {{ number_format($item->rental_price, 0, ',', '.') }}</span>
                                        <span class="product-price-duration">/ 7 hari</span>
                                    </div>
                                    @auth
                                        @if(Auth::user()->role === 'pembeli')
                                            <a href="{{ route('pembeli.products.show', $item) }}" class="btn btn-primary btn-sm px-3">
                                                Detail
                                            </a>
                                        @else
                                            <a href="{{ route('admin.products.edit', $item) }}" class="btn btn-outline-primary btn-sm px-3">
                                                Edit
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3">
                                            Sewa
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- How It Works Section -->
    <div class="card card-clean p-4 p-md-5 mb-5 bg-white">
        <div class="text-center mb-5">
            <span class="badge-subtle badge-subtle-primary mb-2">Panduan Mudah</span>
            <h3 class="fw-bold mb-2">Bagaimana Cara Kerjanya?</h3>
            <p class="text-muted small mb-0" style="max-width: 500px; margin: 0 auto;">
                Proses penyewaan di SewaGame sangat mudah, cepat, dan otomatis dalam 4 langkah simpel.
            </p>
        </div>

        <div class="row g-4 position-relative">
            <div class="col-12 col-sm-6 col-lg-3 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-primary bg-opacity-10 text-primary fw-bold fs-4" style="width: 56px; height: 56px;">
                    1
                </div>
                <h6 class="fw-bold mb-1">Pilih Produk</h6>
                <p class="text-muted small mb-0">Temukan game PC atau aplikasi Android idaman di katalog kami.</p>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-primary bg-opacity-10 text-primary fw-bold fs-4" style="width: 56px; height: 56px;">
                    2
                </div>
                <h6 class="fw-bold mb-1">Masukkan Keranjang</h6>
                <p class="text-muted small mb-0">Kumpulkan semua item yang ingin disewa ke dalam keranjang belanja.</p>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-primary bg-opacity-10 text-primary fw-bold fs-4" style="width: 56px; height: 56px;">
                    3
                </div>
                <h6 class="fw-bold mb-1">Checkout & Konfirmasi</h6>
                <p class="text-muted small mb-0">Lakukan konfirmasi peminjaman dengan rincian biaya yang transparan.</p>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-primary bg-opacity-10 text-primary fw-bold fs-4" style="width: 56px; height: 56px;">
                    4
                </div>
                <h6 class="fw-bold mb-1">Terima Link Akses</h6>
                <p class="text-muted small mb-0">Link akses GitHub / Itch.io langsung aktif dan siap Anda mainkan.</p>
            </div>
        </div>
    </div>

    <!-- Ready to Start CTA -->
    <div class="rounded-4 p-4 p-md-5 text-center text-white" style="background: linear-gradient(135deg, #1e1b4b, #312e81); border: 1px solid rgba(255,255,255,0.1);">
        <h3 class="fw-bold mb-2">Siap Bermain Game Favorit Anda?</h3>
        <p class="text-slate-300 small mb-4" style="max-width: 460px; margin: 0 auto; line-height: 1.6;">
            Daftar sekarang dan nikmati sensasi gaming tanpa batas dengan harga sewa yang ramah di kantong.
        </p>
        @auth
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.products.index') : route('pembeli.products.index') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-grid-fill"></i> Mulai Eksplorasi
            </a>
        @else
            <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-person-plus-fill"></i> Buat Akun Gratis
            </a>
        @endauth
    </div>
</div>
@endsection
