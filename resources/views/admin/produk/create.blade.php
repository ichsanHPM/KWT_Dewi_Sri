<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru - Admin KWT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1>Formulir Tambah Produk Baru</h1>
                
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

                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    
                    @csrf

                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}">
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga (Rupiah)</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi" class="form-label">Spesifikasi (Opsional)</label>
                        <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="2">{{ old('spesifikasi') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Produk</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batalkan</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>