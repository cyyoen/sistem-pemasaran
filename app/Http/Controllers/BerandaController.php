<?php

namespace App\Http\Controllers;

use App\Models\JadwalPanen;
use App\Models\LanggananNotifikasi;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('jenis_melon')->get();

        $jadwalMendatang = JadwalPanen::whereDate('jadwal_panen', '>=', now())
            ->orderBy('jadwal_panen')
            ->limit(5)
            ->get();

        $langganan = Auth::guard('web')->check()
            ? LanggananNotifikasi::where('id_pengguna', Auth::guard('web')->id())->first()
            : null;

        return view('beranda', [
            'produk'          => $produk,
            'totalStok'       => $produk->sum('stok_jenis'),
            'jadwalMendatang' => $jadwalMendatang,
            'langganan'       => $langganan,
        ]);
    }
}