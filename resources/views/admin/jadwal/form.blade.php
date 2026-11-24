@extends('layouts.admin')
@section('title', $jadwal->exists ? 'Ubah Jadwal Panen' : 'Tambah Jadwal Panen')
@section('content')
<div class="row">
  <div class="col-md-5">
    <h3 class="mb-3">{{ $jadwal->exists ? 'Ubah' : 'Tambah' }} Jadwal Panen</h3>

    <form method="POST"
          action="{{ $jadwal->exists ? route('admin.jadwal.update', $jadwal) : route('admin.jadwal.store') }}">
      @csrf
      @if($jadwal->exists) @method('PUT') @endif

      <div class="mb-3">
        <label class="form-label">Tanggal Panen</label>
        <input type="date" name="jadwal_panen" class="form-control"
               value="{{ old('jadwal_panen', optional($jadwal->jadwal_panen)->format('Y-m-d')) }}" required>
      </div>

      <button class="btn btn-success">Simpan</button>
      <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection