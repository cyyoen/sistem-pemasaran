<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin') - Pandawa Farm</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/tema.css') }}" rel="stylesheet">
</head>
<body>

<div class="admin-wrap d-lg-flex flex-grow-1">

  <aside class="offcanvas-lg offcanvas-start admin-sidebar" tabindex="-1" id="sidebarAdmin">
    <div class="offcanvas-header d-lg-none">
      <h5 class="offcanvas-title text-white">Menu Admin</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarAdmin"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3">
      <a href="{{ route('admin.dashboard') }}" class="brand-admin d-flex align-items-center gap-2 mb-4">
        @if($fotoPublik('logo'))
          <img src="{{ $fotoPublik('logo') }}" alt="Logo" height="40" class="bg-white rounded-circle p-1">
        @else
          <span class="logo-placeholder">PF</span>
        @endif
        <span class="lh-sm">
          <strong class="font-judul text-white">Pandawa Farm</strong>
          <span class="d-block small text-white opacity-75">Panel Admin</span>
        </span>
      </a>

      <nav class="nav flex-column gap-1 mb-auto">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}" href="{{ route('admin.produk.index') }}">
          <i class="bi bi-basket"></i> Kelola Produk
        </a>
        <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}" href="{{ route('admin.jadwal.index') }}">
          <i class="bi bi-calendar-event"></i> Jadwal Panen
        </a>
        <a class="nav-link {{ request()->routeIs('admin.langganan.*') ? 'active' : '' }}" href="{{ route('admin.langganan.index') }}">
          <i class="bi bi-bell"></i> Data Langganan
        </a>
        <a class="nav-link {{ request()->routeIs('admin.preorder.*') ? 'active' : '' }}" href="{{ route('admin.preorder.index') }}">
          <i class="bi bi-receipt"></i> Data Pre-order
          @if($jmlPesananBaru > 0)
            <span class="badge text-bg-warning ms-auto">{{ $jmlPesananBaru }}</span>
          @endif
        </a>
      </nav>

      <div class="border-top border-light border-opacity-25 pt-3 mt-3">
        <a class="nav-link" href="{{ route('beranda') }}" target="_blank">
          <i class="bi bi-box-arrow-up-right"></i> Lihat Situs
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="nav-link w-100 text-start"><i class="bi bi-box-arrow-left"></i> Logout</button>
        </form>
      </div>
    </div>
  </aside>

  <div class="flex-grow-1 min-w-0">
    <header class="admin-topbar d-lg-none d-flex align-items-center gap-2 p-2">
      <button class="btn btn-sm btn-outline-light" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#sidebarAdmin">
        <i class="bi bi-list fs-5"></i>
      </button>
      <strong class="font-judul text-white">Panel Admin</strong>
    </header>

    <main class="p-3 p-lg-4">
      @include('partials.flash')
      @yield('content')
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>