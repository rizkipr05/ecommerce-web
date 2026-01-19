@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <h2 class="fw-bold mb-3">Pesanan Saya</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        <script>
            alert(@json(session('success')));
        </script>
    @endif
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if (in_array($order->status, ['pending_payment', 'payment_uploaded'], true))
                                <a class="btn btn-sm btn-success" href="{{ url('/pesanan/' . $order->id . '/bayar') }}">Upload Bukti</a>
                            @elseif ($order->status === 'delivered')
                                @if ($order->review)
                                    <span class="text-muted">Ulasan terkirim</span>
                                @else
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="collapse" data-bs-target="#review{{ $order->id }}">Beri Ulasan</button>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @if ($order->status === 'delivered' && !$order->review)
                        <tr class="collapse" id="review{{ $order->id }}">
                            <td colspan="5">
                                <form method="POST" action="{{ url('/pesanan/' . $order->id . '/review') }}" class="row g-2 align-items-center">
                                    @csrf
                                    <div class="col-md-2">
                                        <select name="rating" class="form-select" required>
                                            <option value="">Rating</option>
                                            <option value="5">5</option>
                                            <option value="4">4</option>
                                            <option value="3">3</option>
                                            <option value="2">2</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="comment" class="form-control" placeholder="Tulis ulasan (opsional)">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success w-100">Kirim</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
