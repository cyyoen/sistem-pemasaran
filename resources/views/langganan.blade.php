@extends('layouts.app')
@section('title', 'Notifikasi Panen')
@section('content')
@php $aktif = $langganan && $langganan->status_langganan === 'aktif'; @endphp

<div class="row justify-content-center">
  <div class="col-lg-8">
    <h3 class="mb-3">Notifikasi Panen</h3>

    <div class="card mb-4">
      <div class="card-body">
        <p class="mb-1">Status langganan:
          @if($aktif)
            <span class="badge text-bg-success">Aktif</span>
          @else
            <span class="badge text-bg-secondary">Tidak aktif</span>
          @endif
        </p>

        @if($langganan)
          <p class="text-muted small mb-2">
            Berlangganan sejak {{ $langganan->tanggal_langganan->translatedFormat('d F Y') }}
          </p>
        @endif

        <p class="mb-3">
          Email pengingat dikirim ke <strong>{{ Auth::guard('web')->user()->email }}</strong>
          3 hari sebelum jadwal panen.
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

    <h5 class="font-judul">Jadwal Panen yang Akan Datang</h5>
    <ul class="list-group">
      @forelse($jadwal as $j)
        <li class="list-group-item">{{ $j->jadwal_panen->translatedFormat('l, d F Y') }}</li>
      @empty
        <li class="list-group-item text-muted">Belum ada jadwal panen yang akan datang.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection