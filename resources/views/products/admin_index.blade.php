@extends('layouts.app')

@section('title', 'Manajemen Produk - Admin')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="active">Kelola Produk</li>
    </ul>

    <!-- Header Actions -->
    <div class="card card-clean p-4 mb-4">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-12 col-md-6">
                <h3 class="fw-bold mb-1">Katalog Produk Game & App</h3>
                <p class="text-muted small mb-0">Kelola daftar seluruh inventaris game dan aplikasi yang disewakan ke pelanggan.</p>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
                </a>
            </div>
        </div>

        <hr class="my-3">

        <!-- Search Bar -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2">
            <div class="col-12 col-sm-6 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" name="search" placeholder="Cari nama produk..." value="{{ request('search') }}">
                    @if(request('search'))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light-custom border-start-0 text-muted">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-light-custom" type="submit">Cari</button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="table-clean-wrapper mb-4">
        <div class="table-responsive">
            <table class="table table-clean">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Kategori</th>
                        <th>Harga Sewa</th>
                        <th>Akses Link</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <span class="fw-bold text-muted small">#{{ $product->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-2 overflow-hidden bg-light flex-shrink-0" style="width: 50px; height: 50px;">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                <i class="bi bi-controller opacity-50"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-truncate" style="max-width: 260px;">
                                        <strong class="text-dark d-block text-truncate">{{ $product->name }}</strong>
                                        <small class="text-muted text-truncate d-block">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->label)
                                    <span class="badge-subtle {{ $product->label === 'game' ? 'badge-subtle-primary' : 'badge-subtle-success' }}">
                                        <i class="bi {{ $product->label === 'game' ? 'bi-controller' : 'bi-phone' }}"></i>
                                        {{ ucfirst($product->label) }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark">Rp {{ number_format($product->rental_price, 0, ',', '.') }}</strong>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">/ 7 hari</small>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if($product->github_link)
                                        <a href="{{ $product->github_link }}" target="_blank" class="btn btn-sm btn-light-custom text-dark p-1 px-2" title="GitHub: {{ $product->github_link }}">
                                            <i class="bi bi-github"></i>
                                        </a>
                                    @endif
                                    @if($product->itchio_link)
                                        <a href="{{ $product->itchio_link }}" target="_blank" class="btn btn-sm btn-light-custom text-dark p-1 px-2" title="Itch.io: {{ $product->itchio_link }}">
                                            <i class="bi bi-link-45deg"></i>
                                        </a>
                                    @endif
                                    @if(!$product->github_link && !$product->itchio_link)
                                        <span class="text-muted small">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light-custom px-2" title="Edit Produk">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light-custom text-danger px-2" title="Hapus Produk">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 opacity-50 d-block mb-2"></i>
                                Belum ada data produk yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
