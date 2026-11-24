@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10 col-xl-9">
    <div class="card overflow-hidden shadow-sm">
      <div class="row g-0">
        <div class="col-md-5 d-none d-md-block">
          @include('partials.panel-auth', [
              'judul' => 'Bergabung Bersama Kami',
              'teks'  => 'Daftar untuk mengamankan jatah melon premium dan menerima pengingat jadwal panen.',
          ])
        </div>

        <div class="col-md-7">
          <div class="p-4 p-lg-5">
            <h3 class="mb-4">Registrasi Pengguna</h3>
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna') }}" class="form-control" required>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">No. Telepon</label>
                  <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-control" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Password (minimal 8 karakter)</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-4">
                  <label class="form-label">Ulangi Password</label>
                  <input type="password" name="password_confirmation" class="form-control" required>
                </div>
              </div>
              <button class="btn btn-success w-100 btn-lg">Daftar</button>
            </form>
            <p class="mt-4 mb-0 text-center">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection