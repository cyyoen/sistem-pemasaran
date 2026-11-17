@extends('layouts.app')
@section('title', 'Produk')
@section('content')
@php
  $sebagaiPengguna = Auth::guard('web')->check();
  $sebagaiAdmin    = Auth::guard('admin')->check();
@endphp

<h3 class="mb-3">Produk Melon Premium</h3>

@if(!$sebagaiPengguna)
  <div class="alert alert-info">
    @if($sebagaiAdmin)
      Akun admin tidak dapat melakukan pre-order.
    @else
      Untuk memesan, silakan
      <a href="{{ route('login', ['kembali' => 'produk']) }}">login</a> atau
      <a href="{{ route('register', ['kembali' => 'produk']) }}">daftar</a> terlebih dahulu.
    @endif
  </div>
@endif

@if($sebagaiPengguna)
<form method="POST" action="{{ route('preorder.store') }}">
  @csrf
@endif

  <div class="row g-3">
    @forelse($produk as $p)
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100">
          @if($p->gambar_produk)
            <img src="{{ asset('storage/'.$p->gambar_produk) }}" class="card-img-top"
                 alt="{{ $p->jenis_melon }}" style="height:180px;object-fit:cover">
          @else
            <div class="bg-light text-muted d-flex align-items-center justify-content-center"
                 style="height:180px">Tidak ada gambar</div>
          @endif

          <div class="card-body">
            <h6 class="card-title">{{ $p->jenis_melon }}</h6>
            <p class="mb-1">Rp {{ number_format($p->harga_produk, 0, ',', '.') }}</p>
            @if($p->stok_jenis > 0)
              <small class="text-muted">Stok: {{ $p->stok_jenis }}</small>
            @else
              <span class="badge bg-secondary">Stok habis</span>
            @endif
          </div>

          @if($sebagaiPengguna)
            <div class="card-footer bg-white">
              <label class="form-label small mb-1">Jumlah pesanan</label>
              <input type="number" name="jumlah[{{ $p->id_produk }}]" class="form-control form-control-sm jumlah"
                     min="0" max="{{ $p->stok_jenis }}" step="1"
                     value="{{ old('jumlah.'.$p->id_produk, 0) }}"
                     data-harga="{{ (int) $p->harga_produk }}"
                     @disabled($p->stok_jenis < 1)>
            </div>
          @endif
        </div>
      </div>
    @empty
      <div class="col-12"><p class="text-muted">Belum ada produk.</p></div>
    @endforelse
  </div>

@if($sebagaiPengguna)
  <div class="sticky-bottom bg-white border-top mt-3 py-3 d-flex justify-content-between align-items-center">
    <span class="fs-5">Total: <strong id="total">Rp 0</strong></span>
    <button id="kirim" class="btn btn-success" disabled>Kirim Pre-order</button>
  </div>
</form>

<script>
  const kolom = document.querySelectorAll('.jumlah');
  const total = document.getElementById('total');
  const kirim = document.getElementById('kirim');

  function hitung() {
    let jumlah = 0;
    kolom.forEach(k => jumlah += (parseInt(k.value) || 0) * parseInt(k.dataset.harga));
    total.textContent = 'Rp ' + jumlah.toLocaleString('id-ID');
    kirim.disabled = jumlah === 0;
  }

  kolom.forEach(k => k.addEventListener('input', hitung));
  hitung();
</script>
@endif
@endsection