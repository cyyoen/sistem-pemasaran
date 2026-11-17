@extends('layouts.app')
@section('title', 'Pandawa Farm')
@section('content')
<div class="p-4 mb-4 bg-light rounded">
  <h1>Pandawa Farm</h1>
  <p class="lead mb-0">
    Greenhouse melon premium di Desa Nyambu, Tabanan, Bali. Pengunjung bisa memetik melon langsung,
    tanpa biaya masuk, dan membayar sesuai berat buah yang dipetik.
  </p>
</div>

<div class="card mb-4">
  <div class="card-body">
    <h5 class="card-title">Jadwal Panen</h5>

    @if($jadwalMendatang->isEmpty())
      <p class="text-muted mb-0">Belum ada jadwal panen yang akan datang.</p>
    @else
      <ul class="list-group list-group-flush">
        @foreach($jadwalMendatang as $i => $j)
          <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            <span>{{ $j->jadwal_panen->translatedFormat('l, d F Y') }}</span>
            @if($i === 0)
              <span class="badge bg-success">Terdekat</span>
            @endif
          </li>
        @endforeach
      </ul>
    @endif
  </div>
</div>

<a href="{{ route('produk.publik') }}" class="btn btn-success">Lihat dan Pesan Melon</a>
@endsection