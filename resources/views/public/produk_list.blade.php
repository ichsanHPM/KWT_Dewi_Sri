@extends('layouts.public')

@section('title', 'Shop - KWT Dewi Sri')

@section('content')
<div class="bg-light py-5 mb-5">
    <div class="container text-center">
        <h1 class="fw-bold text-success">Shop / Katalog Produk</h1>
        <p class="lead text-muted">Temukan hasil tani segar dan olahan berkualitas asli dari kebun kami.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        @forelse($produks as $produk)
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 border-0 shadow-sm hover-card" style="transition: transform 0.3s;">
                <div class="overflow-hidden rounded-top position-relative" style="height: 220px;">
                    @if($produk->foto)
                        <img src="{{ asset('uploads/produks/' . $produk->foto) }}" class="w-100 h-100 object-fit-cover" alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-leaf fa-3x"></i>
                        </div>
                    @endif
                    <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">Tersedia</span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">{{ $produk->nama_produk }}</h5>
                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($produk->deskripsi_produk, 60) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-bold text-success fs-5">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('produk.detail', $produk->id) }}" class="btn btn-outline-success mt-3 w-100 rounded-pill">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="Empty" style="width: 100px; opacity: 0.5;">
            <h4 class="mt-3 text-muted">Belum ada produk di Shop saat ini.</h4>
        </div>
        @endforelse
    </div>
</div>

<style>
    .hover-card:hover { transform: translateY(-5px); }
</style>
@endsection