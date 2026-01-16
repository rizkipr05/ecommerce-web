@extends('layouts.admin')

@section('admin-title', 'Pesanan & Laporan')

@section('admin-content')
<h2 class="section-title mb-3">4. Data Pesanan & Laporan</h2>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">Data Pesanan</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Pesanan</th>
                    <th>Total</th>
                    <th>Tgl Pesanan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $index => $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $index }}</td>
                        <td>#{{ $order->id }}</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
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
<div class="mb-4">{{ $orders->links() }}</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span>Data Invoice</span>
        <button class="btn btn-sm btn-success">Download PDF</button>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Invoice</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Tgl Invoice</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $index => $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $index }}</td>
                        <td>INV-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->customer->name ?? '-' }}</td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada invoice.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
