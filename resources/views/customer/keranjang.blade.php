@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <h2 class="fw-bold mb-3">Keranjang</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (count($cart['items']) === 0)
        <p class="text-muted">Keranjang kamu masih kosong. Silakan pilih produk dari menu Toko.</p>
        <button class="btn btn-success" onclick="window.location.href='{{ url('/toko') }}'">Ke Toko</button>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                @php $subtotal = 0; @endphp
                @foreach ($cart['items'] as $item)
                    @php $subtotal += $item['price'] * $item['quantity']; @endphp
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                @if ($item['image_path'])
                                    <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-height: 70px;">
                                @else
                                    <span class="text-muted">Foto</span>
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $item['name'] }}</div>
                                <div class="text-muted">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <form method="POST" action="{{ url('/keranjang/' . $item['product_id']) }}" class="d-flex align-items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" class="form-control form-control-sm" min="1" value="{{ $item['quantity'] }}" style="width: 70px;">
                                <button class="btn btn-sm btn-outline-success">Update</button>
                            </form>
                            <form method="POST" action="{{ url('/keranjang/' . $item['product_id']) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="border rounded-3 p-3">
                    <div class="fw-bold mb-2">Total Keranjang</div>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <a class="btn btn-success w-100" href="{{ url('/checkout') }}">Proses Pesanan</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
