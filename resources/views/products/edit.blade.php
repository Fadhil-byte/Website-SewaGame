@extends('layouts.app')

@section('title', 'Edit Produk #' . $product->id . ' - Admin')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.products.index') }}">Produk</a></li>
        <li class="active">Edit Produk #{{ $product->id }}</li>
    </ul>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card card-clean p-4 p-md-5">
                <div class="mb-4 pb-3 border-bottom">
                    <h3 class="fw-bold mb-1">Perbarui Produk</h3>
                    <p class="text-muted small mb-0">Edit informasi inventaris game atau aplikasi <strong>{{ $product->name }}</strong>.</p>
                </div>

                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk / Game <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
                        @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="label" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="label" name="label" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="game" @selected(old('label', $product->label) === 'game')>Game PC</option>
                                <option value="android" @selected(old('label', $product->label) === 'android')>Android Apps</option>
                            </select>
                            @error('label')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="rental_price" class="form-label">Harga Sewa / 7 Hari (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" class="form-control border-start-0 ps-0" id="rental_price" name="rental_price" min="0" step="1000" required value="{{ old('rental_price', $product->rental_price) }}">
                            </div>
                            @error('rental_price')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <label for="github_link" class="form-label">Link GitHub (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-github"></i></span>
                                <input type="text" class="form-control" id="github_link" name="github_link" placeholder="https://github.com/..." value="{{ old('github_link', $product->github_link) }}">
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">Disalin otomatis ke pelanggan setelah diverifikasi</small>
                            @error('github_link')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="itchio_link" class="form-label">Link Itch.io (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" class="form-control" id="itchio_link" name="itchio_link" placeholder="https://user.itch.io/..." value="{{ old('itchio_link', $product->itchio_link) }}">
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">Link halaman store / build file</small>
                            @error('itchio_link')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Gambar Sampul / Cover</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg,image/jpg,image/webp">
                        <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        @error('image')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror

                        @if($product->image)
                            <div class="mt-3 p-2 bg-light rounded-3 d-inline-flex align-items-center gap-3 border">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="height: 60px; width: 60px; object-fit: cover; border-radius: 8px;">
                                <small class="text-muted">Gambar sampul aktif saat ini</small>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-arrow-repeat me-1"></i> Perbarui Produk
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light-custom px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
