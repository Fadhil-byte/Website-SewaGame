@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3">
        <div class="input-group" style="max-width: 300px;">
            <input type="text" class="form-control" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">
                    <i class="bi bi-x"></i>
                </a>
            @endif
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Label</th>
                    <th>Harga Sewa</th>
                    <th>GitHub</th>
                    <th>Itch.io</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>#{{ $product->id }}</td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</small>
                        </td>
                        <td>
                            @if($product->label)
                                <span class="badge bg-info">{{ ucfirst($product->label) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($product->rental_price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->github_link)
                                <a href="{{ $product->github_link }}" target="_blank" class="btn btn-sm btn-dark"><i class="bi bi-github"></i></a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($product->itchio_link)
                                <a href="{{ $product->itchio_link }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-link-45deg"></i></a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
