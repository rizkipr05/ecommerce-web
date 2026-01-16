@extends('layouts.admin')

@section('admin-title', 'Beranda')

@section('admin-content')
<h4 class="section-title mb-2">1. Beranda</h4>
<p class="text-muted">Ringkasan data UMKM Nasi Bakar.</p>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Total Nasi Bakar</small>
                <h4 class="mb-0">{{ $totalProducts }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-basket-fill"></i></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Total Pelanggan</small>
                <h4 class="mb-0">{{ $totalCustomers }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-people-fill"></i></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Total Toko / Seller</small>
                <h4 class="mb-0">{{ $totalSellers }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-shop"></i></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Total Pesanan</small>
                <h4 class="mb-0">{{ $totalOrders }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-receipt"></i></span>
        </div>
    </div>
</div>
@endsection
