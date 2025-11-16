<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin KWT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1>Edit Produk: {{ $produk->nama_produk }}</h1>
                
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

                <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" 
                               value="{{ old('nama_produk', $produk->nama_produk) }}">
                    </div>

                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga (Rupiah)</label>
                        <input type="number" class="form-control" id="harga_produk" name="harga_produk" 
                               value="{{ old('harga_produk', $produk->harga_produk) }}">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi" class="form-label">Spesifikasi (Opsional)</label>
                        <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="2">{{ old('spesifikasi', $produk->spesifikasi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Produk (Baru)</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                        <small class="form-text">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label>Foto Saat Ini:</label><br>
                        @if($produk->foto)
                            <img src="{{ asset('uploads/produks/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" style="width: 150px; height: auto;">
                        @else
                            (Tidak ada foto)
                        @endif
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batalkan</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>