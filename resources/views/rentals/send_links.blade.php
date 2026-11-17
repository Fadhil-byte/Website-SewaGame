@extends('layouts.app')

@section('title', 'Kirim Link Akses #' . $rental->id . ' - Admin')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.rentals.index') }}">Peminjaman</a></li>
        <li class="active">Kirim Link #{{ $rental->id }}</li>
    </ul>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card card-clean p-4 p-md-5">
                <div class="mb-4 pb-3 border-bottom">
                    <span class="badge-subtle badge-subtle-primary mb-2">Aktivasi Peminjaman</span>
                    <h3 class="fw-bold mb-1">Kirim Link Akses Pelanggan</h3>
                    <p class="text-muted small mb-0">Masukkan tautan unduhan repositori resmi untuk pelanggan <strong>{{ $rental->user->name }}</strong>.</p>
                </div>

                <!-- Rental Snapshot -->
                <div class="p-3 rounded-3 bg-light mb-4">
                    <div class="row g-2 small">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Produk:</span>
                            <strong class="text-dark">{{ $rental->product->name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Penerima:</span>
                            <strong class="text-dark">{{ $rental->user->name }}</strong> ({{ $rental->user->email }})
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Masa Aktif:</span>
                            <strong class="text-primary">{{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M Y') }}</strong>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.rentals.sendLinks', $rental) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="github_link" class="form-label">Link Akses GitHub</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-github"></i></span>
                            <input type="text" class="form-control" id="github_link" name="github_link" placeholder="https://github.com/..." value="{{ old('github_link', $rental->github_link) }}">
                        </div>
                        @error('github_link')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="itchio_link" class="form-label">Link Akses Itch.io</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg"></i></span>
                            <input type="text" class="form-control" id="itchio_link" name="itchio_link" placeholder="https://username.itch.io/..." value="{{ old('itchio_link', $rental->itchio_link) }}">
                        </div>
                        @error('itchio_link')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="alert alert-dismissible fade show p-3 mb-4 border-0" style="background-color: #fffbeb; color: #b45309; border-radius: 12px;">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Setelah form ini disimpan, status peminjaman otomatis berubah menjadi <strong>Aktif</strong> dan pelanggan dapat langsung melihat tautan unduhan di dashboard mereka.
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send-fill me-1"></i> Kirim & Aktifkan Sewa
                        </button>
                        <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-light-custom px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
