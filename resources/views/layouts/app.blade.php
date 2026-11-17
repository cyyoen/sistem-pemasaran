<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pandawa Farm')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-success navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('beranda') }}">Pandawa Farm</a>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#menuUtama">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuUtama">
      <div class="navbar-nav ms-auto align-items-lg-center">
        <a class="nav-link" href="{{ route('produk.publik') }}">Produk</a>

        @auth('admin')
          <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
        @endauth

        @auth('web')
          <a class="nav-link" href="{{ route('preorder.index') }}">Pesanan Saya</a>
          <a class="nav-link" href="{{ route('langganan.index') }}">Notifikasi Panen</a>
        @endauth

        @if(!Auth::guard('web')->check() && !Auth::guard('admin')->check())
          <a class="nav-link" href="{{ route('login') }}">Login</a>
          <a class="nav-link" href="{{ route('register') }}">Daftar</a>
        @else
          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-sm btn-light ms-lg-2">Logout</button>
          </form>
        @endif
      </div>
    </div>
  </div>
</nav>

<main class="container py-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>