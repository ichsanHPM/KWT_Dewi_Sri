@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Item Galeri</h1>
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

                <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="judul_kegiatan" class="form-label fw-bold">Judul Kegiatan</label>
                        <input type="text" class="form-control form-control-lg" id="judul_kegiatan" name="judul_kegiatan" value="{{ old('judul_kegiatan') }}" placeholder="Contoh: Panen Raya Cabai">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_kegiatan" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" placeholder="Ceritakan tentang kegiatan ini...">{{ old('deskripsi_kegiatan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="form-label fw-bold">Upload Foto</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                        <div class="form-text">Format: jpg, png, jpeg. Maks: 2MB.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection