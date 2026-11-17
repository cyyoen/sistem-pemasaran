@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h3 class="mb-3">Registrasi Pengguna</h3>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">No. Telepon</label>
        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password (minimal 8 karakter)</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Ulangi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>
      <button class="btn btn-success w-100">Daftar</button>
    </form>
  </div>
</div>
@endsection