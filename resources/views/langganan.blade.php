@extends('layouts.app')
@section('title', 'Notifikasi Panen')
@section('content')
<h3 class="mb-3">Notifikasi Panen</h3>

<div class="card mb-4">
  <div class="card-body">
    @php $aktif = $langganan && $langganan->status_langganan === 'aktif'; @endphp

    <p class="mb-1">Status langganan:
      @if($aktif)
        <span class="badge bg-success">Aktif</span>
      @else
        <span class="badge bg-secondary">Tidak aktif</span>
      @endif
    </p>

    @if($langganan)
      <p class="text-muted small mb-2">Berlangganan sejak {{ $langganan->tanggal_langganan->translatedFormat('d F Y') }}</p>
    @endif

    <p class="mb-3">
      Pengingat jadwal panen dikirim ke email
      <strong>{{ Auth::guard('web')->user()->email }}</strong>.
    </p>

    <form method="POST" action="{{ route('langganan.toggle') }}">
      @csrf
      @if($aktif)
        <button class="btn btn-outline-danger">Nonaktifkan Notifikasi</button>
      @else
        <button class="btn btn-success">Aktifkan Notifikasi</button>
      @endif
    </form>
  </div>
</div>

<h5>Jadwal Panen yang Akan Datang</h5>
<ul class="list-group">
  @forelse($jadwal as $j)
    <li class="list-group-item">{{ $j->jadwal_panen->translatedFormat('l, d F Y') }}</li>
  @empty
    <li class="list-group-item text-muted">Belum ada jadwal panen yang akan datang.</li>
  @endforelse
</ul>
@endsection