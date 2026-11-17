<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LanggananNotifikasi;

class LanggananAdminController extends Controller
{
    public function index()
    {
        $langganan = LanggananNotifikasi::with('pengguna')
            ->orderByDesc('tanggal_langganan')
            ->get();

        return view('admin.langganan.index', [
            'langganan' => $langganan,
            'jmlAktif'  => $langganan->where('status_langganan', 'aktif')->count(),
        ]);
    }
}