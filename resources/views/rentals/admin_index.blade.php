@extends('layouts.app')

@section('title', 'Data Peminjaman - Admin')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <ul class="breadcrumb-custom">
        <li><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="active">Data Peminjaman</li>
    </ul>

    <!-- Header Actions -->
    <div class="card card-clean p-4 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <div>
                <h3 class="fw-bold mb-1">Manajemen Peminjaman</h3>
                <p class="text-muted small mb-0">Pantau dan kelola seluruh transaksi penyewaan game, masa aktif, dan aktivasi link unduhan.</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-light-custom btn-sm align-self-start align-self-sm-auto">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Rentals Table -->
    @if($rentals->count() > 0)
        <div class="table-clean-wrapper mb-4">
            <div class="table-responsive">
                <table class="table table-clean">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Masa Sewa</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $rental)
                            <tr class="{{ $rental->is_expired ? 'opacity-75' : '' }}">
                                <td>
                                    <span class="fw-bold text-muted small">#{{ $rental->id }}</span>
                                </td>
                                <td>
                                    <strong class="text-dark d-block">{{ $rental->user->name }}</strong>
                                    <small class="text-muted">{{ $rental->user->email }}</small>
                                </td>
                                <td>
                                    <strong class="text-dark">{{ $rental->product->name }}</strong>
                                    <small class="text-muted d-block">Rp {{ number_format($rental->product->rental_price, 0, ',', '.') }}</small>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d M Y') }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">s/d {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M Y') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($rental->status === 'active')
                                        <span class="badge-subtle badge-subtle-success">Aktif</span>
                                    @elseif($rental->status === 'expired')
                                        <span class="badge-subtle badge-subtle-danger">Expired</span>
                                    @else
                                        <span class="badge-subtle badge-subtle-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($rental->payment_status === 'paid')
                                        <span class="badge-subtle badge-subtle-success">Lunas</span>
                                    @else
                                        <span class="badge-subtle badge-subtle-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-light-custom px-2" title="Detail Peminjaman">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        @if($rental->status === 'pending')
                                            <a href="{{ route('admin.rentals.sendLinksForm', $rental) }}" class="btn btn-sm btn-primary px-2" title="Kirim Link">
                                                <i class="bi bi-send"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $rentals->links('pagination::bootstrap-5') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-box">
            <div class="empty-state-icon">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h4 class="fw-bold mb-2">Belum Ada Transaksi Sewa</h4>
            <p class="text-muted small mb-0">Saat ini belum ada peminjaman yang tercatat di dalam sistem.</p>
        </div>
    @endif
</div>
@endsection
