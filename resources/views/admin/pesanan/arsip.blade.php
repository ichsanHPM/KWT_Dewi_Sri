@extends('layouts.admin')

@section('title', 'Arsip Pesanan Selesai')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Arsip Pesanan Selesai</h1>
            <p class="text-muted small">Data pesanan yang telah diverifikasi dan dipindahkan ke riwayat.</p>
        </div>
        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Pesanan Aktif
        </a>
    </div>

    <div class="card card-modern p-4 border-success border-top border-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Arsip</th>
                        <th>Tanggal Pesan</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $item)
                    <tr>
                        <td>#{{ $item->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d M Y') }}</td>
                        <td>
                            @if($item->user)
                                <div class="fw-bold">{{ $item->user->name }}</div>
                                <small class="text-muted">{{ $item->user->email }}</small>
                            @else
                                <span class="text-danger">User Terhapus</span>
                            @endif
                        </td>
                        <td>
                            @if($item->produk)
                                {{ $item->produk->nama_produk }}
                            @else
                                <span class="text-danger">Produk Terhapus</span>
                            @endif
                        </td>
                        <td>{{ $item->jumlah_pesanan }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                        </td>
                        <td class="text-muted small">
                            {{ $item->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-archive fa-3x mb-3 opacity-50"></i>
                            <p>Belum ada pesanan yang diarsipkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection