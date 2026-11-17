<div style="font-family: Arial, sans-serif; max-width: 520px; margin: auto; color: #222;">
  <h2 style="color: #198754;">Pandawa Farm</h2>

  <p>Halo {{ $pengguna->nama_pengguna }},</p>

  <p>
    Panen melon premium Pandawa Farm dijadwalkan pada
    <strong>{{ $jadwal->jadwal_panen->translatedFormat('l, d F Y') }}</strong>
    @if($hari > 0) ({{ $hari }} hari lagi) @else (hari ini) @endif.
  </p>

  <p>
    Kamu bisa datang langsung untuk memetik melon, atau pesan lebih dulu lewat
    <a href="{{ route('produk.publik') }}">halaman produk</a>.
  </p>

  <p style="color: #666; font-size: 12px;">
    Email ini dikirim karena kamu berlangganan notifikasi panen.
    Untuk berhenti, nonaktifkan langganan di menu Notifikasi Panen setelah login.
  </p>
</div>