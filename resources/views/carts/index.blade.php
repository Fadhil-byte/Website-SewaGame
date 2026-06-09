@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">
        <i class="bi bi-cart3"></i> Keranjang Belanja
    </h2>

    @if($carts->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Produk</th>
                        <th>Harga Sewa (7 hari)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($carts as $cart)
                        @php $total += $cart->product->rental_price; @endphp
                        <tr>
                            <td>
                                <strong>{{ $cart->product->name }}</strong>
                                <br><small class="text-muted">{{ Str::limit($cart->product->description, 80) }}</small>
                            </td>
                            <td>Rp {{ number_format($cart->product->rental_price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <form action="{{ route('pembeli.carts.destroy', $cart) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <th>Total</th>
                        <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('pembeli.products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Lanjut Belanja
            </a>
            <a href="{{ route('pembeli.checkout.index') }}" class="btn btn-success btn-lg">
                <i class="bi bi-check-circle"></i> Lanjut ke Checkout
            </a>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <h4 class="text-muted mt-3">Keranjang Anda kosong</h4>
            <a href="{{ route('pembeli.products.index') }}" class="btn btn-primary mt-3">
                <i class="bi bi-shop"></i> Lihat Produk
            </a>
        </div>
    @endif
</div>

