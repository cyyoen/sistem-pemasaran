<?php

namespace App\Http\Controllers;

use App\Models\JadwalPanen;
use App\Models\Produk;

class BerandaController extends Controller
{
    public function index()
    {
        $jadwalMendatang = JadwalPanen::whereDate('jadwal_panen', '>=', now())
            ->orderBy('jadwal_panen')
            ->limit(5)
            ->get();

        return view('beranda', compact('jadwalMendatang'));
    }

    public function produk()
    {
        return view('produk', ['produk' => Produk::orderBy('jenis_melon')->get()]);
    }

}