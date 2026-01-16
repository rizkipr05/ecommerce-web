@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <h2 class="fw-bold mb-3">Profil Saya</h2>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="p-3 border rounded-3">
                <div class="text-muted">Nama</div>
                <div class="fw-semibold">{{ $user->name }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 border rounded-3">
                <div class="text-muted">Email</div>
                <div class="fw-semibold">{{ $user->email }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
