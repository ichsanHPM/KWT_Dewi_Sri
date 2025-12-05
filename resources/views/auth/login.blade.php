@extends('layouts.public')

@section('title', 'Masuk - KWT Dewi Sri')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white text-center py-4">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" width="70" class="rounded-circle shadow mb-2 border border-white">
                    <h4 class="fw-bold mb-0">Selamat Datang Kembali</h4>
                    <small>Silakan login untuk melanjutkan</small>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-secondary">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="********">
                                <button class="btn btn-light border border-start-0" type="button" onclick="toggleVisibility('password', 'icon-eye')">
                                    <i class="fas fa-eye text-muted" id="icon-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a class="btn btn-link p-0 small text-decoration-none text-success" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success py-2 fw-bold rounded-pill shadow-sm">
                                MASUK <i class="fas fa-sign-in-alt ms-2"></i>
                            </button>
                        </div>

                        <div class="text-center text-muted small">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Daftar Sekarang</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection