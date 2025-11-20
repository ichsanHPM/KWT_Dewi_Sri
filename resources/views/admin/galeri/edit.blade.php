<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item Galeri - Admin KWT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1>Edit Item Galeri: {{ $galeri->judul_kegiatan }}</h1>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada masalah dengan data Anda.<br><br>
                        <ul>
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
                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" 
                               value="{{ old('judul_kegiatan', $galeri->judul_kegiatan) }}">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan</label>
                        <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="3">{{ old('deskripsi_kegiatan', $galeri->deskripsi_kegiatan) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (Baru)</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                        <small class="form-text">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label>Foto Saat Ini:</label><br>
                        @if($galeri->foto)
                            <img src="{{ asset('uploads/galeri/' . $galeri->foto) }}" alt="{{ $galeri->judul_kegiatan }}" style="width: 150px; height: auto;">
                        @else
                            (Tidak ada foto)
                        @endif
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batalkan</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>