@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <h2 class="fw-bold mb-3">Checkout</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/checkout') }}">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="mb-3">
                    <label class="form-label">Nama Penerima</label>
                    <input type="text" name="shipping_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telp</label>
                    <input type="text" name="shipping_phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Pengiriman</label>
                    <textarea name="shipping_address" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilih Ongkir</label>
                    <select name="shipping_rate_id" class="form-select" required>
                        <option value="">Pilih ongkir</option>
                        @foreach ($rates as $rate)
                            <option value="{{ $rate->id }}">{{ $rate->kabupaten }} - {{ $rate->kecamatan }} (Rp {{ number_format($rate->price, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="border rounded-3 p-3">
                    <div class="fw-bold mb-2">Detail Pesanan</div>
                    @php $subtotal = 0; @endphp
                    @foreach ($cart['items'] as $item)
                        @php $subtotal += $item['price'] * $item['quantity']; @endphp
                        <div class="d-flex justify-content-between small mb-2">
                            <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                            <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-muted small">Ongkir ditambahkan saat pilih ongkir.</div>
                    <button class="btn btn-success w-100 mt-3">Konfirmasi Pesanan</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
