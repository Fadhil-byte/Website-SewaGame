@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-calendar-check"></i> Daftar Peminjaman</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($rentals->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Peminjam</th>
                        <th>Produk</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentals as $rental)
                        <tr class="{{ $rental->is_expired ? 'table-secondary' : '' }}">
                            <td>#{{ $rental->id }}</td>
                            <td>
                                <strong>{{ $rental->user->name }}</strong>
                                <br><small class="text-muted">{{ $rental->user->email }}</small>
                            </td>
                            <td>{{ $rental->product->name }}</td>
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
                            <td class="text-center">
                                <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-outline-primary">
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
            <h4 class="text-muted mt-3">Belum ada peminjaman</h4>
        </div>
    @endif
</div>
@endsection
