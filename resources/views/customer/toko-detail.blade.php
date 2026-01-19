@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <div class="customer-banner mb-4">{{ $seller->name }}</div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
        <a href="{{ url('/toko') }}" class="btn btn-outline-success">Kembali</a>
        <form class="d-flex gap-2" method="GET" action="{{ url('/toko/' . $seller->id) }}">
            <input class="form-control" name="q" value="{{ $search }}" placeholder="Cari produk...">
            <button class="btn btn-success">Cari</button>
        </form>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-md-6 col-lg-3">
                <div class="border rounded-3 p-3 h-100">
                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" style="height: 140px;">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 120px;">
                        @else
                            <span class="text-muted">Foto</span>
                        @endif
                    </div>
                    <h6 class="fw-bold">{{ $product->name }}</h6>
                    <div class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <form method="POST" action="{{ url('/keranjang/add/' . $product->id) }}">
                        @csrf
                        <button class="btn btn-success btn-sm mt-3 w-100">Checkout</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">Belum ada produk.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
