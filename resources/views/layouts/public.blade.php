<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KWT Dewi Sri Kentungan')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/jpeg">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        
        /* Navbar Style */
        .navbar { box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 15px 0; }
        .navbar-brand { font-weight: 700; color: #198754 !important; font-size: 1.5rem; }
        .nav-link { font-weight: 500; color: #555 !important; margin-left: 15px; transition: color 0.3s; }
        .nav-link:hover, .nav-link.active { color: #198754 !important; }
        .btn-login { background-color: #198754; color: white; border-radius: 50px; padding: 8px 25px; font-weight: 600; transition: all 0.3s; }
        .btn-login:hover { background-color: #146c43; color: white; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(25, 135, 84, 0.3); }

        /* Footer Style */
        footer { background-color: #212529; color: #bbb; padding: 50px 0 20px; }
        footer h5 { color: white; font-weight: 600; margin-bottom: 20px; }
        footer a { color: #bbb; text-decoration: none; transition: color 0.3s; }
        footer a:hover { color: #198754; }
    </style>
    @yield('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo KWT" height="45" class="d-inline-block align-text-top rounded-circle me-2 shadow-sm border">
                <span>KWT Dewi Sri</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('produk*') ? 'active' : '' }}" href="{{ route('produk.list') }}">Katalog Produk</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('galeri*') ? 'active' : '' }}" href="{{ route('galeri.list') }}">Galeri</a></li>
                    
                    <li class="nav-item ms-3">
                        @auth
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-login me-2">
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-login me-2">
                                    Akun Saya
                                </a>
                            @endif

                            <!-- Logout -->
                            <a href="{{ route('logout') }}"
                            class="btn btn-outline-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form-public').submit();">
                                Logout
                            </a>

                            <form id="logout-form-public" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-success px-4 me-2" style="border-radius: 50px;">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-login">
                                Daftar
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-light mt-auto py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-success mb-3">KWT Dewi Sri</h5>
                    <p class="small text-white-50">
                        Kelompok Wanita Tani yang berdedikasi menyediakan hasil tani segar dan olahan berkualitas untuk masyarakat Kentungan dan sekitarnya.
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-white mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-decoration-none text-white-50 hover-text-success">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('produk.list') }}" class="text-decoration-none text-white-50 hover-text-success">Katalog Produk</a></li>
                        <li class="mb-2"><a href="{{ route('galeri.list') }}" class="text-decoration-none text-white-50 hover-text-success">Galeri Kegiatan</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-white mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-map-marker-alt mt-1 me-3 text-success"></i>
                            <a href="https://maps.app.goo.gl/8Dy6GBijdUkUibyG9?g_st=aw">
                                Padukuhan Kentungan, Condongcatur,<br>Depok, Sleman, Yogyakarta
                            </a>
                        </li>
                        
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fab fa-instagram me-3 text-success"></i>
                            <a href="https://www.instagram.com/dewisri_kwt" target="_blank" class="text-white-50 text-decoration-none hover-text-white">
                                @dewisri_kwt
                            </a>
                        </li>

                        <li class="mb-3 d-flex align-items-center">
                            <i class="fab fa-whatsapp me-3 text-success"></i>
                            <a class="text-white-50 text-decoration-none hover-text-white">
                                +62 812 3456 7890
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-4 opacity-25">

            <div class="text-center small text-white-50">
                &copy; {{ date('Y') }} KWT Dewi Sri Kentungan.
            </div>
        </div>
    </footer>

<style>
    .hover-text-success:hover { color: #198754 !important; transition: color 0.3s; }
    .hover-text-white:hover { color: #fff !important; transition: color 0.3s; }
</style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>