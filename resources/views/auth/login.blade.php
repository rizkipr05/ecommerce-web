@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="card login-card border-0">
        <div class="row g-0">
            <div class="col-md-5 login-side p-4 p-lg-5 d-flex flex-column justify-content-between">
                <div>
                    <span class="badge badge-role text-uppercase mb-3">{{ $role }}</span>
                    <h2 class="fw-bold mb-3">Masuk sebagai {{ ucfirst($role) }}</h2>
                    <p class="mb-0">Akses dashboard {{ $role }} dengan aman dan terpisah.</p>
                </div>
                <div class="mt-4 text-white-50 small">UMKM Nasi Bakar</div>
            </div>
            <div class="col-md-7 p-4 p-lg-5 bg-white">
                <h4 class="section-title mb-1">{{ $title }}</h4>
                <p class="text-muted mb-4">Silakan masuk untuk melanjutkan.</p>
                <form method="POST" action="{{ url($role === 'customer' ? '/login' : '/' . $role . '/login') }}">
                    @csrf
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
                    <button class="btn btn-dark w-100" type="submit">Login</button>
                </form>
                <div class="d-flex justify-content-between align-items-center mt-4 small">
                    <span class="text-muted">Belum punya akun?</span>
                    @if ($role === 'customer')
                        <a href="{{ url('/register') }}" class="text-decoration-none">Daftar</a>
                    @elseif ($role === 'seller')
                        <a href="{{ url('/seller/register') }}" class="text-decoration-none">Daftar</a>
                    @endif
                </div>
                <div class="mt-3 small text-muted">Admin: admin@gmail.com / admin123</div>
            </div>
        </div>
    </div>
</div>
@endsection
