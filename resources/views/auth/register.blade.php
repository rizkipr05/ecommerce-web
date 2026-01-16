@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="card login-card border-0">
        <div class="row g-0">
            <div class="col-md-5 login-side p-4 p-lg-5 d-flex flex-column justify-content-between">
                <div>
                    <span class="badge badge-role text-uppercase mb-3">{{ $role }}</span>
                    <h2 class="fw-bold mb-3">Daftar sebagai {{ ucfirst($role) }}</h2>
                    <p class="mb-0">Isi data berikut untuk membuat akun {{ $role }}.</p>
                </div>
                <div class="mt-4 text-white-50 small">UMKM Nasi Bakar</div>
            </div>
            <div class="col-md-7 p-4 p-lg-5 bg-white">
                <h4 class="section-title mb-1">{{ $title }}</h4>
                <p class="text-muted mb-4">Lengkapi data untuk melanjutkan.</p>
                <form method="POST" action="{{ url($role === 'customer' ? '/register' : '/' . $role . '/register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button class="btn btn-dark w-100" type="submit">Register</button>
                </form>
                <div class="d-flex justify-content-between align-items-center mt-4 small">
                    <span class="text-muted">Sudah punya akun?</span>
                    @if ($role === 'customer')
                        <a href="{{ url('/login') }}" class="text-decoration-none">Masuk</a>
                    @elseif ($role === 'seller')
                        <a href="{{ url('/seller/login') }}" class="text-decoration-none">Masuk</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
