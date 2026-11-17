@extends('layouts.app')
@section('title', 'Data Pre-order')
@section('content')
<h3 class="mb-3">Data Pre-order</h3>

<form method="GET" action="{{ route('admin.preorder.laporan') }}" class="row g-2 align-items-end mb-3">
  <div class="col-auto">
    <label class="form-label small mb-0">Dari tanggal</label>
    <input type="date" name="dari" class="form-control form-control-sm" min="2000-01-01" max="2099-12-31">
  </div>
  <div class="col-auto">
    <label class="form-label small mb-0">Sampai tanggal</label>
    <input type="date" name="sampai" class="form-control form-control-sm" min="2000-01-01" max="2099-12-31">
  </div>
  <div class="col-auto">
    <label class="form-label small mb-0">Status</label>
    <select name="status" class="form-select form-select-sm">
      <option value="">Semua status</option>
      @foreach(['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'] as $s)
        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-auto">
    <button class="btn btn-sm btn-primary">Cetak Laporan PDF</button>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>ID</th><th>Tanggal</th><th>Pemesan</th><th>Rincian</th>
        <th>Total</th><th>Bukti</th><th style="min-width:210px">Status</th>
      </tr>
    </thead>
    <tbody>
    @forelse($orders as $o)
      @php
        $warna = ['menunggu' => 'warning', 'dikonfirmasi' => 'primary', 'selesai' => 'success', 'dibatalkan' => 'danger'][$o->status_pesanan] ?? 'secondary';
      @endphp
      <tr>
        <td>#{{ $o->id_preorder }}</td>
        <td>{{ $o->tanggal_pesanan->translatedFormat('d M Y, H:i') }}</td>
        <td>{{ $o->pengguna->nama_pengguna }}<br><small class="text-muted">{{ $o->pengguna->no_telepon }}</small></td>
        <td>
          @foreach($o->detail as $d)
            {{ $d->produk->jenis_melon }} &times; {{ $d->jumlah_produk }}<br>
          @endforeach
        </td>
        <td>Rp {{ number_format($o->total_harga, 0, ',', '.') }}<br>
            <small class="text-muted">{{ $o->total_jumlah_produk }} item</small></td>
        <td>
          @if($o->bukti_pembayaran)
            <a href="{{ asset('storage/'.$o->bukti_pembayaran) }}" target="_blank">Lihat bukti</a>
          @else
            <span class="text-muted small">Belum ada</span>
          @endif
        </td>
        <td>
          <span class="badge bg-{{ $warna }} mb-2">{{ ucfirst($o->status_pesanan) }}</span>

          @if($o->status_pesanan !== 'dibatalkan')
            <<form method="POST" action="{{ route('admin.preorder.status', $o->id_preorder) }}" class="d-flex gap-1"
                data-id="{{ $o->id_preorder }}" data-status="{{ $o->status_pesanan }}"
                onsubmit="return konfirmasiStatus(this)">
                @csrf
              @method('PATCH')
              <select name="status_pesanan" class="form-select form-select-sm">
                @foreach(['menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'] as $s)
                  <option value="{{ $s }}" @selected($o->status_pesanan === $s)>{{ ucfirst($s) }}</option>
                @endforeach
              </select>
              <button class="btn btn-sm btn-success">Simpan</button>
            </form>
          @endif
        </td>
      </tr>
    @empty
      <tr><td colspan="7" class="text-center text-muted">Belum ada pre-order.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>

<script>
  function konfirmasiStatus(form) {
    const status = form.querySelector('select[name="status_pesanan"]').value;
    const id = form.dataset.id;

    if (status === form.dataset.status) {
      alert('Status pesanan #' + id + ' tidak berubah.');
      return false;
    }

    if (status === 'dibatalkan') {
      return confirm('Batalkan pesanan #' + id + '? Stok produk akan dikembalikan dan pesanan tidak bisa diubah lagi.');
    }

    return confirm('Ubah status pesanan #' + id + ' menjadi "' + status + '"?');
  }
</script>
@endsection