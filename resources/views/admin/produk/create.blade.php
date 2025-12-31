@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk Baru</h1>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-modern p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
                        <input type="text" class="form-control form-control-lg" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Contoh: Kripik Bayam">
                    </div>

                    <div class="mb-3">
                        <label for="harga_produk" class="form-label fw-bold">Harga (Rupiah)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="harga_produk" name="harga_produk" value="{{ old('harga_produk') }}" placeholder="15000">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label fw-bold">Stok Produk</label>
                        <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', 0) }}" min="0" required placeholder="Masukkan jumlah stok tersedia">
                        <div class="form-text">Masukkan angka 0 jika barang habis.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3" placeholder="Jelaskan produk ini...">{{ old('deskripsi_produk') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi" class="form-label fw-bold">Spesifikasi (Opsional)</label>
                        <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="2" placeholder="Contoh: Berat 250gr, Tahan 1 bulan">{{ old('spesifikasi') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="form-label fw-bold">Foto Produk</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                        <div class="form-text">Format: jpg, png, jpeg. Maks: 2MB.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Produk</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection