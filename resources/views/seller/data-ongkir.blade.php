@extends('layouts.seller')

@section('seller-title', 'Master Data Ongkir')

@section('seller-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title">Master Data Ongkir</h2>
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addOngkir">+ Tambah Data Ongkir</button>
</div>
<div class="card table-shell">
    <div class="card-header">Master Data Ongkir</div>
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
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Harga Ongkir</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rates as $index => $rate)
                    <tr>
                        <td>{{ $rates->firstItem() + $index }}</td>
                        <td>{{ $rate->kabupaten }}</td>
                        <td>{{ $rate->kecamatan }}</td>
                        <td>Rp {{ number_format($rate->price, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary edit-ongkir" data-bs-toggle="modal" data-bs-target="#editOngkir"
                                    data-id="{{ $rate->id }}"
                                    data-kabupaten="{{ $rate->kabupaten }}"
                                    data-kecamatan="{{ $rate->kecamatan }}"
                                    data-price="{{ $rate->price }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form method="POST" action="{{ url('/seller/data-ongkir/' . $rate->id) }}" onsubmit="return confirm('Hapus data ongkir ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
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
    <small class="text-muted">Showing {{ $rates->firstItem() ?? 0 }} to {{ $rates->lastItem() ?? 0 }} of {{ $rates->total() }} entries</small>
    <div>{{ $rates->links() }}</div>
</div>

<div class="modal fade" id="addOngkir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/seller/data-ongkir') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Ongkir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kabupaten</label>
                        <input type="text" name="kabupaten" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Ongkir</label>
                        <input type="number" name="price" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editOngkir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="" id="editOngkirForm">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Ongkir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kabupaten</label>
                        <input type="text" name="kabupaten" class="form-control" id="editKabupaten" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" id="editKecamatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Ongkir</label>
                        <input type="number" name="price" class="form-control" id="editPrice" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.edit-ongkir').forEach(function (button) {
        button.addEventListener('click', function () {
            const form = document.getElementById('editOngkirForm');
            form.action = '{{ url('/seller/data-ongkir') }}/' + this.dataset.id;
            document.getElementById('editKabupaten').value = this.dataset.kabupaten;
            document.getElementById('editKecamatan').value = this.dataset.kecamatan;
            document.getElementById('editPrice').value = this.dataset.price;
        });
    });
</script>
@endsection
