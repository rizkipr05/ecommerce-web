@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <div class="alert alert-success">Untuk belanja, silakan klik menu Toko terlebih dahulu.</div>
    <h2 class="fw-bold mb-2">Selamat Datang</h2>
    <p class="text-muted">Belanja nasi bakar UMKM dengan mudah dan cepat.</p>
    <div class="row g-4 mt-2">
        <div class="col-lg-4">
            <div class="p-3 border rounded-3">
                <h5 class="fw-bold">Promo Mingguan</h5>
                <p class="mb-0">Diskon menu favorit setiap akhir pekan.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-3 border rounded-3">
                <h5 class="fw-bold">Toko Terdekat</h5>
                <p class="mb-0">Cari seller terdekat di menu Toko.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-3 border rounded-3">
                <h5 class="fw-bold">Pesanan Saya</h5>
                <p class="mb-0">Lacak status pesanan langsung dari akun kamu.</p>
            </div>
        </div>
    </div>
</div>
@endsection
