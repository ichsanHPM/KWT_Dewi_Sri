@extends('layouts.public')

@section('title', 'Daftar - KWT Dewi Sri')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white text-center py-4">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" width="70" class="rounded-circle shadow mb-2 border border-white">
                    <h4 class="fw-bold mb-0">Buat Akun Baru</h4>
                    <small>Bergabunglah dengan komunitas kami</small>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-secondary">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Contoh: Siti Aminah">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-secondary">Alamat Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold text-secondary">Password</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <button class="btn btn-light border border-start-0" type="button" onclick="toggleVisibility('password', 'icon-pass')">
                                    <i class="fas fa-eye text-muted" id="icon-pass"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold text-secondary">Konfirmasi Password</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control border-end-0" name="password_confirmation" required autocomplete="new-password">
                                <button class="btn btn-light border border-start-0" type="button" onclick="toggleVisibility('password-confirm', 'icon-confirm')">
                                    <i class="fas fa-eye text-muted" id="icon-confirm"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success py-2 fw-bold rounded-pill shadow-sm">
                                DAFTAR SEKARANG
                            </button>
                        </div>

                        <div class="text-center text-muted small">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Masuk disini</a>
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