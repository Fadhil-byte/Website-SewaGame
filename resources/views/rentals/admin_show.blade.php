@extends('layouts.app')

@section('title', 'Detail Peminjaman #' . $rental->id . ' - Admin')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.rentals.index') }}">Data Peminjaman</a></li>
        <li class="active">Detail #RENT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</li>
    </ul>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card card-clean p-4 p-md-5">
                <!-- Header -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-3 pb-4 mb-4 border-bottom">
                    <div>
                        <span class="badge-subtle badge-subtle-primary mb-2">Data Transaksi Pelanggan</span>
                        <h3 class="fw-bold mb-1">Peminjaman #RENT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</h3>
                        <small class="text-muted">Produk yang disewa: <strong>{{ $rental->product->name }}</strong></small>
                    </div>
                    <div class="d-flex gap-2">
                        @if($rental->status === 'active')
                            <span class="badge-subtle badge-subtle-success fs-7 px-3 py-2">Aktif</span>
                        @elseif($rental->status === 'expired')
                            <span class="badge-subtle badge-subtle-danger fs-7 px-3 py-2">Expired</span>
                        @else
                            <span class="badge-subtle badge-subtle-warning fs-7 px-3 py-2">Pending Konfirmasi</span>
                        @endif

                        @if($rental->payment_status === 'paid')
                            <span class="badge-subtle badge-subtle-success fs-7 px-3 py-2">Lunas</span>
                        @else
                            <span class="badge-subtle badge-subtle-dark fs-7 px-3 py-2">Belum Lunas</span>
                        @endif
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <span class="text-muted small d-block mb-1">Informasi Pelanggan</span>
                            <strong class="text-dark d-block">{{ $rental->user->name }}</strong>
                            <span class="small text-muted">{{ $rental->user->email }}</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <span class="text-muted small d-block mb-1">Masa Sewa (7 Hari)</span>
                            <strong class="text-dark d-block">Mulai: {{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d F Y') }}</strong>
                            <span class="small text-primary">Berakhir: {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Active Links Preview -->
                @if($rental->status === 'active' && ($rental->github_link || $rental->itchio_link))
                    <div class="p-4 rounded-3 mb-4" style="background-color: var(--sg-primary-light); border: 1px solid rgba(79, 70, 229, 0.2);">
                        <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-link-45deg fs-5"></i> Link Akses yang Diberikan ke Pelanggan
                        </h6>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            @if($rental->github_link)
                                <a href="{{ $rental->github_link }}" target="_blank" class="btn btn-dark btn-sm px-3">
                                    <i class="bi bi-github me-1"></i> Buka GitHub
                                </a>
                            @endif
                            @if($rental->itchio_link)
                                <a href="{{ $rental->itchio_link }}" target="_blank" class="btn btn-outline-primary btn-sm px-3 bg-white">
                                    <i class="bi bi-link-45deg me-1"></i> Buka Itch.io
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Admin Action Buttons -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-3 border-top">
                    <div class="d-flex flex-wrap gap-2">
                        @if($rental->status === 'pending')
                            <a href="{{ route('admin.rentals.sendLinksForm', $rental) }}" class="btn btn-primary btn-sm px-3">
                                <i class="bi bi-send-fill me-1"></i> Konfirmasi & Kirim Link
                            </a>
                            <form method="POST" action="{{ route('admin.rentals.reject', $rental) }}" class="d-inline"
                                  onsubmit="return confirm('Tolak peminjaman ini?')">
                                @csrf
                                <button type="submit" class="btn btn-light-custom text-danger btn-sm px-3">
                                    <i class="bi bi-x-circle me-1"></i> Tolak Sewa
                                </button>
                            </form>
                        @elseif($rental->status === 'active')
                            <form method="POST" action="{{ route('admin.rentals.expire', $rental) }}" class="d-inline"
                                  onsubmit="return confirm('Tandai masa sewa peminjaman ini sebagai expired?')">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm text-dark px-3">
                                    <i class="bi bi-clock-history me-1"></i> Tandai Expired Sekarang
                                </button>
                            </form>
                        @endif
                    </div>

                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-light-custom btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Data Peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
