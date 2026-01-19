@extends('layouts.customer')

@section('customer-content')
<div class="customer-card p-4">
    <div class="customer-banner mb-4">Toko KASEP KLONTONG</div>

    <form class="row align-items-center mb-4" method="GET" action="{{ url('/toko') }}">
        <div class="col-md-2 fw-semibold">Pencarian</div>
        <div class="col-md-7">
            <input class="form-control" name="q" value="{{ $search }}" placeholder="Cari Toko...">
        </div>
        <div class="col-md-3 text-md-end mt-2 mt-md-0">
            <button class="btn btn-success px-4">Cari</button>
        </div>
    </form>

    <div class="d-flex flex-column gap-3">
        @forelse ($sellers as $seller)
            <div class="store-card d-flex flex-column flex-md-row align-items-center gap-4">
                <div class="border rounded-3 p-3" style="width: 140px; height: 140px; background:#f5f7f8; display:flex; align-items:center; justify-content:center;">
                    @if ($seller->profile_image_path)
                        <img src="{{ asset('storage/' . $seller->profile_image_path) }}" alt="{{ $seller->name }}" class="img-fluid rounded-3" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                    @else
                        <span class="text-muted">Logo</span>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-1">{{ $seller->name }}</h5>
                    <div class="text-muted">{{ $seller->email }}</div>
                </div>
                <div>
                    <a class="btn btn-success px-4" href="{{ url('/toko/' . $seller->id) }}">Kunjungi Toko</a>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">Belum ada toko terdaftar.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $sellers->links() }}</div>
</div>
@endsection
