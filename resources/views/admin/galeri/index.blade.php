@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Galeri & Kegiatan</h1>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Item Baru
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif
    
    <div class="card card-modern p-4">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Judul Kegiatan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galeris as $item)
                <tr class="align-middle">
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($item->foto)
                            <img src="{{ asset('uploads/galeri/' . $item->foto) }}" 
                                 alt="{{ $item->judul_kegiatan }}" 
                                 class="rounded shadow-sm"
                                 style="width: 100px; height: 80px; object-fit: cover;">
                        @else
                            <span class="badge bg-secondary">No Image</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $item->judul_kegiatan }}</td>
                    <td class="text-muted">{{ Str::limit($item->deskripsi_kegiatan, 60) }}</td>
                    <td>
                        <a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Yakin hapus kegiatan ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-images fa-3x mb-3 d-block text-gray-300"></i>
                        Belum ada data kegiatan galeri.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection