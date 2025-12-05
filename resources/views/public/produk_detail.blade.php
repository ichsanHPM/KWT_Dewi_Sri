@extends('layouts.public')

@section('title', $produk->nama_produk . ' - KWT Dewi Sri')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-success">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produk.list') }}" class="text-decoration-none text-success">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                @if($produk->foto)
                    <img src="{{ asset('uploads/produks/' . $produk->foto) }}" class="img-fluid w-100" alt="{{ $produk->nama_produk }}" style="max-height: 500px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-leaf fa-5x text-secondary opacity-25"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold text-dark mb-2">{{ $produk->nama_produk }}</h1>
            <h2 class="text-success fw-bold mb-4">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</h2>

            <div class="mb-4">
                <h5 class="fw-bold text-dark">Deskripsi</h5>
                <p class="text-muted">{{ $produk->deskripsi_produk }}</p>
            </div>

            @if($produk->spesifikasi)
            <div class="mb-4 p-3 bg-light rounded-3 border">
                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle me-2"></i>Spesifikasi</h6>
                <p class="mb-0 small text-secondary">{{ $produk->spesifikasi }}</p>
            </div>
            @endif

            <hr class="my-4">

            @auth
                <div class="card border-success mb-3">
                    <div class="card-body bg-success bg-opacity-10">
                        <h5 class="card-title fw-bold text-success mb-3">Pesan Sekarang</h5>
                        
                        <form action="{{ route('pesan.store', $produk->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Pesanan</label>
                                <div class="input-group" style="width: 150px;">
                                    <button class="btn btn-outline-success" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                    <input type="number" class="form-control text-center" name="jumlah_pesanan" value="1" min="1">
                                    <button class="btn btn-outline-success" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Pengiriman Lengkap</label>
                                <textarea name="alamat_pengiriman" class="form-control" rows="3" required placeholder="Jln. Mawar No. 10, RT/RW..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-2 fw-bold rounded-pill shadow-sm">
                                <i class="fas fa-shopping-cart me-2"></i> Beli Produk Ini
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-warning border-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-lock me-3 fa-2x text-warning"></i>
                    <div>
                        <strong>Ingin membeli produk ini?</strong><br>
                        Silakan login terlebih dahulu untuk melakukan pemesanan.
                    </div>
                </div>
                <a href="{{ route('login') }}" class="btn btn-warning w-100 py-2 fw-bold rounded-pill text-white shadow-sm">
                    <i class="fas fa-sign-in-alt me-2"></i> Login untuk Membeli
                </a>
                <div class="text-center mt-2">
                    <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold">Daftar disini</a></small>
                </div>
            @endauth

        </div>
    </div>
</div>
@endsection