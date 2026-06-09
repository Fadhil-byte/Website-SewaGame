@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stats-users text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Pengguna</h6>
                            <h2 class="mt-2 mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-products text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Produk</h6>
                            <h2 class="mt-2 mb-0">{{ $totalProducts }}</h2>
                        </div>
                        <i class="bi bi-boxes fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-active text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Peminjaman Aktif</h6>
                            <h2 class="mt-2 mb-0">{{ $activeRentals }}</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-revenue text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Keuntungan</h6>
                            <h4 class="mt-2 mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        </div>
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Peminjaman Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentRentals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Peminjam</th>
                                        <th>Produk</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRentals as $rental)
                                        <tr>
                                            <td>#{{ $rental->id }}</td>
                                            <td>{{ $rental->user->name }}</td>
                                            <td>{{ $rental->product->name }}</td>
                                            <td>
                                                @if($rental->status === 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                @elseif($rental->status === 'expired')
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <span class="badge badge-role-admin text-dark">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada peminjaman.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Pengguna Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentUsers->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($recentUsers as $user)
                                <li class="mb-3 pb-3 border-bottom">
                                    <strong>{{ $user->name }}</strong><br>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">Belum ada pengguna.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary me-2">
                <i class="bi bi-boxes"></i> Kelola Produk
            </a>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-success">
                <i class="bi bi-calendar-check"></i> Kelola Peminjaman
            </a>
        </div>
    </div>
</div>

