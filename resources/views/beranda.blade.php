@extends('layouts.app')
@section('title', 'Pandawa Farm')
@section('lebar_penuh', 'ya')
@section('content')
@php
    $sebagaiPengguna = Auth::guard('web')->check();
    $sebagaiAdmin    = Auth::guard('admin')->check();
    $k      = config('pandawa.kontak');
    $terisi = fn ($v) => !str_starts_with($v, 'ISI_');

    $terdekat = $jadwalMendatang->first();
    $selisih  = $terdekat
        ? (int) now()->startOfDay()->diffInDays($terdekat->jadwal_panen->copy()->startOfDay(), false)
        : null;
    $aktif = $langganan && $langganan->status_langganan === 'aktif';

    $keunggulan = [
        ['bi-droplet-half', 'Greenhouse Terkontrol', 'Sistem pengairan dan pemupukan otomatis menjaga tanaman tumbuh konsisten.'],
        ['bi-award', 'Satu Buah per Tanaman', 'Pembatasan satu buah pada setiap tanaman untuk mengoptimalkan ukuran dan kualitas.'],
        ['bi-flower2', 'Penyerbukan oleh Lebah', 'Bunga melon diserbuki secara alami dengan bantuan lebah.'],
        ['bi-ticket-perforated', 'Jatah Buah Terjamin', 'Booking memastikan jatah melon Anda aman dan tidak kehabisan saat panen.'],
    ];

    $alur = [
        ['Booking Jatah Buah', 'Masuk atau daftar akun, pilih varietas dan jumlah buah, lalu kirim pre-order. Booking mengamankan jatah buah Anda, sedangkan harga akhir ditentukan saat penimbangan.'],
        ['Bayar Uang Muka dan Konfirmasi', 'Transfer uang muka sesuai total yang tertera ke rekening Pandawa Farm, lalu unggah bukti transfer di menu Pesanan Saya. Admin memeriksanya dan mengubah status menjadi Dikonfirmasi. Aktifkan Notifikasi Panen agar email pengingat dikirim 3 hari sebelum panen.'],
        ['Datang dan Tukarkan Tiket', 'Datang ke greenhouse pada jadwal panen, paling lambat 7 hari setelah tanggal panen. Lewat batas itu atau berhalangan hadir, booking hangus.'],
        ['Petik, Timbang, dan Lunasi', 'Petik buah pesanan Anda, lalu timbang di kasir kebun. Harga akhir sesuai berat timbangan, dikurangi uang muka yang sudah dibayar. Sisanya dilunasi di kasir, tunai atau transfer.'],
    ];

    $faq = [
        ['Apakah saya bisa datang langsung tanpa Pre-Order?', 'Bisa, selama buah masih tersedia. Pre-order menjamin jatah Anda tidak habis.'],
        ['Apakah ada biaya tiket masuk ke Green House Pandawa Farm?', 'Tidak ada. Pengunjung masuk greenhouse tanpa biaya dan membayar sesuai berat buah yang dipetik.'],
        ['Bagaimana cara pembayarannya?', 'Saat booking, Anda membayar uang muka lewat transfer ke rekening Pandawa Farm dan mengunggah bukti transfernya. Setelah buah dipetik dan ditimbang di kasir kebun, harga akhir dihitung sesuai berat, lalu dikurangi uang muka. Sisanya dilunasi di kasir secara tunai atau transfer.'],
        ['Berapa uang muka booking?', 'Uang muka tercantum langsung pada setiap varietas (per buah) dan dijumlahkan otomatis saat Anda booking.'],
        ['Bagaimana jika saya sudah Pre-Order tetapi berhalangan hadir?', 'Tiket pre-order dapat ditukarkan paling lambat 7 hari setelah tanggal panen. Jika berhalangan hadir hingga batas terlewat, booking hangus.'],
    ];
@endphp

