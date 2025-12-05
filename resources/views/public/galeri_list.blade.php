@extends('layouts.public')

@section('title', 'Kegiatan - KWT Dewi Sri')

@section('content')
<div class="bg-light py-5 mb-5">
    <div class="container text-center">
        <h1 class="fw-bold text-success">Kegiatan Kami</h1>
        <p class="lead text-muted">Mengenal lebih dekat aktivitas pemberdayaan wanita tani di Kentungan.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        @forelse($galeris as $item)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow rounded-4 overflow-hidden">
                <div style="height: 250px; overflow: hidden;">
                    @if($item->foto)
                        <img src="{{ asset('uploads/galeri/' . $item->foto) }}" 
                             class="w-100 h-100 object-fit-cover transition-zoom" 
                             alt="{{ $item->judul_kegiatan }}">
                    @else
                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>

                <div class="card-body p-4">
                    <div class="d-flex align-items-center text-muted small mb-2">
                        <i class="far fa-calendar-alt me-2"></i> 
                        {{ $item->created_at->format('d M Y') }}
                    </div>
                    <h4 class="card-title fw-bold text-success mb-3">{{ $item->judul_kegiatan }}</h4>
                    <p class="card-text text-secondary" style="line-height: 1.6;">
                        {{ $item->deskripsi_kegiatan }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada dokumentasi kegiatan yang diupload.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .transition-zoom { transition: transform 0.5s ease; }
    .card:hover .transition-zoom { transform: scale(1.1); }
</style>
@endsection