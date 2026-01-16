@extends('layouts.seller')

@section('seller-title', 'Dashboard')

@section('seller-content')
<h2 class="section-title mb-3">Beranda Dashboard</h2>
<div class="row g-3">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Jumlah Sayuran</small>
                <h4 class="mb-0">{{ $totalProducts }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-basket-fill"></i></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Pesanan Masuk</small>
                <h4 class="mb-0">{{ $totalOrders }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-box-arrow-in-right"></i></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Pesanan Terkirim</small>
                <h4 class="mb-0">{{ $shippedOrders }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-box-arrow-up-right"></i></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card p-3 bg-white d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">Total Invoice</small>
                <h4 class="mb-0">{{ $totalOrders }}</h4>
            </div>
            <span class="stat-icon"><i class="bi bi-receipt"></i></span>
        </div>
    </div>
</div>
@endsection
