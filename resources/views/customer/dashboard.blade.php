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
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
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
