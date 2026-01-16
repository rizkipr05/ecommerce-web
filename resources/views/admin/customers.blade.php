@extends('layouts.admin')

@section('admin-title', 'Customer')

@section('admin-content')
<h2 class="section-title mb-3">Customer</h2>
<div class="card table-shell">
    <div class="card-header">Master Data Customer</div>
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
                    <th>Email</th>
                    <th>Terdaftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $index => $user)
                    <tr>
                        <td>{{ $customers->firstItem() + $index }}</td>
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
                                    <form method="POST" action="{{ url('/admin/customers/' . $user->id . '/deactivate') }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger">Nonaktifkan</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ url('/admin/customers/' . $user->id . '/activate') }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-success">Aktifkan</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ url('/admin/customers/' . $user->id) }}" onsubmit="return confirm('Hapus akun customer ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-dark">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada customer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries</small>
    <div>{{ $customers->links() }}</div>
</div>
@endsection
