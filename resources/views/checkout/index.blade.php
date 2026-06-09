@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-credit-card"></i> Konfirmasi Peminjaman</h2>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Detail Peminjaman</h5>
                </div>
                <div class="card-body">
                    <div class="table-responszive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($carts as $cart)
                                    @php $total += $cart->product->rental_price; @endphp
                                    <tr>
                                        <td>{{ $cart->product->name }}</td>
                                        <td class="text-end">
                                            Rp {{ number_format($cart->product->rental_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <th>Total</th>
                                    <th class="text-end">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-muted text-end">
                                        <small>Durasi: 7 hari (mulai dari tanggal konfirmasi)</small>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <form action="{{ route('pembeli.checkout.process') }}" method="POST">
                        @csrf
                        @foreach($carts as $cart)
                            <input type="hidden" name="cart_ids[]" value="{{ $cart->id }}">
                        @endforeach

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Perhatian:</strong> Setelah konfirmasi, link download akan aktif selama 7 hari.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pembeli.carts.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Konfirmasi peminjaman?')">
                                <i class="bi bi-check-circle"></i> Konfirmasi & Bayar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

