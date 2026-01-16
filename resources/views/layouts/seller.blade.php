@extends('layouts.app')

@section('content')
<div class="row g-0 min-vh-100">
    <div class="col-lg-2">
        <div class="sidebar p-3 p-lg-4 h-100 rounded-0">
            <h4 class="fw-bold mb-4 text-white">Seller</h4>
            <nav class="nav flex-column gap-2">
                <a class="btn btn-light text-start {{ request()->is('seller/beranda') ? 'active' : '' }}" href="{{ url('/seller/beranda') }}">Beranda</a>
                <div class="sidebar-divider"></div>
                <div class="sidebar-section">Master Data</div>
                <a class="btn btn-light text-start {{ request()->is('seller/data-sayuran') ? 'active' : '' }}" href="{{ url('/seller/data-sayuran') }}">Data Sayuran</a>
                <a class="btn btn-light text-start {{ request()->is('seller/data-ongkir') ? 'active' : '' }}" href="{{ url('/seller/data-ongkir') }}">Data Ongkir</a>
                <div class="sidebar-divider"></div>
                <div class="sidebar-section">Fitur Utama</div>
                <button class="btn btn-light text-start d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#sellerOrders" aria-expanded="{{ request()->is('seller/pesanan') || request()->is('seller/konfirmasi-pesanan') ? 'true' : 'false' }}" aria-controls="sellerOrders">
                    <span>Pesanan</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="collapse {{ request()->is('seller/pesanan') || request()->is('seller/konfirmasi-pesanan') ? 'show' : '' }}" id="sellerOrders">
                    <div class="ps-3 d-flex flex-column gap-2 mt-2">
                        <a class="btn btn-light text-start {{ request()->is('seller/pesanan') ? 'active' : '' }}" href="{{ url('/seller/pesanan') }}">Data Pesanan</a>
                        <a class="btn btn-light text-start {{ request()->is('seller/konfirmasi-pesanan') ? 'active' : '' }}" href="{{ url('/seller/konfirmasi-pesanan') }}">Konfirmasi Pesanan</a>
                    </div>
                </div>
                <a class="btn btn-light text-start {{ request()->is('seller/laporan') ? 'active' : '' }}" href="{{ url('/seller/laporan') }}">Laporan</a>
            </nav>
            <form method="POST" action="{{ url('/logout') }}" class="mt-4">
                @csrf
                <button class="btn btn-logout btn-sm w-100">Logout</button>
            </form>
        </div>
    </div>
    <div class="col-lg-10">
        <div class="admin-shell h-100 rounded-0">
            <div class="admin-topbar px-4 py-3 d-flex justify-content-between align-items-center">
                <div class="fw-semibold text-muted">@yield('seller-title', 'Dashboard')</div>
                <div class="d-flex align-items-center gap-2">
                    <span class="small text-muted">{{ auth()->user()->name }}</span>
                    <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                        <i class="bi bi-person-fill text-secondary"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                @yield('seller-content')
            </div>
        </div>
    </div>
</div>
@endsection
