@extends('layouts.app')

@section('title', 'Masuk ke Akun - SewaGame')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <span class="brand-icon-box mx-auto mb-3" style="width: 48px; height: 48px; font-size: 1.5rem;">
                        <i class="bi bi-controller"></i>
                    </span>
                    <h3 class="fw-bold mb-1">Selamat Datang Kembali</h3>
                    <p class="text-muted small mb-0">Masuk ke akun Anda untuk mulai menyewa game favorit.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-dismissible fade show p-3 mb-4 border-0" style="background-color: #fff1f2; color: #be123c; border-radius: 12px;" role="alert">
                        <div class="d-flex align-items-center gap-2 small">
                            <i class="bi bi-exclamation-circle-fill flex-shrink-0 fs-6"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label mb-0">Kata Sandi</label>
                        </div>
                        <div class="input-group mt-1">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small text-muted cursor-pointer" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fs-6 mb-3">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                    </button>
                </form>

                <!-- Quick Demo Login Helper -->
                <div class="p-3 rounded-3 bg-light text-muted small mb-3 border">
                    <span class="fw-bold text-dark d-block mb-1"><i class="bi bi-info-circle text-primary me-1"></i> Akun Demo Tersedia:</span>
                    <div class="d-flex flex-column gap-1" style="font-size: 0.775rem;">
                        <div>Admin: <code>admin@sewagame.com</code> / <code>password</code></div>
                        <div>Pembeli: <code>pembeli@sewagame.com</code> / <code>password</code></div>
                    </div>
                </div>

                <div class="text-center pt-2 border-top">
                    <p class="text-muted small mb-0">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}" class="fw-bold text-primary">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
