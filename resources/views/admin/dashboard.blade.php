@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold text-gray-800">Dashboard Overview</h3>
        <p class="text-muted">Selamat datang kembali, Admin! Berikut ringkasan data KWT Dewi Sri.</p>
    </div>

    <div class="row mb-5 g-4">
        <div class="col-md-3">
            <div class="card card-modern p-3 h-100 border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-bold">Total Produk</p>
                        <h2 class="stat-value mb-0 text-primary">{{ $jumlah_produk }}</h2>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle" style="width:50px;height:50px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                        <i class="fas fa-carrot"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-modern p-3 h-100 border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-bold">Total Kegiatan</p>
                        <h2 class="stat-value mb-0 text-success">{{ $jumlah_galeri }}</h2>
                    </div>
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle" style="width:50px;height:50px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-modern p-3 h-100 border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-bold">Pelanggan</p>
                        <h2 class="stat-value mb-0 text-warning">{{ $jumlah_user }}</h2>
                    </div>
                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle" style="width:50px;height:50px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-modern p-3 h-100 border-start border-4 border-danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-bold">Pesanan Masuk</p>
                        <h2 class="stat-value mb-0 text-danger">{{ $jumlah_pesanan }}</h2>
                    </div>
                    <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-circle" style="width:50px;height:50px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="fw-bold mb-3 text-gray-800">Menu Pengelolaan</h4>
    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card card-modern h-100">
                <div class="card-body text-center p-5">
                    <div class="icon-box bg-primary text-white rounded-circle mx-auto mb-3 shadow" style="width:70px;height:70px;display:flex;align-items:center;justify-content:center;font-size:2rem;">
                        <i class="fas fa-carrot"></i>
                    </div>
                    <h4 class="fw-bold">Kelola Produk</h4>
                    <p class="text-muted">Tambah, edit, atau hapus data produk hasil tani dan olahan.</p>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-primary btn-lg w-100 mt-3">
                        Buka Menu Produk <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-modern h-100">
                <div class="card-body text-center p-5">
                    <div class="icon-box bg-success text-white rounded-circle mx-auto mb-3 shadow" style="width:70px;height:70px;display:flex;align-items:center;justify-content:center;font-size:2rem;">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h4 class="fw-bold">Kelola Galeri</h4>
                    <p class="text-muted">Update dokumentasi kegiatan dan acara terbaru KWT.</p>
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-success btn-lg w-100 mt-3">
                        Buka Menu Galeri <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-modern h-100 bg-light border-0">
                <div class="card-body text-center p-5 opacity-75">
                    <div class="icon-box bg-secondary text-white rounded-circle mx-auto mb-3 shadow" style="width:70px;height:70px;display:flex;align-items:center;justify-content:center;font-size:2rem;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4 class="fw-bold text-muted">Kelola Pesanan</h4>
                    <p class="text-muted">Fitur manajemen pesanan dan transaksi pelanggan.</p>
                    <button class="btn btn-secondary btn-lg w-100 mt-3" disabled>
                        Segera Hadir <i class="fas fa-lock ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection