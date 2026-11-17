<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LanggananNotifikasi;
use App\Models\PreOrder;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jmlPreorder'  => PreOrder::count(),
            'jmlProduk'    => Produk::count(),
            'jmlLangganan' => LanggananNotifikasi::where('status_langganan', 'aktif')->count(),
        ]);
    }
}