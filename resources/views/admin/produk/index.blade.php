@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Produk</h1>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Produk Baru
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
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $produk)
                <tr class="align-middle">
                    <td>{{ $produk->id }}</td>
                    <td>
                        @if($produk->foto)
                            <img src="{{ asset('uploads/produks/' . $produk->foto) }}" 
                                 alt="{{ $produk->nama_produk }}" 
                                 class="rounded"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <span class="text-muted">No Img</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $produk->nama_produk }}</td>
                    <td>Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-sm btn-warning text-white me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection