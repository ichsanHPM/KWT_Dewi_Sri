@extends('layouts.admin')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat & Kelola Pesanan</h1>
    </div>

    <div class="card card-modern p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Jml</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Bukti Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $pesanan)
                    <tr>
                        <td>#{{ $pesanan->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</td>
                        <td>
                            <div class="fw-bold">{{ $pesanan->user->name }}</div>
                            <small class="text-muted d-block">{{ $pesanan->user->email }}</small>
                            <div class="mt-2 p-2 bg-light rounded border small">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i> 
                                {{ $pesanan->alamat_pengiriman }}
                            </div>
                        </td>
                        <td>{{ $pesanan->produk->nama_produk }}</td>
                        <td>{{ $pesanan->jumlah_pesanan }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        
                        <td>
                            @if($pesanan->status == 'Menunggu Verifikasi')
                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu Verifikasi</span>
                            @elseif($pesanan->status == 'Dikirim')
                                <span class="badge bg-primary"><i class="fas fa-truck me-1"></i> Dikirim</span>
                            @elseif($pesanan->status == 'Selesai')
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                            @elseif($pesanan->status == 'Ditolak')
                                <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>

                        <td>
                            @if($pesanan->konfirmasi)
                                <a href="{{ asset('uploads/bukti_pembayaran/' . $pesanan->konfirmasi->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-image"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                @if($pesanan->status == 'Menunggu Verifikasi')
                                    {{-- Tombol Terima --}}
                                    <form action="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Terima pesanan?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    {{-- Tombol Tolak --}}
                                    <form action="{{ route('admin.pesanan.tolak', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak pesanan?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                @elseif($pesanan->status == 'Dikirim')
                                    {{-- Tombol Selesai --}}
                                    <form action="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Selesai?')">
                                            <i class="fas fa-box-open"></i> Selesai
                                        </button>
                                    </form>

                                @elseif($pesanan->status == 'Ditolak')
                                    {{-- Tombol Hapus (Ini yang Anda cari) --}}
                                    <form action="{{ route('admin.pesanan.hapus', $pesanan->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-dark" title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">Belum ada riwayat pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection