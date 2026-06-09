@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.rentals.index') }}">Peminjaman</a></li>
            <li class="breadcrumb-item active">#{{ $rental->id }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title mb-3">Peminjaman #{{ $rental->id }}</h2>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Peminjam:</strong><br>
                            {{ $rental->user->name }}
                            <br><small class="text-muted">{{ $rental->user->email }}</small>
                        </div>
                        <div class="col-md-6">
                            <strong>Produk:</strong><br>
                            {{ $rental->product->name }}
                        </div>
                    </div>

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

                    @if($rental->status === 'active' && ($rental->github_link || $rental->itchio_link))
                        <hr>
                        <h5><i class="bi bi-link-45deg"></i> Link yang Diberikan</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @if($rental->github_link)
                                <a href="{{ $rental->github_link }}" target="_blank" class="btn btn-dark">
                                    <i class="bi bi-github"></i> GitHub
                                </a>
                            @endif
                            @if($rental->itchio_link)
                                <a href="{{ $rental->itchio_link }}" target="_blank" class="btn btn-outline-secondary">
                                    <i class="bi bi-link-45deg"></i> Itch.io
                                </a>
                            @endif
                        </div>
                    @endif

                    <hr>

                    @if($rental->status === 'pending')
                        <a href="{{ route('admin.rentals.sendLinksForm', $rental) }}" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Konfirmasi & Kirim Link
                        </a>
                        <form method="POST" action="{{ route('admin.rentals.reject', $rental) }}" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Tolak / Expired
                            </button>
                        </form>
                    @elseif($rental->status === 'active')
                        <form method="POST" action="{{ route('admin.rentals.expire', $rental) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-clock-history"></i> Tandai Expired
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary float-end">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
