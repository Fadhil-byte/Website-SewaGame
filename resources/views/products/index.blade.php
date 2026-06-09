@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-grid-3x3-gap-fill"></i> Katalog Produk</h2>
        <form class="d-flex" action="{{ route('pembeli.products.index') }}" method="GET">
            <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
            <button class="btn btn-primary btn-sm" type="submit">
                <i class="bi bi-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('pembeli.products.index') }}" class="btn btn-outline-secondary btn-sm ms-1">
                    <i class="bi bi-x"></i>
                </a>
            @endif
        </form>
    </div>

    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm border-0 product-card" style="cursor: pointer;" onclick="window.location='{{ route('pembeli.products.show', $product) }}'">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="bi bi-box-seam fs-1 text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                            @if($product->label)
                                <span class="badge bg-info mb-2 align-self-start">{{ ucfirst($product->label) }}</span>
                            @endif
                            <p class="card-text text-muted small flex-grow-1">
                                {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                            </p>
                            <div class="mb-2">
                                <span class="badge bg-danger fs-6">
                                     Rp {{ number_format($product->rental_price, 0, ',', '.') }}
                                </span>
                                <small class="text-muted">/minggu</small>
                            </div>
                            <form action="{{ route('pembeli.cart.store', $product) }}" method="POST" onclick="event.stopPropagation();">
                                @csrf
                                <button class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i> Sewa 7 Hari
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <h4 class="text-muted mt-3">Belum ada produk tersedia</h4>
        </div>
    @endif
</div>

