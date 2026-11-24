<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pandawa Farm')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/tema.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('beranda') }}">
     @if($fotoPublik('logo'))
      <img src="{{ $fotoPublik('logo') }}" alt="Logo Pandawa Farm" height="40">
    @else
      <span class="logo-placeholder">PF</span>
    @endif
      <span class="lh-sm">
        <span class="d-block text-muted" style="font-size:.65rem">Green House</span>
        <strong class="font-judul">Pandawa Farm</strong>
      </span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuUtama">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}#keunggulan">Keunggulan</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}#alur">Alur Pre-Order</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}#katalog">Katalog Melon</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}#faq">FAQ</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}#lokasi">Lokasi</a></li>
    @auth('web')
      <li class="nav-item"><a class="nav-link" href="{{ route('preorder.index') }}">Pesanan Saya</a></li>
    @endauth
    @auth('admin')
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
    @endauth
  </ul>

      <div class="d-flex flex-wrap align-items-center gap-2">
        <span class="badge rounded-pill text-bg-{{ $statusKebun[1] }}">
          <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i>{{ $statusKebun[0] }}
        </span>

        @if(!Auth::guard('admin')->check())
          <a class="btn btn-sm btn-outline-success" href="{{ route('beranda') }}#notifikasi">
            <i class="bi bi-bell"></i> <span class="d-none d-xl-inline">Notifikasi Panen</span>
          </a>
        @endif

        @auth('web')
          <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i>
              {{ \Illuminate\Support\Str::limit(Auth::guard('web')->user()->nama_pengguna, 14) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('preorder.index') }}">Pesanan Saya</a></li>
              <li><a class="dropdown-item" href="{{ route('langganan.index') }}">Notifikasi Panen</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        @elseauth('admin')
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-secondary">Logout</button>
          </form>
        @else
          <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Login</a>
          <a class="btn btn-sm btn-success" href="{{ route('register') }}">Daftar</a>
        @endauth
      </div>
    </div>
  </div>
</nav>

<div class="flex-grow-1">
  @hasSection('lebar_penuh')
    <div class="container pt-3">@include('partials.flash')</div>
    @yield('content')
  @else
    <main class="container py-4">
      @include('partials.flash')
      @yield('content')
    </main>
  @endif
</div>

@php
  $k = config('pandawa.kontak');
  $terisi = fn ($nilai) => !str_starts_with($nilai, 'ISI_');
@endphp
<footer class="footer-pf mt-5 pt-5 pb-3">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-5">
        <div class="judul fs-4 mb-2">Green House Pandawa Farm</div>
        <p class="mb-0">Agrowisata petik melon premium. Booking jatah buahmu lebih dulu, lalu datang dan petik langsung di greenhouse.</p>
      </div>

      <div class="col-6 col-md-3">
        <div class="fw-semibold mb-2">Menu</div>
        <ul class="list-unstyled mb-0">
          <li><a href="{{ route('beranda') }}">Beranda</a></li>
          <li><a href="{{ route('produk.publik') }}">Produk</a></li>
          @auth('web')<li><a href="{{ route('preorder.index') }}">Pesanan Saya</a></li>@endauth
        </ul>
      </div>

      <div class="col-6 col-md-4">
        <div class="fw-semibold mb-2">Kontak</div>
        <ul class="list-unstyled mb-0">
          <li><i class="bi bi-geo-alt me-2"></i>{{ $k['alamat'] }}</li>
          <li><i class="bi bi-clock me-2"></i>{{ $k['jam_operasional'] }}</li>
          <li>
            <i class="bi bi-whatsapp me-2"></i>
            @if($terisi($k['whatsapp']))
              <a href="https://wa.me/{{ $k['whatsapp'] }}" target="_blank" rel="noopener">WhatsApp Admin</a>
            @else
              {{ $k['whatsapp'] }}
            @endif
          </li>
          <li>
            <i class="bi bi-instagram me-2"></i>
            @if($terisi($k['instagram']))
              <a href="https://instagram.com/{{ $k['instagram'] }}" target="_blank" rel="noopener">{{ '@' . $k['instagram'] }}</a>
            @else
              {{ $k['instagram'] }}
            @endif
          </li>
          <li>
            <i class="bi bi-tiktok me-2"></i>
            @if($terisi($k['tiktok']))
              <a href="https://www.tiktok.com/{{ '@' . $k['tiktok'] }}" target="_blank" rel="noopener">{{ '@' . $k['tiktok'] }}</a>
            @else
              {{ $k['tiktok'] }}
            @endif
          </li>
        </ul>
      </div>
    </div>

    <hr class="border-light opacity-25 mt-4">
    <div class="small text-center pb-2">&copy; {{ date('Y') }} Green House Pandawa Farm</div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>