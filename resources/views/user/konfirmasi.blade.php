@extends('layouts.public')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-success text-white text-center py-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-2"></i>Konfirmasi Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Produk:</small>
                            <span class="fw-bold">{{ $pesanan->produk->nama_produk }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Total Tagihan:</small>
                            <span class="fw-bold text-success fs-5">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('konfirmasi.store', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Tanggal Transfer</label>
                            <input type="date" class="form-control" name="tanggal_konfirmasi" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Bukti Transfer (Foto/Screenshot)</label>
                            <input type="file" class="form-control" name="bukti_transfer" required>
                            <div class="form-text">Pastikan foto terlihat jelas. Format: JPG, PNG.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success py-2 fw-bold rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Konfirmasi
                            </button>
                            <a href="{{ route('pesanan.riwayat') }}" class="btn btn-light text-muted py-2 rounded-pill">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection