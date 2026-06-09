@extends('layouts.app')

@section('title', 'Kirim Link Akses')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.rentals.index') }}">Peminjaman</a></li>
            <li class="breadcrumb-item active">Kirim Link #{{ $rental->id }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-envelope-paper"></i> Kirim Link Akses ke {{ $rental->user->name }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <strong>Produk:</strong> {{ $rental->product->name }}<br>
                        <strong>Peminjam:</strong> {{ $rental->user->name }} ({{ $rental->user->email }})<br>
                        <strong>Masa Aktif:</strong> sampai {{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}
                    </div>

                    <form method="POST" action="{{ route('admin.rentals.sendLinks', $rental) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="github_link" class="form-label">Link GitHub</label>
                            <input type="text" class="form-control" id="github_link" name="github_link" placeholder="https://github.com/..." value="{{ old('github_link', $rental->github_link) }}">
                            @error('github_link')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="itchio_link" class="form-label">Link Itch.io</label>
                            <input type="text" class="form-control" id="itchio_link" name="itchio_link" placeholder="https://username.itch.io/..." value="{{ old('itchio_link', $rental->itchio_link) }}">
                            @error('itchio_link')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            Setelah link dikirim, status peminjaman akan menjadi <strong>Aktif/Lunas</strong> dan link akan terlihat oleh {{ $rental->user->name }}.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-send"></i> Kirim & Aktifkan
                            </button>
                            <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
