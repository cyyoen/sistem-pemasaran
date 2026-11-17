@extends('layouts.app')
@section('title', $produk->exists ? 'Ubah Produk' : 'Tambah Produk')
@section('content')
<div class="row">
  <div class="col-md-6">
    <h3 class="mb-3">{{ $produk->exists ? 'Ubah' : 'Tambah' }} Produk</h3>

    <form method="POST" enctype="multipart/form-data"
          action="{{ $produk->exists ? route('admin.produk.update', $produk) : route('admin.produk.store') }}">
      @csrf
      @if($produk->exists) @method('PUT') @endif

      <div class="mb-3">
        <label class="form-label">Jenis Melon</label>
        <input type="text" name="jenis_melon" class="form-control" maxlength="50"
               value="{{ old('jenis_melon', $produk->jenis_melon) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="harga_produk" class="form-control" min="0" step="1000"
               value="{{ old('harga_produk', $produk->exists ? (int) $produk->harga_produk : '') }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Stok</label>
        <input type="number" name="stok_jenis" class="form-control" min="0" step="1"
               value="{{ old('stok_jenis', $produk->stok_jenis) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Gambar Melon</label>

        @if($produk->exists && $produk->gambar_produk)
          <div class="mb-2">
            <img src="{{ asset('storage/'.$produk->gambar_produk) }}" alt="{{ $produk->jenis_melon }}"
                 class="img-thumbnail" style="max-height:160px">
          </div>
        @endif

        <input type="file" name="gambar_produk" id="gambar_produk" class="form-control"
               accept="image/png,image/jpeg,image/webp">
        <div class="form-text">
          Format JPG, PNG, atau WEBP, maksimal 2 MB.
          @if($produk->exists) Kosongkan jika tidak ingin mengganti gambar. @endif
        </div>

        <img id="pratinjau" class="img-thumbnail mt-2 d-none" style="max-height:160px" alt="Pratinjau">
      </div>

      <button class="btn btn-success">Simpan</button>
      <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>

<script>
  document.getElementById('gambar_produk').addEventListener('change', function () {
    const img = document.getElementById('pratinjau');
    const file = this.files[0];
    if (file) {
      img.src = URL.createObjectURL(file);
      img.classList.remove('d-none');
    } else {
      img.classList.add('d-none');
    }
  });
</script>
@endsection