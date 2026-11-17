@extends('layouts.app')

@section('title', 'Katalog Produk - SewaGame')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li class="active">Katalog Produk</li>
    </ul>

    <!-- Header & Controls -->
    <div class="card card-clean p-4 mb-4">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-12 col-md-5">
                <h3 class="fw-bold mb-1">Katalog Game & Aplikasi</h3>
                <p class="text-muted small mb-0">Temukan koleksi game dan aplikasi premium siap sewa dengan lisensi resmi.</p>
            </div>

            <!-- Search Form -->
            <div class="col-12 col-md-7 col-lg-6">
                <form class="d-flex gap-2" action="{{ route('pembeli.products.index') }}" method="GET">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input class="form-control border-start-0 ps-0" type="search" name="search" placeholder="Cari judul game atau aplikasi..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('pembeli.products.index', ['category' => request('category')]) }}" class="btn btn-light-custom border-start-0 text-muted" title="Hapus pencarian">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                    <button class="btn btn-primary px-3" type="submit">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        <!-- Category Filters -->
        <div class="d-flex flex-wrap gap-2 pt-3 mt-3 border-top">
            <a href="{{ route('pembeli.products.index', ['search' => request('search')]) }}" 
               class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-light-custom' }} rounded-pill px-3">
                <i class="bi bi-grid-fill"></i> Semua ({{ \App\Models\Product::count() }})
            </a>
            <a href="{{ route('pembeli.products.index', ['category' => 'game', 'search' => request('search')]) }}" 
               class="btn btn-sm {{ request('category') === 'game' ? 'btn-primary' : 'btn-light-custom' }} rounded-pill px-3">
                <i class="bi bi-controller"></i> Game PC
            </a>
            <a href="{{ route('pembeli.products.index', ['category' => 'android', 'search' => request('search')]) }}" 
               class="btn btn-sm {{ request('category') === 'android' ? 'btn-primary' : 'btn-light-custom' }} rounded-pill px-3">
                <i class="bi bi-phone"></i> Android Apps
            </a>
        </div>
    </div>

    <!-- Product Grid -->
    @if($products->count() > 0)
        <div class="row g-3 g-md-4 row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 mb-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="product-card">
                        <div class="product-thumb-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="product-thumb-img" alt="{{ $product->name }}">
                            @else
                                <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light text-muted">
                                    <i class="bi bi-controller fs-1 opacity-50"></i>
                                    <small class="mt-1">SewaGame Preview</small>
                                </div>
                            @endif

                            <div class="product-badge-overlay">
                                @if($product->label)
                                    <span class="badge-subtle {{ $product->label === 'game' ? 'badge-subtle-primary' : 'badge-subtle-success' }}">
                                        <i class="bi {{ $product->label === 'game' ? 'bi-controller' : 'bi-phone' }}"></i>
                                        {{ ucfirst($product->label) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <h5 class="fw-bold mb-1 text-truncate" title="{{ $product->name }}">
                                <a href="{{ route('pembeli.products.show', $product) }}" class="text-dark hover-primary">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            
                            <p class="text-muted small flex-grow-1 mb-3" style="line-height: 1.5;">
                                {{ \Illuminate\Support\Str::limit($product->description, 70) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-baseline mb-3">
                                <div>
                                    <span class="product-price-tag">Rp {{ number_format($product->rental_price, 0, ',', '.') }}</span>
                                    <span class="product-price-duration">/ 7 hari</span>
                                </div>
                                <span class="badge-subtle badge-subtle-dark">
                                    <i class="bi bi-calendar-check"></i> Sewa 1 Minggu
                                </span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('pembeli.products.show', $product) }}" class="btn btn-light-custom btn-sm flex-grow-1">
                                    Detail
                                </a>
                                <form action="{{ route('pembeli.cart.store', $product) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-cart-plus"></i> + Sewa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-box">
            <div class="empty-state-icon">
                <i class="bi bi-search"></i>
            </div>
            <h4 class="fw-bold mb-2">Produk Tidak Ditemukan</h4>
            <p class="text-muted small mb-4" style="max-width: 420px; margin: 0 auto;">
                @if(request('search') || request('category'))
                    Tidak ada produk yang sesuai dengan kriteria filter atau kata kunci "<strong>{{ request('search') }}</strong>".
                @else
                    Belum ada produk yang tersedia saat ini di katalog.
                @endif
            </p>
            <a href="{{ route('pembeli.products.index') }}" class="btn btn-primary btn-sm px-4">
                <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
            </a>
        </div>
    @endif
</div>
@endsection
