@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="mb-4">Edit Produk</h2>

                    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="rental_price" class="form-label">Harga Sewa (Rp)</label>
                            <input type="number" class="form-control" id="rental_price" name="rental_price" min="0" step="100" required value="{{ old('rental_price', $product->rental_price) }}">
                            @error('rental_price')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="label" class="form-label">Kategori</label>
                            <select class="form-select" id="label" name="label">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="android" @selected(old('label', $product->label) === 'android')>Android</option>
                                <option value="game" @selected(old('label', $product->label) === 'game')>Game</option>
                            </select>
                            @error('label')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="github_link" class="form-label">Link GitHub (opsional)</label>
                            <input type="text" class="form-control" id="github_link" name="github_link" placeholder="https://github.com/..." value="{{ old('github_link', $product->github_link) }}">
                            <small class="text-muted">Link ini akan disalin ke rental saat pembayaran dikonfirmasi admin</small>
                            @error('github_link')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="itchio_link" class="form-label">Link Itch.io (opsional)</label>
                            <input type="text" class="form-control" id="itchio_link" name="itchio_link" placeholder="https://username.itch.io/..." value="{{ old('itchio_link', $product->itchio_link) }}">
                            <small class="text-muted">Link ini akan disalin ke rental saat pembayaran dikonfirmasi admin</small>
                            @error('itchio_link')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp">
                            @error('image')<small class="text-danger">{{ $message }}</small>@enderror

                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-height: 150px;" class="border rounded">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

