@extends('layouts.seller')

@section('seller-title', 'Konfirmasi Pesanan')

@section('seller-content')
<h2 class="section-title mb-3">Konfirmasi Pesanan</h2>
<div class="card table-shell">
    <div class="card-header">Konfirmasi Pesanan</div>
    <div class="table-toolbar">
        <div>
            Show
            <select class="form-select d-inline-block w-auto ms-1 me-1">
                <option>5</option>
                <option selected>10</option>
                <option>25</option>
            </select>
            entries
        </div>
        <div class="d-flex align-items-center gap-2">
            <span>Search:</span>
            <input class="form-control form-control-sm" style="width: 160px;" type="text" placeholder="">
        </div>
    </div>
    <div class="table-responsive">
        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl. Pesanan</th>
                    <th>Nomor Pesanan</th>
                    <th>Tipe Pembayaran</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orderItems as $index => $item)
                    <tr>
                        <td>{{ $orderItems->firstItem() + $index }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>#{{ $item->order_id }}</td>
                        <td>Transfer</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ url('/seller/konfirmasi-pesanan/' . $item->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-success">Konfirmasi</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No data available in table</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">Showing {{ $orderItems->firstItem() }} to {{ $orderItems->lastItem() }} of {{ $orderItems->total() }} entries</small>
    <div>{{ $orderItems->links() }}</div>
</div>
@endsection