{{-- ===== HERO ===== --}}
<section class="hero" id="beranda">
  <div class="container">
    <div class="row align-items-center g-4 g-lg-5">
      <div class="col-lg-6 order-2 order-lg-1">
        @if($terdekat)
          <span class="badge rounded-pill text-bg-warning mb-3">
            <i class="bi bi-calendar-event me-1"></i>
            Panen terdekat: {{ $terdekat->jadwal_panen->translatedFormat('d F Y') }}
            @if($selisih > 0) ({{ $selisih }} hari lagi) @elseif($selisih === 0) (hari ini) @endif
          </span>
        @endif

        <h1 class="mb-3">Agrowisata Petik Melon Premium Green House Pandawa Farm</h1>
        <p class="lead mb-4">
          Booking buah melon premium Anda sebelum masa panen, lalu datang langsung ke greenhouse kami
          untuk memetik buah pesanan Anda sendiri.
        </p>

        <div class="d-flex flex-wrap gap-2">
          <a href="#katalog" class="btn btn-emas btn-lg">Pre-Order Melon Sekarang</a>
          @unless($sebagaiAdmin)
            <button type="button" class="btn btn-outline-success btn-lg"
                    data-bs-toggle="modal" data-bs-target="#modalNotifikasi">
              <i class="bi bi-bell me-1"></i> Aktifkan Notifikasi Panen
            </button>
          @endunless
        </div>
      </div>

      <div class="col-lg-6 order-1 order-lg-2">
        <div class="foto-bulat rasio-hero">
          @if($fotoPublik('hero'))
            <img src="{{ $fotoPublik('hero') }}" alt="Green House Pandawa Farm">
          @else
            <div class="placeholder-foto w-100 h-100">
              <i class="bi bi-image fs-1"></i>
              <div class="fw-semibold">Foto utama greenhouse</div>
              <small>Simpan sebagai public/images/hero.jpg</small>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== KEUNGGULAN ===== --}}
<section class="bagian bagian-putih" id="keunggulan">
  <div class="container">
    <div class="judul-bagian">
      <h2>Keunggulan Melon Pandawa Farm</h2>
      <p>Dibudidayakan di greenhouse dengan perawatan terkontrol untuk menjaga mutu setiap buah.</p>
    </div>
    <div class="row g-4">
      @foreach($keunggulan as $u)
        <div class="col-6 col-lg-3">
          <div class="card kartu-keunggulan">
            <div><span class="ikon-bulat"><i class="bi {{ $u[0] }}"></i></span></div>
            <h5 class="fw-semibold">{{ $u[1] }}</h5>
            <p class="text-muted small mb-0">{{ $u[2] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== ALUR ===== --}}
<section class="bagian" id="alur">
  <div class="container">
    <div class="judul-bagian">
      <h2>Alur Pre-Order dan Petik di Kebun</h2>
      <p>Empat langkah mudah dari booking sampai melon dibawa pulang.</p>
    </div>
    <div class="row g-4">
      @foreach($alur as $i => $l)
        <div class="col-md-6 col-lg-3 langkah">
          <span class="nomor">{{ sprintf('%02d', $i + 1) }}</span>
          <h5 class="fw-semibold">{{ $l[0] }}</h5>
          <p class="text-muted small mb-0">{{ $l[1] }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== KATALOG ===== --}}
