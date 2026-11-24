@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10 col-xl-9">
    <div class="card overflow-hidden shadow-sm">
      <div class="row g-0">
        <div class="col-md-5 d-none d-md-block">
          @include('partials.panel-auth', [
              'judul' => 'Selamat Datang',
              'teks'  => 'Masuk untuk booking melon premium dan mengaktifkan notifikasi panen.',
          ])
        </div>

        <div class="col-md-7">
          <div class="p-4 p-lg-5">
            <h3 class="mb-4">Login</h3>
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="form-control" required autofocus>
              </div>
              <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button class="btn btn-success w-100 btn-lg">Masuk</button>
            </form>
            <p class="mt-4 mb-0 text-center">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection