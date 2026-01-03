<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin KWT Dewi Sri')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/jpeg">
    
    <style>
        body { overflow-x: hidden; background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        #wrapper { display: flex; width: 100%; }
        #sidebar-wrapper { min-height: 100vh; width: 250px; margin-left: 0; transition: margin 0.25s ease-out; background-color: #fff; box-shadow: 4px 0 10px rgba(0,0,0,0.05); z-index: 1000; }
        #wrapper.toggled #sidebar-wrapper { margin-left: -250px; }
        #page-content-wrapper { width: 100%; transition: all 0.25s ease-out; }
        .list-group-item { border: none; padding: 15px 20px; font-weight: 500; color: #6c757d; transition: all 0.3s; }
        .list-group-item:hover, .list-group-item.active {background-color: #f0fff4; /* Background hijau sangat muda */color: #198754; /* Hijau KWT */border-left: 4px solid #198754; /* Hijau KWT */}
        .sidebar-heading {padding: 1.5rem 1.25rem;font-size: 1.2rem;font-weight: bold;color: #198754; /* Hijau KWT */}
        
        /* Style umum untuk konten */
        .card-modern { background: #fff; border: none; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: transform 0.2s; height: 100%; }
        .card-modern:hover { transform: translateY(-5px); }
    </style>
    @yield('styles') </head>
<body>

    <div class="d-flex" id="wrapper">

        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center border-bottom py-4">
                <img src="{{ asset('img/logo.jpg') }}" 
                    alt="Logo KWT" 
                    width="60" 
                    height="60"
                    class="rounded-circle shadow-sm border border-2 border-white mb-2 d-block mx-auto">
                <span class="fw-bold text-success">KWT Dewi Sri</span>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.produk.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin/produk*') ? 'active' : '' }}">
                    <i class="fas fa-carrot me-2"></i> Kelola Produk
                </a>
                <a href="{{ route('admin.galeri.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin/galeri*') ? 'active' : '' }}">
                    <i class="fas fa-images me-2"></i> Kelola Galeri
                </a>
                <a href="{{ route('admin.pesanan.index') }}" class="list-group-item list-group-item-action {{ request()->is('admin/pesanan*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i> Pesanan Masuk
                </a>
                <a href="{{ route('admin.pesanan.arsip') }}" class="list-group-item list-group-item-action {{ request()->is('admin/riwayat-selesai*') ? 'active' : '' }}">
                    <i class="fas fa-archive me-2"></i> Arsip Selesai
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center w-100 justify-content-between">
                    <button class="btn btn-light" id="menu-toggle"><i class="fas fa-bars"></i></button>
                    <div class="d-flex align-items-center">
                        <span class="fw-bold text-dark me-3">Administrator</span>
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid px-4 py-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function () { el.classList.toggle("toggled"); };
    </script>
    @yield('scripts') </body>
</html>