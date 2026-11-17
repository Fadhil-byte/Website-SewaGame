@extends('layouts.app')

@section('title', 'Konfirmasi Checkout - SewaGame')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('pembeli.carts.index') }}">Keranjang</a></li>
        <li class="active">Checkout & Pembayaran</li>
    </ul>

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Konfirmasi Peminjaman</h3>
        <p class="text-muted small mb-0">Tinjau pesanan Anda dan pilih metode pembayaran untuk menyelesaikan proses sewa.</p>
    </div>

    @php $total = 0; @endphp
    @foreach($carts as $c)
        @php $total += $c->product->rental_price; @endphp
    @endforeach

    <form id="checkoutForm" action="{{ route('pembeli.checkout.process') }}" method="POST">
        @csrf
        @foreach($carts as $cart)
            <input type="hidden" name="cart_ids[]" value="{{ $cart->id }}">
        @endforeach

        <div class="row g-4">
            <!-- Left Column: User details & Payment Method -->
            <div class="col-12 col-lg-7">
                <!-- User Account Info Card -->
                <div class="card card-clean p-4 mb-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-person-check text-primary"></i> Data Peminjam
                    </h5>
                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Nama Lengkap</span>
                            <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Alamat Email</span>
                            <span class="fw-semibold text-dark">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Tanggal Mulai Sewa</span>
                            <span class="fw-semibold text-dark">{{ now()->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">Tanggal Berakhir</span>
                            <span class="fw-semibold text-dark text-primary">{{ now()->addDays(7)->translatedFormat('d F Y') }} (7 Hari)</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Simulation -->
                <div class="card card-clean p-4 mb-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-wallet2 text-primary"></i> Pilihan Metode Pembayaran
                    </h5>
                    
                    <div class="d-flex flex-column gap-2 mb-3">
                        <label class="p-3 rounded-3 border d-flex align-items-center justify-content-between cursor-pointer" style="background-color: var(--sg-primary-light); border-color: var(--sg-primary) !important;">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="qris" class="form-check-input mt-0" checked>
                                <div>
                                    <strong class="d-block text-dark">QRIS (GoPay, OVO, Dana, ShopeePay)</strong>
                                    <small class="text-muted">Verifikasi instan otomatis</small>
                                </div>
                            </div>
                            <span class="badge-subtle badge-subtle-success">Instan</span>
                        </label>

                        <label class="p-3 rounded-3 border d-flex align-items-center justify-content-between cursor-pointer bg-white">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="va" class="form-check-input mt-0">
                                <div>
                                    <strong class="d-block text-dark">Virtual Account Bank (BCA / Mandiri / BRI)</strong>
                                    <small class="text-muted">Transfer bebas biaya admin</small>
                                </div>
                            </div>
                            <span class="badge-subtle badge-subtle-dark">Online</span>
                        </label>
                    </div>

                    <div class="p-3 rounded-3 bg-light text-muted small d-flex gap-2">
                        <i class="bi bi-info-circle-fill text-primary fs-5 flex-shrink-0"></i>
                        <div>
                            Setelah konfirmasi pembayaran, link unduh / akses game akan langsung diproses dan aktif di menu <strong>Riwayat Peminjaman</strong>.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Review -->
            <div class="col-12 col-lg-5">
                <div class="card card-clean p-4 sticky-top" style="top: 96px;">
                    <h5 class="fw-bold mb-3">Item yang Disewa</h5>

                    <div class="d-flex flex-column gap-3 mb-3">
                        @foreach($carts as $cart)
                            <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                                <div class="text-truncate me-2" style="max-width: 220px;">
                                    <span class="fw-semibold text-dark text-truncate d-block">{{ $cart->product->name }}</span>
                                    <small class="text-muted">Akses 7 Hari Kalender</small>
                                </div>
                                <span class="fw-bold text-dark text-nowrap">
                                    Rp {{ number_format($cart->product->rental_price, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Subtotal ({{ $carts->count() }} Item)</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-3">
                        <span>Biaya Administrasi</span>
                        <span class="badge-subtle badge-subtle-success">Rp 0 (Gratis)</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="fw-bold text-dark fs-5">Total Bayar</span>
                        <span class="fs-4 fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-primary w-100 py-2 fs-6 mb-2" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        <i class="bi bi-check-circle-fill me-1"></i> Konfirmasi & Selesaikan Sewa
                    </button>

                    <a href="{{ route('pembeli.carts.index') }}" class="btn btn-light-custom w-100 btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modern Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4 pt-0">
                <div class="stat-icon-wrapper stat-icon-primary mx-auto mb-3" style="width: 64px; height: 64px; font-size: 2rem;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h5 class="fw-bold mb-2" id="confirmModalLabel">Konfirmasi Peminjaman?</h5>
                <p class="text-muted small mb-4">
                    Total pembayaran sebesar <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong> akan diproses untuk masa sewa 7 hari ke depan.
                </p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light-custom flex-grow-1" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary flex-grow-1" onclick="document.getElementById('checkoutForm').submit();">
                        Ya, Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
