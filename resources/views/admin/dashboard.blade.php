@extends('layouts.app')

@section('content')
<div class="page-shell p-4 p-lg-5">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4">
        <h1 class="hero-title mb-3 mb-lg-0">Admin</h1>
        <div class="d-flex align-items-center gap-3">
            <span class="badge badge-role">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button class="btn btn-outline-dark btn-sm">Logout</button>
            </form>
        </div>
    </div>

    <section class="mb-5">
        <div class="d-flex align-items-start gap-3 flex-column flex-lg-row">
            <div class="flex-grow-1">
                <h3 class="section-title">1. Beranda</h3>
                <p class="text-muted mb-4">Ringkasan data UMKM Nasi Bakar.</p>
                <div class="row g-3">
                    <div class="col-md-6 col-xl-3">
                        <div class="metric-card p-3 bg-white">
                            <small class="text-muted">Total Nasi Bakar</small>
                            <h4 class="mb-0">{{ $totalProducts }}</h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="metric-card p-3 bg-white">
                            <small class="text-muted">Total Pelanggan</small>
                            <h4 class="mb-0">{{ $totalCustomers }}</h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="metric-card p-3 bg-white">
                            <small class="text-muted">Total Toko / Seller</small>
                            <h4 class="mb-0">{{ $totalSellers }}</h4>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="metric-card p-3 bg-white">
                            <small class="text-muted">Total Pesanan</small>
                            <h4 class="mb-0">{{ $totalOrders }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 rounded-4" style="background: #a9c5cf; min-width: 220px;">
                <strong>Beranda</strong>
                <div class="small mt-2">Total Nasi Bakar</div>
                <div class="small">Total Pelanggan</div>
                <div class="small">Total Toko / seller</div>
                <div class="small">Total Pesanan</div>
            </div>
        </div>

        <div class="row g-4 mt-3">
            <div class="col-lg-6">
                <div class="chart-card">Tambahkan grafik pendapatan perbulan</div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">Tambahkan grafik nasi bakar terlaris perbulan</div>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <h3 class="section-title">2. Data Nasi Bakar</h3>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white fw-semibold">Master Data Nasi Bakar</div>
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
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
        <div class="mt-3 fw-semibold">Sesuaikan dengan nasi bakar</div>
    </section>

    <section class="mb-5">
        <h3 class="section-title">3. Data Pengguna</h3>
        <div class="row g-4 mt-2">
            <div class="col-lg-4">
                <div class="p-4 rounded-4" style="background:#a9c5cf;">
                    <div class="fs-4 fw-bold">Customer</div>
                    <div class="fs-4 fw-bold">Seller</div>
                    <div class="fs-4 fw-bold">Administrator</div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">Master Data Customer</div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada customer.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">Master Data Seller</div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sellers as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada seller.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">Master Data Administrator</div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada admin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <h3 class="section-title">4. Data Pesanan</h3>
        <div class="card border-0 shadow-sm mt-3">
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
                                <td>{{ $index + 1 }}</td>
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
    </section>

    <section>
        <h3 class="section-title">5. Laporan</h3>
        <div class="card border-0 shadow-sm mt-3">
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
                                <td>{{ $index + 1 }}</td>
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
    </section>
</div>
@endsection
