@extends('layouts.app')

@section('content')
<div class="customer-shell">
    <nav class="navbar navbar-expand-lg navbar-light customer-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/beranda') }}">
                <span class="badge bg-success">KSP</span>
                <span class="ms-1">Klontong</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav" aria-controls="customerNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="customerNav">
                <div class="d-flex flex-column flex-lg-row w-100 align-items-lg-center gap-2">
                    <ul class="navbar-nav mx-lg-auto align-items-lg-center gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('beranda') ? 'active' : '' }}" href="{{ url('/beranda') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('toko') ? 'active' : '' }}" href="{{ url('/toko') }}">Toko</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('hubungi-kami') ? 'active' : '' }}" href="{{ url('/hubungi-kami') }}">Hubungi Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('tentang') ? 'active' : '' }}" href="{{ url('/tentang') }}">Tentang</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-lg-auto align-items-lg-center gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('keranjang') ? 'active' : '' }}" href="{{ url('/keranjang') }}">
                                <i class="bi bi-bag"></i>
                            </a>
                        </li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="customerMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customerMenu">
                                    <li><a class="dropdown-item" href="{{ url('/profil') }}">Profil Saya</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/dashboard') }}">Pesanan Saya</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ url('/logout') }}">
                                            @csrf
                                            <button class="dropdown-item">Keluar</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-success btn-sm" href="{{ url('/login') }}">Masuk</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @yield('customer-content')
    </div>
</div>

<style>
    .customer-shell {
        background: #ffffff;
        min-height: 100vh;
    }

    .customer-navbar {
        background: #78c83d;
        border-bottom: 3px solid #1f7f2f;
    }

    .customer-navbar .nav-link {
        font-weight: 600;
        color: #1f2d1f;
    }

    .customer-navbar .nav-link.active {
        color: #0f5f1d;
    }

    .customer-card {
        border: 2px solid #1f7f2f;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 10px 18px rgba(15, 20, 18, 0.12);
    }

    .customer-banner {
        background: #0b6b1f;
        color: #fff;
        border-radius: 10px;
        padding: 16px 24px;
        text-align: center;
        font-weight: 700;
        font-size: 1.3rem;
        letter-spacing: 0.04em;
    }

    .store-card {
        border: 1px solid #e1e4e8;
        border-left: 4px solid #1f7f2f;
        border-radius: 12px;
        padding: 16px;
        background: #fff;
    }
</style>
@endsection
