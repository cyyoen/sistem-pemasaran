@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <h3 class="mb-3">Login</h3>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-success w-100">Masuk</button>
    </form>
    <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
  </div>
</div>
@endsection