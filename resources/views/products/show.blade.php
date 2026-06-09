@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pembeli.products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card shadow border-0">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 380px; object-fit: cover; border-radius: 0.375rem 0.375rem 0 0;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 380px; border-radius: 0.375rem 0.375rem 0 0;">
                        <div class="text-center text-muted">
                            <i class="bi bi-image fs-1"></i>
                            <p class="mb-0 mt-2">Tidak ada gambar</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow border-0 h-100">
                <div class="card-body p-4">
                    <h2 class="card-title mb-3">{{ $product->name }}</h2>

                    @if($product->label)
                        <span class="badge bg-info mb-3">{{ ucfirst($product->label) }}</span>
                    @endif

                    <hr>

                    <h6 class="text-muted text-uppercase mb-2">Deskripsi</h6>
                    <p class="text-muted lh-base">{{ $product->description }}</p>

                    <hr>

                    <span class="badge bg-danger fs-5 px-4 py-2 mb-3">
                        Rp {{ number_format($product->rental_price, 0, ',', '.') }} / 7 hari
                    </span>

                    <form action="{{ route('pembeli.cart.store', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
