@extends('layouts.app')

@section('content')
<div class="row g-0 min-vh-100">
    <div class="col-lg-2">
        <div class="sidebar p-3 p-lg-4 h-100 rounded-0">
            <h4 class="fw-bold mb-4 text-white">Administrator</h4>
            <nav class="nav flex-column gap-2">
                <a class="btn btn-light text-start {{ request()->is('admin/beranda') ? 'active' : '' }}" href="{{ url('/admin/beranda') }}">Beranda</a>
                <a class="btn btn-light text-start {{ request()->is('admin/data-nasi-bakar') ? 'active' : '' }}" href="{{ url('/admin/data-nasi-bakar') }}">Data Nasi Bakar</a>
                <a class="btn btn-light text-start {{ request()->is('admin/data-pengguna') ? 'active' : '' }}" href="{{ url('/admin/data-pengguna') }}">Data Pengguna</a>
                <a class="btn btn-light text-start {{ request()->is('admin/pesanan-laporan') ? 'active' : '' }}" href="{{ url('/admin/pesanan-laporan') }}">Pesanan & Laporan</a>
                <div class="sidebar-divider"></div>
                <div class="sidebar-section">Master Data</div>
                <a class="btn btn-light text-start {{ request()->is('admin/customers') ? 'active' : '' }}" href="{{ url('/admin/customers') }}">Customer</a>
                <a class="btn btn-light text-start {{ request()->is('admin/customer-reviews') ? 'active' : '' }}" href="{{ url('/admin/customer-reviews') }}">Customer Review</a>
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
                <div class="fw-semibold text-muted">@yield('admin-title', 'Beranda')</div>
                <div class="d-flex align-items-center gap-2">
                    <span class="small text-muted">{{ auth()->user()->name }}</span>
                    <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                        <i class="bi bi-person-fill text-secondary"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                @yield('admin-content')
            </div>
        </div>
    </div>
</div>
@endsection
