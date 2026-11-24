@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Pesanan Saya</h3>
  <a href="{{ route('produk.publik') }}" class="btn btn-success">+ Pesan Lagi</a>
</div>

@forelse($orders as $o)
  @php
    $warna = ['menunggu' => 'warning', 'dikonfirmasi' => 'primary', 'selesai' => 'success', 'dibatalkan' => 'danger'][$o->status_pesanan] ?? 'secondary';
  @endphp
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span>Pesanan #{{ $o->id_preorder }} &middot; {{ $o->tanggal_pesanan->translatedFormat('d F Y, H:i') }}</span>
      <span class="badge bg-{{ $warna }}">{{ ucfirst($o->status_pesanan) }}</span>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm mb-2">
          <thead><tr><th>Produk</th><th>Jumlah (buah)</th><th>Harga / buah</th><th>Subtotal</th></tr></thead>
          <tbody>
          @foreach($o->detail as $d)
            <tr>
              <td>{{ $d->produk->jenis_melon }}</td>
              <td>{{ $d->jumlah_produk }}</td>
              <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      <p class="mb-3">Total ({{ $o->total_jumlah_produk }} buah):
        <strong>Rp {{ number_format($o->total_harga, 0, ',', '.') }}</strong></p>

      @if($o->bukti_pembayaran)
        <p class="mb-1">Bukti pembayaran:</p>
        <a href="{{ asset('storage/'.$o->bukti_pembayaran) }}" target="_blank">
          <img src="{{ asset('storage/'.$o->bukti_pembayaran) }}" alt="Bukti pembayaran"
               class="img-thumbnail mb-2" style="max-height:120px">
        </a>
      @endif

      @if($o->status_pesanan === 'menunggu')
        <form method="POST" action="{{ route('preorder.bukti', $o->id_preorder) }}" enctype="multipart/form-data"
              class="row g-2 align-items-center">
          @csrf
          <div class="col-auto">
            <input type="file" name="bukti_pembayaran" class="form-control form-control-sm"
                   accept="image/png,image/jpeg,image/webp" required>
          </div>
          <div class="col-auto">
            <button class="btn btn-sm btn-success">
              {{ $o->bukti_pembayaran ? 'Ganti Bukti' : 'Unggah Bukti Pembayaran' }}
            </button>
          </div>
        </form>
        <div class="form-text">Format JPG, PNG, atau WEBP, maksimal 5 MB.</div>
      @endif
    </div>
  </div>
@empty
 <div class="alert alert-light border">
  Kamu belum punya pesanan. <a href="{{ route('produk.publik') }}">Pesan melon sekarang</a>.
</div>
@endforelse
@endsection