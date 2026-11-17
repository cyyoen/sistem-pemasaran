@extends('layouts.app')
@section('title', 'Data Langganan Notifikasi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Data Langganan Notifikasi Panen</h3>
  <span class="badge bg-success fs-6">{{ $jmlAktif }} aktif</span>
</div>

<div class="table-responsive">
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr><th>No</th><th>Nama Pengguna</th><th>Email</th><th>No. Telepon</th><th>Tanggal Langganan</th><th>Status</th></tr>
    </thead>
    <tbody>
    @forelse($langganan as $i => $l)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $l->pengguna->nama_pengguna }}</td>
        <td>{{ $l->pengguna->email }}</td>
        <td>{{ $l->pengguna->no_telepon }}</td>
        <td>{{ $l->tanggal_langganan->translatedFormat('d F Y') }}</td>
        <td>
          @if($l->status_langganan === 'aktif')
            <span class="badge bg-success">Aktif</span>
          @else
            <span class="badge bg-secondary">Tidak aktif</span>
          @endif
        </td>
      </tr>
    @empty
      <tr><td colspan="6" class="text-center text-muted">Belum ada pengguna yang berlangganan.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
@endsection