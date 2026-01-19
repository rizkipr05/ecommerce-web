@extends('layouts.seller')

@section('seller-title', 'Profil Seller')

@section('seller-content')
<h2 class="section-title mb-3">Profil Seller</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">Pengaturan Profil</div>
    <div class="card-body">
        <form method="POST" action="{{ url('/seller/profil') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row g-4 align-items-center">
                <div class="col-md-4">
                    <div class="d-flex flex-column align-items-center gap-3">
                        @if ($seller->profile_image_path)
                            <img src="{{ asset('storage/' . $seller->profile_image_path) }}" alt="Foto Profil" class="rounded-circle" style="width:140px;height:140px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:140px;height:140px;">
                                <i class="bi bi-person-fill text-secondary" style="font-size:48px;"></i>
                            </div>
                        @endif
                        <div class="w-100">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/png,image/jpeg">
                            <small class="text-muted">JPG/PNG, maks 2MB.</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $seller->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $seller->email) }}" required>
                    </div>
                    <button class="btn btn-success">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
