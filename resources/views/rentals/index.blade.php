@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - SewaGame')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li class="active">Riwayat Peminjaman</li>
    </ul>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Riwayat Peminjaman Game</h3>
            <p class="text-muted small mb-0">Pantau status aktif, tanggal kedaluwarsa, dan akses link unduhan game Anda.</p>
        </div>
        <a href="{{ route('pembeli.products.index') }}" class="btn btn-primary btn-sm align-self-start align-self-sm-auto">
            <i class="bi bi-plus-lg me-1"></i> Sewa Game Baru
        </a>
    </div>

    @if($rentals->count() > 0)
        <div class="table-clean-wrapper mb-4">
            <div class="table-responsive">
                <table class="table table-clean">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Masa Aktif</th>
                            <th>Status Sewa</th>
                            <th>Pembayaran</th>
                            <th>Link Akses</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $rental)
                            <tr class="{{ $rental->is_expired ? 'opacity-75' : '' }}">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-2 overflow-hidden bg-light flex-shrink-0" style="width: 48px; height: 48px;">
                                            @if($rental->product->image)
                                                <img src="{{ asset('storage/' . $rental->product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $rental->product->name }}">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                    <i class="bi bi-controller opacity-50"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-truncate" style="max-width: 240px;">
                                            <strong class="text-dark d-block text-truncate">{{ $rental->product->name }}</strong>
                                            <small class="text-muted">#RENT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d M Y') }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">s/d {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M Y') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($rental->status === 'active')
                                        <span class="badge-subtle badge-subtle-success">
                                            <i class="bi bi-check-circle-fill"></i> Aktif
                                        </span>
                                    @elseif($rental->status === 'expired')
                                        <span class="badge-subtle badge-subtle-danger">
                                            <i class="bi bi-x-circle-fill"></i> Expired
                                        </span>
                                    @else
                                        <span class="badge-subtle badge-subtle-warning">
                                            <i class="bi bi-hourglass-split"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($rental->payment_status === 'paid')
                                        <span class="badge-subtle badge-subtle-success">Lunas</span>
                                    @else
                                        <span class="badge-subtle badge-subtle-dark">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($rental->status === 'pending')
                                        <span class="small text-warning fw-semibold">
                                            <i class="bi bi-clock"></i> Verifikasi Admin
                                        </span>
                                    @elseif($rental->is_expired)
                                        <span class="small text-muted">
                                            <i class="bi bi-lock-fill"></i> Terkunci
                                        </span>
                                    @else
                                        <span class="small text-success fw-semibold">
                                            <i class="bi bi-unlock-fill"></i> Siap Diakses
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('pembeli.rentals.show', $rental) }}" class="btn btn-sm btn-light-custom px-3">
                                        Detail & Link <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $rentals->links('pagination::bootstrap-5') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-box">
            <div class="empty-state-icon">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h4 class="fw-bold mb-2">Belum Ada Riwayat Sewa</h4>
            <p class="text-muted small mb-4" style="max-width: 420px; margin: 0 auto;">
                Anda belum pernah menyewa game atau aplikasi apa pun di SewaGame.
            </p>
            <a href="{{ route('pembeli.products.index') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-grid-fill me-1"></i> Mulai Sewa Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
