@extends('layouts.app')

@section('title', $product->name . ' - Detail Produk')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('pembeli.products.index') }}">Katalog Produk</a></li>
        <li class="active">{{ $product->name }}</li>
    </ul>

    <div class="row g-4 align-items-start">
        <!-- Product Thumbnail & Media -->
        <div class="col-12 col-lg-5">
            <div class="card card-clean p-2">
                <div class="rounded-3 overflow-hidden bg-light position-relative" style="min-height: 340px; max-height: 440px;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}" style="max-height: 440px;">
                    @else
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center p-5 text-muted" style="min-height: 340px;">
                            <i class="bi bi-controller text-muted" style="font-size: 5rem; opacity: 0.4;"></i>
                            <p class="small text-muted mt-2 mb-0">Cover Gambar Tidak Tersedia</p>
                        </div>
                    @endif

                    @if($product->label)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge-subtle {{ $product->label === 'game' ? 'badge-subtle-primary' : 'badge-subtle-success' }} px-3 py-2 shadow-sm">
                                <i class="bi {{ $product->label === 'game' ? 'bi-controller' : 'bi-phone' }}"></i>
                                {{ ucfirst($product->label) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Trust Badges -->
                <div class="p-3 mt-2 bg-light rounded-3">
                    <div class="row g-2 text-center text-muted small">
                        <div class="col-4 border-end">
                            <i class="bi bi-shield-check text-success d-block fs-5 mb-1"></i>
                            <span class="fw-semibold text-dark d-block">100% Aman</span>
                            <span class="text-xs">Terverifikasi</span>
                        </div>
                        <div class="col-4 border-end">
                            <i class="bi bi-clock-history text-primary d-block fs-5 mb-1"></i>
                            <span class="fw-semibold text-dark d-block">7 Hari</span>
                            <span class="text-xs">Durasi Sewa</span>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-lightning-charge text-warning d-block fs-5 mb-1"></i>
                            <span class="fw-semibold text-dark d-block">Instan</span>
                            <span class="text-xs">Aktivasi Link</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details & Rent Action -->
        <div class="col-12 col-lg-7">
            <div class="card card-clean p-4 p-md-5">
                <div class="mb-3">
                    @if($product->label)
                        <span class="text-uppercase text-muted fw-bold fs-7 tracking-wider d-block mb-1">
                            Kategori {{ $product->label }}
                        </span>
                    @endif
                    <h2 class="fw-bold mb-2 text-dark">{{ $product->name }}</h2>
                </div>

                <!-- Price Banner -->
                <div class="p-3 p-md-4 rounded-3 mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background-color: var(--sg-primary-light); border: 1px solid rgba(79, 70, 229, 0.15);">
                    <div>
                        <small class="text-muted d-block fw-semibold">Biaya Sewa Mingguan</small>
                        <div class="d-flex align-items-baseline gap-2">
                            <span class="fs-2 fw-bold text-dark">Rp {{ number_format($product->rental_price, 0, ',', '.') }}</span>
                            <span class="text-muted fw-semibold">/ 7 Hari</span>
                        </div>
                    </div>
                    <span class="badge-subtle badge-subtle-primary px-3 py-2">
                        <i class="bi bi-tag-fill me-1"></i> Harga Terbaik
                    </span>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h6 class="fw-bold text-uppercase fs-7 text-muted tracking-wider mb-2">Deskripsi Produk</h6>
                    <div class="text-secondary small" style="line-height: 1.8; white-space: pre-line;">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Product Specifications / Features -->
                <div class="mb-4 pb-3 border-bottom">
                    <h6 class="fw-bold text-uppercase fs-7 text-muted tracking-wider mb-3">Keuntungan Sewa di Sini</h6>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small text-secondary">
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success fs-6"></i>
                            <span>Akses langsung ke repository / download link resmi.</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success fs-6"></i>
                            <span>Bebas main selama 7 hari kalender penuh setelah konfirmasi.</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success fs-6"></i>
                            <span>Dukungan teknis dan panduan instalasi jika mengalami kendala.</span>
                        </li>
                    </ul>
                </div>

                <!-- Form Action -->
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ route('pembeli.products.index') }}" class="btn btn-light-custom order-2 order-sm-1">
                        <i class="bi bi-arrow-left"></i> Kembali ke Katalog
                    </a>
                    <form action="{{ route('pembeli.cart.store', $product) }}" method="POST" class="flex-grow-1 order-1 order-sm-2">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-2 fs-6">
                            <i class="bi bi-cart-plus-fill me-1"></i> Tambah ke Keranjang Sewa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
