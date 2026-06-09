@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-calendar-check"></i> Riwayat Peminjaman</h2>

    @if($rentals->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Produk</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Link Akses</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentals as $rental)
                        <tr class="{{ $rental->is_expired ? 'table-secondary' : '' }}">
                            <td>
                                <strong>{{ $rental->product->name }}</strong>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($rental->status === 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($rental->status === 'expired')
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($rental->payment_status === 'paid')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-secondary">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                @if($rental->status === 'pending')
                                    <span class="text-muted"><i class="bi bi-clock"></i> Menunggu</span>
                                @elseif($rental->is_expired)
                                    <span class="text-muted"><i class="bi bi-lock"></i> Dikunci</span>
                                @else
                                    <span class="text-success"><i class="bi bi-unlock"></i> Tersedia</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pembeli.rentals.show', $rental) }}" class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $rentals->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted"></i>
            <h4 class="text-muted mt-3">Belum ada riwayat peminjaman</h4>
            <a href="{{ route('pembeli.products.index') }}" class="btn btn-primary mt-3">
                Sewa Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