<section class="bagian bagian-putih" id="katalog">
  <div class="container">
    <div class="judul-bagian">
      <h2>Katalog Varietas dan Kuota Pre-Order</h2>
      <p>Booking hanya mengamankan jatah buah Anda. Harga akhir mengikuti berat timbangan saat panen.</p>
    </div>

    <div class="banner-kuota mb-4">
      <div class="row g-2 align-items-center">
        <div class="col-md">
          <i class="bi bi-calendar-check me-2"></i><strong>Jadwal Panen Terdekat:</strong>
          @if($terdekat) {{ $terdekat->jadwal_panen->translatedFormat('l, d F Y') }} @else belum ada jadwal @endif
        </div>
        <div class="col-md-auto">
          <i class="bi bi-basket me-2"></i><strong>Sisa Kuota Booking:</strong>
          {{ number_format($totalStok, 0, ',', '.') }} buah
        </div>
      </div>
      @if($jadwalMendatang->count() > 1)
        <div class="small text-muted mt-2">
          Jadwal berikutnya:
          {{ $jadwalMendatang->skip(1)->map(fn ($j) => $j->jadwal_panen->translatedFormat('d M Y'))->implode(', ') }}
        </div>
      @endif
    </div>

    <div class="row g-4">
      @forelse($produk as $p)
        <div class="col-md-6 col-lg-4">
          <div class="card kartu-produk h-100">
            @if($p->gambar_produk)
              <img src="{{ asset('storage/'.$p->gambar_produk) }}" class="gambar" alt="{{ $p->jenis_melon }}">
            @else
              <div class="placeholder-foto rasio-kartu">
                <i class="bi bi-image fs-2"></i>
                <small>Foto {{ $p->jenis_melon }}</small>
              </div>
            @endif

            <div class="card-body d-flex flex-column">
              <h5 class="font-judul mb-1">{{ $p->jenis_melon }}</h5>
              @if($p->deskripsi_produk)
                <p class="small text-muted">{{ $p->deskripsi_produk }}</p>
              @endif

              <div class="mt-auto">
                <div class="harga-uang-muka">
                  Rp {{ number_format($p->harga_produk, 0, ',', '.') }}
                  <small class="text-muted fw-normal">uang muka / buah</small>
                </div>

                @if($p->stok_jenis > 0)
                  <div class="small text-muted mb-3">Stok: {{ $p->stok_jenis }} buah</div>
                @else
                  <div class="mb-3"><span class="badge text-bg-secondary">Stok habis</span></div>
                @endif

                @unless($sebagaiAdmin)
                  <button type="button" class="btn btn-success w-100"
                          data-bs-toggle="modal" data-bs-target="#modalPreorder"
                          data-produk="{{ $p->id_produk }}" @disabled($p->stok_jenis < 1)>
                    Booking / Pre-Order Varietas Ini
                  </button>
                @endunless
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-center text-muted">Belum ada produk.</p></div>
      @endforelse
    </div>
  </div>
</section>

{{-- ===== BANNER NOTIFIKASI ===== --}}
<section class="bagian" id="banner-notifikasi">
  <div class="container">
    <div class="banner-notifikasi text-center">
      <h2 class="mb-2">Jangan Ketinggalan Jadwal Panen</h2>
      <p class="mb-4">Aktifkan notifikasi dan terima email pengingat 3 hari sebelum jadwal panen.</p>
      @if($sebagaiAdmin)
        <p class="mb-0 small">Fitur ini tersedia untuk pengguna terdaftar.</p>
      @else
        <button type="button" class="btn btn-emas btn-lg" data-bs-toggle="modal" data-bs-target="#modalNotifikasi">
          <i class="bi bi-bell me-1"></i>
          {{ $aktif ? 'Notifikasi Aktif (Kelola)' : 'Ingatkan Saya Saat Panen' }}
        </button>
      @endif
    </div>
  </div>
</section>

{{-- ===== FAQ ===== --}}
<section class="bagian bagian-putih" id="faq">
  <div class="container">
    <div class="judul-bagian"><h2>Pertanyaan yang Sering Diajukan</h2></div>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion" id="faqAkordeon">
          @foreach($faq as $i => $item)
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button {{ $i === 0 ? '' : 'collapsed' }}" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">
                  {{ $item[0] }}
                </button>
              </h2>
              <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                   data-bs-parent="#faqAkordeon">
                <div class="accordion-body">{{ $item[1] }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== LOKASI ===== --}}
