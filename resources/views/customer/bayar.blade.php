@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <h2 class="fw-bold mb-3">Upload Bukti Pembayaran</h2>
    <p class="text-muted">Order #{{ $order->id }} - Total Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

    <form method="POST" action="{{ url('/pesanan/' . $order->id . '/bayar') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Pilih File (jpg/png/pdf)</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button class="btn btn-success">Upload</button>
    </form>
</div>
@endsection
