@extends('layouts.public')

@section('title', 'Beranda - KWT Dewi Sri Kentungan')

@section('styles')
<style>
    .hero-section {
        /* Background gambar ibu-ibu KWT atau kebun (Ganti URL jika sudah ada foto asli) */
        background: linear-gradient(rgba(21, 87, 36, 0.85), rgba(20, 108, 67, 0.8)), url('https://i1.wp.com/www.dprd-diy.go.id/wp-content/uploads/2025/10/Dari-Lahan-Sempit-KWT-Dewi-Sri-Hadirkan-Inovasi-Urban-Farming-di-Kentungan-scaled.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 120px 0;
        margin-bottom: 0;
    }
    .feature-icon {
        width: 80px; height: 80px;
        background: #e8f5e9;
        color: #198754;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; margin: 0 auto 20px;
        font-size: 2rem; transition: all 0.3s;
    }
    .feature-card:hover .feature-icon {
        background: #198754; color: white; transform: scale(1.1);
    }
    .product-img-wrapper {
        height: 200px; overflow: hidden; background: #f8f9fa;
        display: flex; align-items: center; justify-content: center;
    }
    .product-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
</style>
@endsection

@section('content')

    <section class="hero-section text-center">
        <div class="container">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 fw-bold">Urban Farming & Ketahanan Pangan</span>
            <h1 class="display-4 fw-bold mb-3">Kemandirian Pangan dari Halaman Rumah</h1>
            <p class="lead mb-5 opacity-75 col-md-8 mx-auto">
                KWT Dewi Sri Kentungan hadir memberdayakan wanita tani untuk mengubah lahan tidur menjadi sumber nutrisi sehat dan ekonomi produktif bagi warga Condongcatur.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('produk.list') }}" class="btn btn-light btn-lg text-success fw-bold px-5 rounded-pill shadow">Beli Produk Kami</a>
                <a href="#profil" class="btn btn-outline-light btn-lg px-5 rounded-pill">Tentang Kami</a>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white" id="profil">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h6 class="text-success fw-bold text-uppercase ls-1">Apa yang Kami Lakukan?</h6>
                <h2 class="fw-bold">Pilar Utama KWT Dewi Sri</h2>
            </div>
            
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="feature-card p-4 h-100">
                        <div class="feature-icon"><i class="fas fa-seedling"></i></div>
                        <h4 class="fw-bold mb-3">Budidaya Sayur Organik</h4>
                        <p class="text-muted">Memanfaatkan lahan pekarangan di Kentungan untuk menanam Bayam, Kangkung, Cabai, dan Tanaman Obat Keluarga (TOGA) tanpa pestisida kimia.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card p-4 h-100">
                        <div class="feature-icon"><i class="fas fa-fish"></i></div>
                        <h4 class="fw-bold mb-3">Perikanan & Jamur</h4>
                        <p class="text-muted">Mengembangkan budidaya Lele dalam ember (Budikdamber) dan rumah jamur tiram sebagai sumber protein hewani dan nabati bagi anggota.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card p-4 h-100">
                        <div class="feature-icon"><i class="fas fa-utensils"></i></div>
                        <h4 class="fw-bold mb-3">Produk Olahan Sehat</h4>
                        <p class="text-muted">Mengolah hasil panen menjadi produk bernilai jual tinggi seperti Kripik Bayam Brazil, Bawang Goreng, Sambal Pecel, hingga Dimsum Lele.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-md-2">
                    <img src="{{ asset('img/pembukaan_lahan_KWT.jpg') }}" 
                         alt="Ibu-ibu KWT" class="img-fluid rounded-4 shadow mb-4 mb-md-0 mx-auto d-block" style="max-height: 350px; width: 100%; object-fit: cover;">
                </div>
                <div class="col-md-6 order-md-1 pe-md-5">
                    <h6 class="text-success fw-bold text-uppercase">Profil Komunitas</h6>
                    <h2 class="fw-bold mb-3">Dari Kentungan untuk Sleman</h2>
                    <p class="text-muted mb-3">
                        Kelompok Wanita Tani (KWT) Dewi Sri terbentuk dari semangat ibu-ibu di Padukuhan Kentungan, Condongcatur, untuk mendukung program pemerintah dalam ketahanan pangan.
                    </p>
                    <p class="text-muted mb-4">
                        Beranggotakan lebih dari 40 wanita tangguh, kami tidak hanya bertani, tetapi juga membangun ekosistem ekonomi kreatif. Hasil panen kami dipasarkan ke warga sekitar dan diolah menjadi produk kemasan yang higienis dan lezat.
                    </p>
                    <a href="{{ route('galeri.list') }}" class="btn btn-outline-success rounded-pill px-4">
                        Lihat Dokumentasi Kegiatan <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5 mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h6 class="text-success fw-bold text-uppercase">Produk Kami</h6>
                <h2 class="fw-bold">Segar Langsung dari Kebun</h2>
            </div>
            <a href="{{ route('produk.list') }}" class="btn btn-success rounded-pill shadow-sm">Ke Toko <i class="fas fa-shopping-basket ms-2"></i></a>
        </div>

        <div class="row g-4">
            @forelse($produks as $produk)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                    <div class="product-img-wrapper">
                        @if($produk->foto)
                            <img src="{{ asset('uploads/produks/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
                        @else
                            <div class="text-muted"><i class="fas fa-leaf fa-3x"></i></div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark h6">{{ $produk->nama_produk }}</h5>
                        <p class="card-text text-success fw-bold">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                        <a href="{{ route('produk.detail', $produk->id) }}" class="btn btn-outline-success btn-sm w-100 rounded-pill">Beli</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada produk yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </section>

@endsection