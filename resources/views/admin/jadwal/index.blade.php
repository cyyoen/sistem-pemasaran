@extends('layouts.admin')
@section('title', 'Kelola Jadwal Panen')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Jadwal Panen</h3>
  <a href="{{ route('admin.jadwal.create') }}" class="btn btn-success">+ Tambah Jadwal</a>
</div>

<div class="table-responsive">
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr><th>No</th><th>Tanggal Panen</th><th>Keterangan</th><th style="width:170px">Aksi</th></tr>
    </thead>
    <tbody>
    @forelse($jadwal as $i => $j)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $j->jadwal_panen->translatedFormat('l, d F Y') }}</td>
        <td>
          @if($j->jadwal_panen->isFuture() || $j->jadwal_panen->isToday())
            <span class="badge bg-success">Akan datang</span>
          @else
            <span class="badge bg-secondary">Sudah lewat</span>
          @endif
        </td>
        <td>
            <form method="POST" action="{{ route('admin.jadwal.destroy', $j) }}" class="d-inline"
             data-konfirmasi="Hapus jadwal panen {{ $j->jadwal_panen->translatedFormat('d F Y') }}?"
            onsubmit="return confirm(this.dataset.konfirmasi)">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="4" class="text-center text-muted">Belum ada jadwal panen.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
@endsection