<section class="bagian" id="lokasi">
  <div class="container">
    <div class="judul-bagian"><h2>Lokasi Kebun</h2></div>
    <div class="row g-4 align-items-center">
      <div class="col-lg-5">
        <h4 class="font-judul mb-3">Green House Pandawa Farm</h4>
        <ul class="list-unstyled mb-4">
          <li class="mb-2"><i class="bi bi-geo-alt text-success me-2"></i>{{ $k['alamat'] }}</li>
          <li><i class="bi bi-clock text-success me-2"></i>{{ $k['jam_operasional'] }}</li>
        </ul>

        <div class="d-flex flex-wrap gap-2">
          @if($terisi($k['whatsapp']))
            <a class="btn btn-success" href="https://wa.me/{{ $k['whatsapp'] }}" target="_blank" rel="noopener">
              <i class="bi bi-whatsapp me-1"></i> Hubungi via WhatsApp
            </a>
          @else
            <span class="btn btn-outline-secondary disabled"><i class="bi bi-whatsapp me-1"></i> {{ $k['whatsapp'] }}</span>
          @endif

          @if($terisi($k['instagram']))
            <a class="btn btn-outline-success" href="https://instagram.com/{{ $k['instagram'] }}" target="_blank" rel="noopener">
              <i class="bi bi-instagram"></i>
            </a>
          @endif

          @if($terisi($k['tiktok']))
            <a class="btn btn-outline-success" href="https://www.tiktok.com/{{ '@' . $k['tiktok'] }}" target="_blank" rel="noopener">
              <i class="bi bi-tiktok"></i>
            </a>
          @endif
        </div>
      </div>

      <div class="col-lg-7">
        @if($terisi($k['maps_embed']))
          <iframe class="peta" src="{{ $k['maps_embed'] }}" loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        @else
          <div class="placeholder-foto peta">
            <i class="bi bi-map fs-1"></i>
            <div class="fw-semibold">Peta Google Maps</div>
            <small>Isi nilai maps_embed di config/pandawa.php</small>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ===== MODAL PRE-ORDER ===== --}}
<div class="modal fade" id="modalPreorder" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-judul">Pre-Order Melon Premium</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      @if($sebagaiPengguna)
        <form method="POST" action="{{ route('preorder.store') }}">
          @csrf
          <div class="modal-body">
            <div class="alert alert-warning small">
              Booking hanya mengamankan jatah buah Anda. Total di bawah adalah <strong>uang muka</strong>.
              Setelah booking, transfer uang muka dan unggah bukti transfer di menu Pesanan Saya.
              Harga akhir dihitung saat penimbangan di kebun.
            </div>

            @php $tersedia = $produk->where('stok_jenis', '>', 0); @endphp
            @if($tersedia->isEmpty())
              <p class="text-muted mb-0">Belum ada varietas yang tersedia untuk dibooking.</p>
            @else
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead class="table-light">
                    <tr><th>Varietas</th><th>Uang muka / buah</th><th>Stok</th><th style="width:130px">Jumlah (buah)</th></tr>
                  </thead>
                  <tbody>
                    @foreach($tersedia as $p)
                      <tr>
                        <td>{{ $p->jenis_melon }}</td>
                        <td>Rp {{ number_format($p->harga_produk, 0, ',', '.') }}</td>
                        <td>{{ $p->stok_jenis }}</td>
                        <td>
                          <input type="number" name="jumlah[{{ $p->id_produk }}]" class="form-control form-control-sm jumlah"
                                 min="0" max="{{ $p->stok_jenis }}" step="1"
                                 value="{{ old('jumlah.'.$p->id_produk, 0) }}"
                                 data-id="{{ $p->id_produk }}" data-harga="{{ (int) $p->harga_produk }}">
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
          <div class="modal-footer">
            <span class="me-auto">Total uang muka: <strong id="totalModal">Rp 0</strong></span>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-success" id="kirimModal" disabled>Kirim Pre-Order</button>
          </div>
        </form>

      @elseif($sebagaiAdmin)
        <div class="modal-body">Akun admin tidak dapat melakukan pre-order.</div>

      @else
        <div class="modal-body text-center py-4">
          <p class="mb-3">Untuk melakukan pre-order, silakan login atau daftar terlebih dahulu.</p>
          <a href="{{ route('login', ['kembali' => 'produk']) }}" class="btn btn-success me-2">Login</a>
          <a href="{{ route('register', ['kembali' => 'produk']) }}" class="btn btn-outline-success">Daftar</a>
        </div>
      @endif
    </div>
  </div>
