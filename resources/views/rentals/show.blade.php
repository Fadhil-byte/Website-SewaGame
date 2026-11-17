@extends('layouts.app')

@section('title', 'Detail Peminjaman #' . $rental->id . ' - SewaGame')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('pembeli.rentals.index') }}">Riwayat Peminjaman</a></li>
        <li class="active">Detail #RENT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</li>
    </ul>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card card-clean p-4 p-md-5">
                <!-- Header -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-3 pb-4 mb-4 border-bottom">
                    <div>
                        <span class="badge-subtle badge-subtle-primary mb-2">Peminjaman Game</span>
                        <h3 class="fw-bold mb-1">{{ $rental->product->name }}</h3>
                        <small class="text-muted">Kode Transaksi: #RENT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        @if($rental->status === 'active')
                            <span class="badge-subtle badge-subtle-success fs-7 px-3 py-2">
                                <i class="bi bi-check-circle-fill"></i> Aktif Berjalan
                            </span>
                        @elseif($rental->status === 'expired')
                            <span class="badge-subtle badge-subtle-danger fs-7 px-3 py-2">
                                <i class="bi bi-x-circle-fill"></i> Telah Berakhir
                            </span>
                        @else
                            <span class="badge-subtle badge-subtle-warning fs-7 px-3 py-2">
                                <i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Timeline / Rental Duration -->
                <div class="p-3 rounded-3 bg-light mb-4">
                    <div class="row g-3 text-center">
                        <div class="col-6 border-end">
                            <span class="text-muted small d-block">Tanggal Mulai</span>
                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted small d-block">Tanggal Berakhir</span>
                            <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Access Links Section -->
                @if($rental->status === 'active' && !$rental->is_expired)
                    <div class="p-4 rounded-3 mb-4" style="background-color: var(--sg-primary-light); border: 1px solid rgba(79, 70, 229, 0.2);">
                        <h5 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-unlock-fill text-success"></i> Link Akses & Download Resmi
                        </h5>
                        <p class="text-muted small mb-3">
                            Akses unduhan aktif dan valid sampai dengan <strong>{{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d F Y') }}</strong>.
                        </p>

                        <div class="d-flex flex-wrap gap-2">
                            @if($rental->github_link)
                                <a href="{{ $rental->github_link }}" target="_blank" class="btn btn-dark btn-sm px-3">
                                    <i class="bi bi-github me-1"></i> Buka Repository GitHub
                                </a>
                            @endif

                            @if($rental->itchio_link)
                                <a href="{{ $rental->itchio_link }}" target="_blank" class="btn btn-outline-primary btn-sm px-3 bg-white">
                                    <i class="bi bi-link-45deg me-1"></i> Buka Halaman Itch.io
                                </a>
                            @endif

                            @if(!$rental->github_link && !$rental->itchio_link)
                                <span class="text-muted small">Admin sedang menyiapkan link unduhan Anda. Harap tunggu beberapa saat.</span>
                            @endif
                        </div>
                    </div>
                @elseif($rental->status === 'pending')
                    <div class="alert alert-dismissible fade show p-4 mb-4 border-0" style="background-color: #fffbeb; color: #b45309; border-radius: 12px;">
                        <h6 class="fw-bold mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history fs-5"></i> Menunggu Verifikasi Admin
                        </h6>
                        <p class="small mb-0">
                            Pesanan Anda telah kami terima. Admin sedang memverifikasi pembayaran dan menyiapkan link akses resmi untuk produk <strong>{{ $rental->product->name }}</strong>.
                        </p>
                    </div>
                @else
                    <div class="alert alert-dismissible fade show p-4 mb-4 border-0" style="background-color: #fff1f2; color: #be123c; border-radius: 12px;">
                        <h6 class="fw-bold mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-lock-fill fs-5"></i> Masa Sewa Telah Kedaluwarsa
                        </h6>
                        <p class="small mb-0">
                            Masa aktif sewa produk ini telah berakhir pada {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d F Y') }}. Link download telah otomatis dikunci demi kepatuhan lisensi.
                        </p>
                    </div>
                @endif

                <!-- Product Summary Box -->
                <div class="mb-4">
                    <h6 class="fw-bold text-uppercase fs-7 text-muted tracking-wider mb-2">Tentang Produk</h6>
                    <p class="text-secondary small mb-0" style="line-height: 1.7;">
                        {{ $rental->product->description }}
                    </p>
                </div>

                <!-- Footer Action -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('pembeli.rentals.index') }}" class="btn btn-light-custom btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
                    </a>
                    @if($rental->is_expired)
                        <a href="{{ route('pembeli.products.show', $rental->product) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-arrow-clockwise"></i> Sewa Ulang Produk
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
