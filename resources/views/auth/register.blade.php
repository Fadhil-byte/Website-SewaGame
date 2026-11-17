@extends('layouts.app')

@section('title', 'Daftar Akun Baru - SewaGame')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <span class="brand-icon-box mx-auto mb-3" style="width: 48px; height: 48px; font-size: 1.5rem;">
                        <i class="bi bi-person-plus"></i>
                    </span>
                    <h3 class="fw-bold mb-1">Buat Akun Baru</h3>
                    <p class="text-muted small mb-0">Daftar sekarang untuk mulai menyewa berbagai game PC & Android.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" placeholder="Nama Anda" required value="{{ old('name') }}">
                        </div>
                        @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" placeholder="nama@email.com" required value="{{ old('email') }}">
                        </div>
                        @error('email')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" placeholder="Min. 8 karakter" required>
                            </div>
                            @error('password')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="password_confirmation" class="form-label">Ulangi Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 ps-0" id="password_confirmation" name="password_confirmation" placeholder="Ulangi sandi" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fs-6 mb-3">
                        <i class="bi bi-person-check-fill me-1"></i> Selesaikan Pendaftaran
                    </button>
                </form>

                <div class="text-center pt-3 border-top">
                    <p class="text-muted small mb-0">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="fw-bold text-primary">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
