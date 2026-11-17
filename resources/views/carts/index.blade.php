@extends('layouts.app')

@section('title', 'Keranjang Belanja - SewaGame')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('pembeli.products.index') }}">Katalog</a></li>
        <li class="active">Keranjang Belanja</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Keranjang Sewa Game</h3>
            <p class="text-muted small mb-0">Kelola daftar item yang ingin Anda pinjam sebelum melanjutkan checkout.</p>
        </div>
        <a href="{{ route('pembeli.products.index') }}" class="btn btn-light-custom btn-sm d-none d-sm-inline-flex">
            <i class="bi bi-arrow-left"></i> Tambah Produk Lain
        </a>
    </div>

    @if($carts->count() > 0)
        @php $total = 0; @endphp
        <div class="row g-4">
            <!-- Cart Items List -->
            <div class="col-12 col-lg-8">
                <div class="table-clean-wrapper">
                    <div class="table-responsive">
                        <table class="table table-clean">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Durasi Sewa</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                    @php $total += $cart->product->rental_price; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-2 overflow-hidden bg-light flex-shrink-0" style="width: 60px; height: 60px;">
                                                    @if($cart->product->image)
                                                        <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $cart->product->name }}">
                                                    @else
                                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                            <i class="bi bi-controller fs-4 opacity-50"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-truncate" style="max-width: 280px;">
                                                    <a href="{{ route('pembeli.products.show', $cart->product) }}" class="fw-bold text-dark text-truncate d-block">
                                                        {{ $cart->product->name }}
                                                    </a>
                                                    @if($cart->product->label)
                                                        <span class="badge-subtle {{ $cart->product->label === 'game' ? 'badge-subtle-primary' : 'badge-subtle-success' }} py-0 px-2 mt-1" style="font-size: 0.7rem;">
                                                            {{ ucfirst($cart->product->label) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-subtle badge-subtle-dark">
                                                <i class="bi bi-clock-history"></i> 7 Hari
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold text-dark">
                                            Rp {{ number_format($cart->product->rental_price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('pembeli.carts.destroy', $cart) }}" method="POST"
                                                  onsubmit="return confirm('Hapus produk ini dari keranjang belanja?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-custom text-danger border-0 p-2" title="Hapus dari keranjang">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3 d-sm-none">
                    <a href="{{ route('pembeli.products.index') }}" class="btn btn-light-custom w-100 btn-sm">
                        <i class="bi bi-arrow-left"></i> Tambah Produk Lain
                    </a>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-12 col-lg-4">
                <div class="card card-clean p-4 sticky-top" style="top: 96px;">
                    <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>

                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Total Item</span>
                        <span class="fw-semibold text-dark">{{ $carts->count() }} Produk</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Durasi Sewa</span>
                        <span class="fw-semibold text-dark">7 Hari (1 Minggu)</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-3">
                        <span>Biaya Platform</span>
                        <span class="badge-subtle badge-subtle-success">Gratis</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="fw-bold text-dark">Total Biaya</span>
                        <div class="text-end">
                            <span class="fs-4 fw-bold text-dark">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Termasuk pajak & biaya admin</small>
                        </div>
                    </div>

                    <a href="{{ route('pembeli.checkout.index') }}" class="btn btn-primary w-100 py-2 fs-6 mb-2">
                        <i class="bi bi-credit-card-2-front me-1"></i> Lanjut ke Checkout
                    </a>

                    <div class="text-center">
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="bi bi-shield-lock-fill text-success me-1"></i> Transaksi terenkripsi & terpercaya
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-box">
            <div class="empty-state-icon">
                <i class="bi bi-bag-x"></i>
            </div>
            <h4 class="fw-bold mb-2">Keranjang Anda Masih Kosong</h4>
            <p class="text-muted small mb-4" style="max-width: 420px; margin: 0 auto;">
                Anda belum menambahkan game atau aplikasi apa pun ke dalam keranjang belanja.
            </p>
            <a href="{{ route('pembeli.products.index') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-grid-fill me-1"></i> Jelajahi Katalog Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
