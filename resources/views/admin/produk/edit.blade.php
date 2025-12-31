@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
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

                <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
                        <input type="text" class="form-control form-control-lg" id="nama_produk" name="nama_produk" 
                               value="{{ old('nama_produk', $produk->nama_produk) }}">
                    </div>

                    <div class="mb-3">
                        <label for="harga_produk" class="form-label fw-bold">Harga (Rupiah)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="harga_produk" name="harga_produk" 
                                   value="{{ old('harga_produk', $produk->harga_produk) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label fw-bold">Stok Produk</label>
                        <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi" class="form-label fw-bold">Spesifikasi (Opsional)</label>
                        <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="2">{{ old('spesifikasi', $produk->spesifikasi) }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="foto" class="form-label fw-bold">Ganti Foto (Opsional)</label>
                            <input class="form-control" type="file" id="foto" name="foto">
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label d-block fw-bold">Foto Saat Ini</label>
                            @if($produk->foto)
                                <img src="{{ asset('uploads/produks/' . $produk->foto) }}" class="img-thumbnail rounded" style="height: 100px;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection