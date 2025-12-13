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
                            <div class="d-flex gap-1">
                                
                                @if($pesanan->status == 'Menunggu Verifikasi')
                                    <form action="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Terima pesanan?')"><i class="fas fa-check"></i></button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $pesanan->id }}"><i class="fas fa-times"></i></button>

                                @elseif($pesanan->status == 'Dikirim')
                                    <form action="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Selesai?')"><i class="fas fa-box-open"></i> Selesai</button>
                                    </form>

                                @elseif($pesanan->status == 'Ditolak')
                                    <form action="{{ route('admin.pesanan.hapus', $pesanan->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini secara permanen? Data tidak bisa dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-dark" title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                
                                @else
                                    @endif

                            </div>
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
                                    <form action="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" 
                                                onclick="return confirm('Bukti valid? Ubah status jadi DIKIRIM?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.pesanan.tolak', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin MENOLAK pesanan ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                @elseif($pesanan->status == 'Dikirim')
                                    <form action="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary" 
                                                onclick="return confirm('Barang sudah sampai? Arsipkan pesanan?')">
                                            <i class="fas fa-box-open"></i> Selesai
                                        </button>
                                    </form>

                                @elseif($pesanan->status == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <button class="btn btn-sm btn-light" disabled><i class="fas fa-check"></i></button>
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