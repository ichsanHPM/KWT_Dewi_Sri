<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Galeri - Admin KWT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Kelola Galeri & Kegiatan</h1>
            <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">Tambah Item Galeri Baru</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Judul Kegiatan</th>
                    <th>Deskripsi Kegiatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galeris as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ asset('uploads/galeri/' . $item->foto) }}" 
                                alt="{{ $item->judul_kegiatan }}" 
                                style="width: 150px; height: auto;">
                        @else
                            (Tidak ada foto)
                        @endif
                    </td>
                    <td>{{ $item->judul_kegiatan }}</td>
                    <td>{{ Str::limit($item->deskripsi_kegiatan, 50) }}</td>
                    <td class="text-nowrap"> <a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus item galeri ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data galeri.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>