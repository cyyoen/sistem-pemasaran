@extends('layouts.app')
@section('title', 'Kelola Produk')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Data Produk Melon</h3>
  <a href="{{ route('admin.produk.create') }}" class="btn btn-success">+ Tambah Produk</a>
</div>

<div class="table-responsive">
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>No</th><th>Gambar</th><th>Jenis Melon</th><th>Harga</th><th>Stok</th>
        <th style="width:170px">Aksi</th>
      </tr>
    </thead>
    <tbody>
    @forelse($produk as $i => $p)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>
          @if($p->gambar_produk)
            <img src="{{ asset('storage/'.$p->gambar_produk) }}" alt="{{ $p->jenis_melon }}"
                 style="width:64px;height:64px;object-fit:cover" class="rounded">
          @else
            <span class="text-muted small">Tidak ada</span>
          @endif
        </td>
        <td>{{ $p->jenis_melon }}</td>
        <td>Rp {{ number_format($p->harga_produk, 0, ',', '.') }}</td>
        <td>{{ $p->stok_jenis }}</td>
        <td>
          <a href="{{ route('admin.produk.edit', $p) }}" class="btn btn-sm btn-warning">Ubah</a>
          <form method="POST" action="{{ route('admin.produk.destroy', $p) }}" class="d-inline"
                data-konfirmasi="Hapus produk {{ $p->jenis_melon }}?"
                onsubmit="return confirm(this.dataset.konfirmasi)">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Hapus</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="6" class="text-center text-muted">Belum ada produk. Klik "Tambah Produk".</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
@endsection