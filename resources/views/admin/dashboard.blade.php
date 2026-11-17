@extends('layouts.app')

@section('title', 'Dashboard Admin - SewaGame')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Header with Quick Action -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge-subtle badge-subtle-primary">Admin Control Center</span>
                <span class="text-muted small">&bull; {{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h3 class="fw-bold mb-0">Dashboard Manajemen</h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Produk
            </a>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-light-custom btn-sm">
                <i class="bi bi-calendar-check me-1"></i> Data Sewa
            </a>
        </div>
    </div>

    <!-- 4 Modern Stat Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-modern">
                <div>
                    <p class="stat-label">Total Pelanggan</p>
                    <h3 class="stat-number">{{ number_format($totalUsers) }}</h3>
                    <small class="text-muted" style="font-size: 0.75rem;">Pengguna terdaftar</small>
                </div>
                <div class="stat-icon-wrapper stat-icon-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-modern">
                <div>
                    <p class="stat-label">Total Katalog Produk</p>
                    <h3 class="stat-number">{{ number_format($totalProducts) }}</h3>
                    <small class="text-muted" style="font-size: 0.75rem;">Game & Android app</small>
                </div>
                <div class="stat-icon-wrapper stat-icon-info">
                    <i class="bi bi-boxes"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-modern">
                <div>
                    <p class="stat-label">Sewa Berjalan</p>
                    <h3 class="stat-number">{{ number_format($activeRentals) }}</h3>
                    <small class="text-muted" style="font-size: 0.75rem;">Status sewa aktif</small>
                </div>
                <div class="stat-icon-wrapper stat-icon-warning">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-modern">
                <div>
                    <p class="stat-label">Total Pendapatan</p>
                    <h3 class="stat-number" style="font-size: 1.45rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <small class="text-muted" style="font-size: 0.75rem;">Dari transaksi lunas</small>
                </div>
                <div class="stat-icon-wrapper stat-icon-success">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Grid -->
    <div class="row g-4">
        <!-- Recent Rentals (Left 8 cols) -->
        <div class="col-12 col-lg-8">
            <div class="card card-clean">
                <div class="p-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-primary"></i> Peminjaman Terbaru
                    </h6>
                    <a href="{{ route('admin.rentals.index') }}" class="small text-primary fw-semibold">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-clean">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Peminjam</th>
                                <th>Produk</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRentals as $rental)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-muted" style="font-size: 0.8rem;">#{{ $rental->id }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-dark d-block">{{ $rental->user->name }}</strong>
                                        <small class="text-muted">{{ $rental->user->email }}</small>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-semibold">{{ $rental->product->name }}</span>
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
                                    <td class="text-end">
                                        <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-light-custom px-2 py-1" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($rental->status === 'pending')
                                            <a href="{{ route('admin.rentals.sendLinksForm', $rental) }}" class="btn btn-sm btn-primary px-2 py-1" title="Kirim Link">
                                                <i class="bi bi-send"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">
                                        Belum ada data peminjaman terbaru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Users (Right 4 cols) -->
        <div class="col-12 col-lg-4">
            <div class="card card-clean">
                <div class="p-3 px-4 border-bottom">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-people text-primary"></i> Pengguna Baru Terdaftar
                    </h6>
                </div>
                <div class="p-3">
                    @forelse($recentUsers as $user)
                        <div class="d-flex align-items-center gap-3 p-2 rounded-3 hover-bg-light transition-all mb-2">
                            <span class="user-avatar-circle flex-shrink-0" style="width: 38px; height: 38px; font-size: 0.95rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            <div class="text-truncate flex-grow-1">
                                <strong class="text-dark d-block text-truncate small">{{ $user->name }}</strong>
                                <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">{{ $user->email }}</small>
                            </div>
                            <span class="badge-subtle badge-subtle-dark flex-shrink-0" style="font-size: 0.7rem;">
                                {{ $user->created_at ? $user->created_at->diffForHumans(null, true) : '-' }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">
                            Belum ada pengguna terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