</div>

{{-- ===== MODAL NOTIFIKASI PANEN ===== --}}
<div class="modal fade" id="modalNotifikasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-judul">Notifikasi Panen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      @if($sebagaiPengguna)
        <div class="modal-body">
          <p class="mb-2">Status langganan:
            @if($aktif)
              <span class="badge text-bg-success">Aktif</span>
            @else
              <span class="badge text-bg-secondary">Tidak aktif</span>
            @endif
          </p>
          <p class="mb-3">
            Email pengingat dikirim ke <strong>{{ Auth::guard('web')->user()->email }}</strong>
            3 hari sebelum jadwal panen.
          </p>
          <form method="POST" action="{{ route('langganan.toggle') }}">
            @csrf
            @if($aktif)
              <button class="btn btn-outline-danger w-100">Nonaktifkan Notifikasi</button>
            @else
              <button class="btn btn-success w-100">Aktifkan Notifikasi</button>
            @endif
          </form>
        </div>

      @elseif($sebagaiAdmin)
        <div class="modal-body">Fitur ini tersedia untuk pengguna terdaftar.</div>

      @else
        <div class="modal-body text-center py-4">
          <p class="mb-3">Untuk mengaktifkan notifikasi panen, silakan login atau daftar terlebih dahulu.</p>
          <a href="{{ route('login', ['kembali' => 'produk']) }}" class="btn btn-success me-2">Login</a>
          <a href="{{ route('register', ['kembali' => 'produk']) }}" class="btn btn-outline-success">Daftar</a>
        </div>
      @endif
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modalPre   = document.getElementById('modalPreorder');
  const modalNotif = document.getElementById('modalNotifikasi');

  if (modalPre) {
    const kolom = modalPre.querySelectorAll('.jumlah');
    const total = document.getElementById('totalModal');
    const kirim = document.getElementById('kirimModal');

    function hitung() {
      if (!total || !kirim) return;
      let jumlah = 0;
      kolom.forEach(k => jumlah += (parseInt(k.value) || 0) * parseInt(k.dataset.harga));
      total.textContent = 'Rp ' + jumlah.toLocaleString('id-ID');
      kirim.disabled = jumlah === 0;
    }

    kolom.forEach(k => k.addEventListener('input', hitung));
    hitung();

    // Varietas yang diklik langsung terisi 1 buah
    modalPre.addEventListener('show.bs.modal', function (e) {
      const tombol = e.relatedTarget;
      if (tombol && tombol.dataset && tombol.dataset.produk) {
        kolom.forEach(k => {
          if (k.dataset.id === tombol.dataset.produk && (parseInt(k.value) || 0) === 0) {
            k.value = 1;
          }
        });
        hitung();
      }
    });

    // Buka kembali jendela jika pemesanan ditolak (misalnya stok tidak cukup)
    @if($errors->has('jumlah') || $errors->has('jumlah.*'))
      bootstrap.Modal.getOrCreateInstance(modalPre).show();
    @endif
  }

  // Tombol lonceng di navbar (tautan #notifikasi) membuka jendela notifikasi
  function bukaDariHash() {
    if (location.hash === '#notifikasi' && modalNotif) {
      bootstrap.Modal.getOrCreateInstance(modalNotif).show();
      history.replaceState(null, '', location.pathname + location.search);
    }
  }
  window.addEventListener('hashchange', bukaDariHash);
  bukaDariHash();
});
</script>
@endsection