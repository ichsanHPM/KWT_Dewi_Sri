@extends('layouts.public')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <h2 class="fw-bold text-success mb-4"><i class="fas fa-history me-2"></i>Riwayat Pesanan</h2>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4">Produk</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Jumlah</th>
                            <th class="py-3">Total Harga</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $pesanan)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @if($pesanan->produk)
                                        <img src="{{ asset('uploads/produks/' . $pesanan->produk->foto) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                        <span class="fw-bold text-dark">{{ $pesanan->produk->nama_produk }}</span>
                                    @else
                                        <span class="text-danger fst-italic">Produk Terhapus</span>
                                    @endif
                                </div>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</td>

                            <td>
                                {{ $pesanan->jumlah_pesanan }} 
                                
                                {{-- Ambil satuan dari produk, jika produk hilang/null defaultnya 'pcs' --}}
                                <span class="fw-bold">{{ $pesanan->produk->satuan ?? 'pcs' }}</span>
                            </td>

                            <td class="fw-bold text-success">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            
                            <td>
                                @if($pesanan->status == 'Menunggu Pembayaran')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">Menunggu Pembayaran</span>
                                
                                @elseif($pesanan->status == 'Menunggu Verifikasi')
                                    <span class="badge bg-info text-white rounded-pill px-3">Menunggu Verifikasi</span>
                                
                                @elseif($pesanan->status == 'Dikirim')
                                    <span class="badge bg-primary rounded-pill px-3">Sedang Dikirim</span>
                                
                                @elseif($pesanan->status == 'Selesai')
                                    <span class="badge bg-success rounded-pill px-3">Selesai</span>
                                
                                @elseif($pesanan->status == 'Ditolak')
                                    <span class="badge bg-danger rounded-pill px-3 mb-1">Ditolak</span>
                                    @if($pesanan->alasan_penolakan)
                                        <div class="alert alert-danger p-2 mb-0 mt-1 lh-sm" style="font-size: 0.75rem; max-width: 200px;">
                                            <strong>Alasan:</strong><br>
                                            {{ $pesanan->alasan_penolakan }}
                                        </div>
                                    @endif
                                
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">{{ $pesanan->status }}</span>
                                @endif
                            </td>

                            <td class="pe-4 text-end">
                                @if($pesanan->status == 'Menunggu Pembayaran')
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('konfirmasi.form', $pesanan->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-money-bill-wave me-1"></i> Bayar
                                        </a>

                                        <form action="{{ route('pesan.batal', $pesanan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="fas fa-times"></i> Batal
                                            </button>
                                        </form>
                                    </div>

                                @elseif($pesanan->status == 'Menunggu Verifikasi')
                                    <button class="btn btn-sm btn-secondary rounded-pill px-3" disabled>
                                        <i class="fas fa-clock me-1"></i> Diproses
                                    </button>

                                @elseif($pesanan->status == 'Dikirim')
                                    <button class="btn btn-sm btn-primary rounded-pill px-3" disabled>
                                        <i class="fas fa-truck me-1"></i> Diproses
                                    </button>

                                @elseif($pesanan->status == 'Ditolak')
                                    <button class="btn btn-sm btn-danger rounded-pill px-3" disabled>
                                        <i class="fas fa-times-circle me-1"></i> Ditolak Admin
                                    </button>

                                @else
                                    <button class="btn btn-sm btn-success rounded-pill px-3" disabled>
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted mb-3"><i class="fas fa-shopping-basket fa-3x opacity-50"></i></div>
                                <h5 class="text-muted">Belum ada pesanan</h5>
                                <a href="{{ route('produk.list') }}" class="btn btn-success mt-2 rounded-pill">Mulai Belanja</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection