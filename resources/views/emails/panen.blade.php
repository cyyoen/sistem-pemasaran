@php
  // Batas penukaran tiket: 7 hari setelah tanggal panen
  $batas = $jadwal->jadwal_panen->copy()->addDays(7);
@endphp
<div style="font-family: Arial, sans-serif; max-width: 520px; margin: auto; color: #222;">
  <h2 style="color: #198754;">Pandawa Farm</h2>

  <p>Halo {{ $pengguna->nama_pengguna }},</p>

  <p>
    Panen melon premium Pandawa Farm dijadwalkan pada
    <strong>{{ $jadwal->jadwal_panen->translatedFormat('l, d F Y') }}</strong>
    @if($hari > 0) ({{ $hari }} hari lagi) @else (hari ini) @endif.
  </p>

  <div style="background: #fff8e1; border-left: 4px solid #f2a93b; padding: 10px 14px; margin: 16px 0;">
    <strong>Batas penukaran tiket pre-order</strong><br>
    Jika kamu sudah melakukan pre-order, tiket bookingmu dapat ditukarkan paling lambat
    <strong>7 hari setelah tanggal panen</strong>, yaitu
    <strong>{{ $batas->translatedFormat('l, d F Y') }}</strong>.
    Mohon datang sebelum batas tersebut.
  </div>

  <p>
    Kamu bisa datang langsung untuk memetik melon, atau pesan lebih dulu lewat
    <a href="{{ route('produk.publik') }}">halaman produk</a>.
  </p>

  <p style="color: #666; font-size: 12px;">
    Email ini dikirim karena kamu berlangganan notifikasi panen.
    Untuk berhenti, nonaktifkan langganan di menu Notifikasi Panen setelah login.
  </p>
</div>