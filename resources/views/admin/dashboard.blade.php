@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
@php
    $kartu = [
        ['Total Pre-order', 'bi-receipt', $jmlPreorder, route('admin.preorder.index')],
        ['Menunggu Konfirmasi', 'bi-hourglass-split', $jmlMenunggu, route('admin.preorder.index')],
        ['Jenis Produk', 'bi-basket', $jmlProduk, route('admin.produk.index')],
        ['Langganan Aktif', 'bi-bell', $jmlLangganan, route('admin.langganan.index')],
    ];
    $warna = ['menunggu' => 'warning', 'dikonfirmasi' => 'primary', 'selesai' => 'success', 'dibatalkan' => 'danger'];
@endphp

<h3 class="mb-4">Dashboard</h3>

<div class="row g-3 mb-4">
  @foreach($kartu as $c)
    <div class="col-6 col-xl-3">
      <a href="{{ $c[3] }}" class="text-decoration-none">
        <div class="card kartu-statistik h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <span class="ikon-bulat mb-0"><i class="bi {{ $c[1] }}"></i></span>
            <div>
              <div class="angka">{{ $c[2] }}</div>
              <div class="small text-muted">{{ $c[0] }}</div>
            </div>
          </div>
        </div>
      </a>
    </div>
  @endforeach
</div>

<div class="row g-3">
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="font-judul">Jadwal Panen Terdekat</h5>
        @if($jadwalTerdekat)
          <p class="fs-4 mb-1">{{ $jadwalTerdekat->jadwal_panen->translatedFormat('d F Y') }}</p>
          <p class="text-muted small mb-0">{{ $jadwalTerdekat->jadwal_panen->translatedFormat('l') }}</p>
        @else
          <p class="text-muted mb-2">Belum ada jadwal panen yang akan datang.</p>
        @endif
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-sm btn-outline-success mt-3">Kelola Jadwal</a>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="font-judul">Pesanan Terbaru</h5>
        <div class="table-responsive">
          <table class="table table-sm align-middle mb-0">
            <thead>
              <tr><th>ID</th><th>Tanggal</th><th>Pemesan</th><th>Uang Muka</th><th>Status</th></tr>
            </thead>
            <tbody>
            @forelse($pesananTerbaru as $o)
              <tr>
                <td>#{{ $o->id_preorder }}</td>
                <td>{{ $o->tanggal_pesanan->translatedFormat('d M Y') }}</td>
                <td>{{ $o->pengguna->nama_pengguna }}</td>
                <td>Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                <td><span class="badge text-bg-{{ $warna[$o->status_pesanan] ?? 'secondary' }}">{{ ucfirst($o->status_pesanan) }}</span></td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted">Belum ada pesanan.</td></tr>
            @endforelse
            </tbody>
          </table>
        </div>
        <a href="{{ route('admin.preorder.index') }}" class="btn btn-sm btn-outline-success mt-3">Lihat Semua Pesanan</a>
      </div>
    </div>
  </div>
</div>
@endsection