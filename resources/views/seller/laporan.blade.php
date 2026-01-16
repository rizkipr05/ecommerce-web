@extends('layouts.seller')

@section('seller-title', 'Data Invoice')

@section('seller-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title">Data Invoice</h2>
    <button class="btn btn-success btn-sm">Download PDF</button>
</div>
<div class="card table-shell">
    <div class="card-header">Data Invoice</div>
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
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Invoice</th>
                    <th>Customer Email</th>
                    <th>Total</th>
                    <th>Tgl. Invoice</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orderItems as $index => $item)
                    <tr>
                        <td>{{ $orderItems->firstItem() + $index }}</td>
                        <td>INV-{{ str_pad($item->order_id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $item->order->customer->email ?? '-' }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No data available in table</td>
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
