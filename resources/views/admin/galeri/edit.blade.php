@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Item Galeri</h1>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">
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

                <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="judul_kegiatan" class="form-label fw-bold">Judul Kegiatan</label>
                        <input type="text" class="form-control form-control-lg" id="judul_kegiatan" name="judul_kegiatan" 
                               value="{{ old('judul_kegiatan', $galeri->judul_kegiatan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_kegiatan" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4">{{ old('deskripsi_kegiatan', $galeri->deskripsi_kegiatan) }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="foto" class="form-label fw-bold">Ganti Foto (Opsional)</label>
                            <input class="form-control" type="file" id="foto" name="foto">
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label d-block fw-bold">Foto Saat Ini</label>
                            @if($galeri->foto)
                                <img src="{{ asset('uploads/galeri/' . $galeri->foto) }}" class="img-thumbnail rounded" style="height: 100px;">
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