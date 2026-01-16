@extends('layouts.admin')

@section('admin-title', 'Data Nasi Bakar')

@section('admin-content')
<h2 class="section-title mb-3">2. Data Nasi Bakar</h2>
<div class="card table-shell">
    <div class="card-header">Master Data Nasi Bakar</div>
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
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Seller</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td>{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td><span class="status-pill">{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</span></td>
                        <td>{{ $product->seller->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries</small>
    <div>{{ $products->links() }}</div>
</div>
@endsection
