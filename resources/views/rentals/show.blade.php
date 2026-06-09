@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pembeli.rentals.index') }}">Peminjaman</a></li>
            <li class="breadcrumb-item active">{{ $rental->product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title mb-3">{{ $rental->product->name }}</h2>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Mulai:</strong><br>
                            {{ \Carbon\Carbon::parse($rental->start_date)->format('d F Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Selesai:</strong><br>
                            {{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        @if($rental->status === 'active')
                            <span class="badge bg-success fs-6">Aktif</span>
                        @elseif($rental->status === 'expired')
                            <span class="badge bg-danger fs-6">Expired</span>
                        @else
                            <span class="badge bg-warning text-dark fs-6">Pending</span>
                        @endif

                        @if($rental->payment_status === 'paid')
                            <span class="badge bg-success fs-6">Lunas</span>
                        @else
                            <span class="badge bg-secondary fs-6">Dikembalikan</span>
                        @endif
                    </div>

                    @if($rental->status === 'active' && !$rental->is_expired)
                        <hr>
                        <h5><i class="bi bi-download"></i> Link Download/Akses</h5>
                        <p class="text-muted">Akses aktif sampai {{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}</p>

                        <div class="d-flex flex-wrap gap-2">
                            @if($rental->github_link !== null && $rental->github_link !== '')
                                <a href="{{ $rental->github_link }}" target="_blank" class="btn btn-dark">
                                    <i class="bi bi-github"></i> GitHub
                                </a>
                            @endif

                            @if($rental->itchio_link !== null && $rental->itchio_link !== '')
                                <a href="{{ $rental->itchio_link }}" target="_blank" class="btn btn-outline-secondary">
                                    <i class="bi bi-link-45deg"></i> Itch.io
                                </a>
                            @endif
                        </div>
                    @elseif($rental->status === 'pending')
                        <hr>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Menunggu konfirmasi admin. Link akan tersedia setelah pembayaran dikonfirmasi.
                        </div>
                    @else
                        <hr>
                        <div class="alert alert-danger">
                            <i class="bi bi-lock-fill"></i> Masa sewa sudah berakhir pada
                            {{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}.
                            Link download telah dikunci.
                        </div>
                    @endif

                    <hr>
                    <a href="{{ route('pembeli.rentals.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
