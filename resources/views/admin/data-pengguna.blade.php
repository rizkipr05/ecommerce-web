@extends('layouts.admin')

@section('admin-title', 'Data Pengguna')

@section('admin-content')
<h2 class="section-title mb-3">3. Data Pengguna</h2>
<div class="row g-4">
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
                                <td>{{ $customers->firstItem() + $index }}</td>
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
        <div class="mb-4">{{ $customers->links() }}</div>

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
                                <td>{{ $sellers->firstItem() + $index }}</td>
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
        <div class="mb-4">{{ $sellers->links() }}</div>

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
                                <td>{{ $admins->firstItem() + $index }}</td>
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
        <div class="mt-3">{{ $admins->links() }}</div>
    </div>
</div>
@endsection
