@extends('layouts.seller')

@section('seller-title', 'Master Data Sayuran')

@section('seller-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title">Master Data Sayuran</h2>
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addSayuran">+ Tambah Data Sayur</button>
</div>
<div class="card table-shell">
    <div class="card-header">Master Data Sayuran</div>
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
                    <th>Sayuran</th>
                    <th>Harga</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td>{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td><span class="status-pill">{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary edit-sayuran" data-bs-toggle="modal" data-bs-target="#editSayuran"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-category="{{ $product->category_id }}"
                                    data-description="{{ $product->description }}"
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->stock }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form method="POST" action="{{ url('/seller/data-sayuran/' . $product->id) }}" onsubmit="return confirm('Hapus data sayuran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data.</td>
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

<div class="modal fade" id="addSayuran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ url('/seller/data-sayuran') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Sayur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Sayuran</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Foto</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
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

<div class="modal fade" id="editSayuran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="" id="editSayuranForm" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Sayur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" id="editCategory" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Sayuran</label>
                            <input type="text" name="name" class="form-control" id="editName" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" id="editDescription" rows="2"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control" id="editPrice" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" id="editStock" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Foto (opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
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
    document.querySelectorAll('.edit-sayuran').forEach(function (button) {
        button.addEventListener('click', function () {
            const form = document.getElementById('editSayuranForm');
            form.action = '{{ url('/seller/data-sayuran') }}/' + this.dataset.id;
            document.getElementById('editName').value = this.dataset.name;
            document.getElementById('editCategory').value = this.dataset.category;
            document.getElementById('editDescription').value = this.dataset.description || '';
            document.getElementById('editPrice').value = this.dataset.price;
            document.getElementById('editStock').value = this.dataset.stock;
        });
    });
</script>
@endsection
