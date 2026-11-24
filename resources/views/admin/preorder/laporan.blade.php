<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pre-order</title>
  <style>
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #222; }
    h2 { margin: 0; text-align: center; }
    .sub { text-align: center; margin: 2px 0 12px; color: #555; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #444; padding: 4px 5px; vertical-align: top; }
    th { background: #e9ecef; text-align: left; }
    .kanan { text-align: right; }
    .tengah { text-align: center; }
    .info td { border: none; padding: 1px 0; }
    .ringkas { width: 45%; margin-top: 12px; }
    .kecil { font-size: 9px; color: #555; }
  </style>
</head>
<body>
  <h2>LAPORAN PRE-ORDER MELON PREMIUM</h2>
  <div class="sub">Pandawa Farm</div>

  <table class="info" style="width:60%; margin-bottom:8px">
    <tr>
      <td style="width:90px">Periode</td>
      <td>:
        @if($dari || $sampai)
          {{ $dari ? \Carbon\Carbon::parse($dari)->format('d/m/Y') : 'awal' }}
          s.d.
          {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d/m/Y') : 'sekarang' }}
        @else
          Semua periode
        @endif
      </td>
    </tr>
    <tr><td>Status</td><td>: {{ $status ? ucfirst($status) : 'Semua status' }}</td></tr>
    <tr><td>Dicetak</td><td>: {{ $dicetak->translatedFormat('d F Y, H:i') }}</td></tr>
  </table>

  <table>
    <thead>
      <tr>
        <th class="tengah" style="width:25px">No</th>
        <th style="width:35px">ID</th>
        <th style="width:80px">Tanggal</th>
        <th style="width:120px">Pemesan</th>
        <th>Rincian Pesanan</th>
        <th class="tengah" style="width:45px">buah</th>
        <th class="kanan" style="width:80px">Total Harga</th>
        <th style="width:70px">Status</th>
      </tr>
    </thead>
    <tbody>
    @forelse($orders as $i => $o)
      <tr>
        <td class="tengah">{{ $i + 1 }}</td>
        <td>#{{ $o->id_preorder }}</td>
        <td>{{ $o->tanggal_pesanan->format('d/m/Y H:i') }}</td>
        <td>{{ $o->pengguna->nama_pengguna }}<br><span class="kecil">{{ $o->pengguna->no_telepon }}</span></td>
        <td>
          @foreach($o->detail as $d)
            {{ $d->produk->jenis_melon }} &times; {{ $d->jumlah_produk }}
            (Rp {{ number_format($d->harga_satuan, 0, ',', '.') }})<br>
          @endforeach
        </td>
        <td class="tengah">{{ $o->total_jumlah_produk }}</td>
        <td class="kanan">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
        <td>{{ ucfirst($o->status_pesanan) }}</td>
      </tr>
    @empty
      <tr><td colspan="8" class="tengah">Tidak ada data pre-order pada periode ini.</td></tr>
    @endforelse
    </tbody>
  </table>

  <table class="ringkas">
    <tr><th colspan="2">Ringkasan</th></tr>
    <tr><td>Jumlah pesanan</td><td class="kanan">{{ $ringkasan['jumlah_pesanan'] }}</td></tr>
    <tr><td>Total buah</td><td class="kanan">{{ $ringkasan['total_item'] }}</td></tr>
    <tr><td>Total nilai pesanan</td><td class="kanan">Rp {{ number_format($ringkasan['total_harga'], 0, ',', '.') }}</td></tr>
  </table>
  <p class="kecil">Total buah dan total nilai tidak termasuk pesanan berstatus dibatalkan.</p>
</body>
</html>