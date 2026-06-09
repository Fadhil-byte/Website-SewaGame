@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="p-4 bg-primary text-white rounded-3 hero-section">
                <h1 class="display-4">Selamat Datang di SewaGame</h1>
                <p class="lead">Platform penyewaan aplikasi game dan Android secara online dengan harga terjangkau.</p>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-boxes"></i> Kelola Produk
                    </a>
                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-light btn-lg ms-2">
                        <i class="bi bi-calendar-check"></i> Lihat Peminjaman
                    </a>
                @else
                    <a href="{{ route('pembeli.products.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-grid-3x3-gap-fill"></i> Lihat Produk
                    </a>
                    <a href="{{ route('pembeli.rentals.index') }}" class="btn btn-outline-light btn-lg ms-2">
                        <i class="bi bi-calendar-check"></i> Riwayat Peminjaman
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm feature-card">
                <div class="card-body text-center">
                    <i class="bi bi-controller text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Game Apps</h5>
                    <p class="card-text">Koleksi game premium yang bisa Anda sewa dengan harga terjangkau.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm feature-card">
                <div class="card-body text-center">
                    <i class="bi bi-phone text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Android Apps</h5>
                    <p class="card-text">Aplikasi Android premium untuk kebutuhan harian Anda.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm feature-card">
                <div class="card-body text-center">
                    <i class="bi bi-shield-check text-info" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3">Aman & Terpercaya</h5>
                    <p class="card-text">Proses sewa yang aman dengan pembayaran dan link dikonfirmasi admin.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h2 class="mb-4">Cara Kerja</h2>
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="bg-light rounded-circle step-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <h3 class="mb-0 text-primary">1</h3>
                    </div>
                    <h6>Pilih Produk</h6>
                    <p class="text-muted small">Browse katalog produk dan pilih yang ingin disewa.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="bg-light rounded-circle step-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <h3 class="mb-0 text-primary">2</h3>
                    </div>
                    <h6>Tambah ke Keranjang</h6>
                    <p class="text-muted small">Masukkan produk ke keranjang belanja.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="bg-light rounded-circle step-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <h3 class="mb-0 text-primary">3</h3>
                    </div>
                    <h6>Checkout</h6>
                    <p class="text-muted small">Lakukan konfirmasi peminjaman.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="bg-light rounded-circle step-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <h3 class="mb-0 text-primary">4</h3>
                    </div>
                    <h6>Terima Link</h6>
                    <p class="text-muted small">Link download diberikan setelah admin mengkonfirmasi.</p>
                </div>
            </div>
        </div>
    </div>
</div>

