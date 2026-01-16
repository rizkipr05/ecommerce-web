@extends('layouts.admin')

@section('admin-title', 'Customer Review')

@section('admin-content')
<h2 class="section-title mb-3">Customer Review</h2>
<div class="card table-shell">
    <div class="card-header">Daftar Review Customer</div>
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
                    <th>Customer</th>
                    <th>Produk</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center">Belum ada review.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-end mt-3">
    <div class="text-muted">Showing 0 to 0 of 0 entries</div>
</div>
@endsection
