<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPanen;
use App\Models\LanggananNotifikasi;
use App\Models\PreOrder;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jmlPreorder'    => PreOrder::count(),
            'jmlMenunggu'    => PreOrder::where('status_pesanan', 'menunggu')->count(),
            'jmlProduk'      => Produk::count(),
            'jmlLangganan'   => LanggananNotifikasi::where('status_langganan', 'aktif')->count(),
            'jadwalTerdekat' => JadwalPanen::whereDate('jadwal_panen', '>=', now())->orderBy('jadwal_panen')->first(),
            'pesananTerbaru' => PreOrder::with('pengguna')->orderByDesc('tanggal_pesanan')->limit(5)->get(),
        ]);
    }
}