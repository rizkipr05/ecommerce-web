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
                            <th>Terdaftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sellers as $index => $user)
                            <tr>
                                <td>{{ $sellers->firstItem() + $index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="status-pill" style="background: {{ $user->is_active ? '#16a34a' : '#ef4444' }};">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if ($user->is_active)
                                            <form method="POST" action="{{ url('/admin/sellers/' . $user->id . '/deactivate') }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-outline-danger">Nonaktifkan</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ url('/admin/sellers/' . $user->id . '/activate') }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-outline-success">Aktifkan</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ url('/admin/sellers/' . $user->id) }}" onsubmit="return confirm('Hapus akun seller ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-dark">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada seller.</td>
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
