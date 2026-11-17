<?php

namespace App\Http\Controllers;

use App\Models\JadwalPanen;
use App\Models\LanggananNotifikasi;
use Illuminate\Support\Facades\Auth;

class LanggananController extends Controller
{
    public function index()
    {
        return view('langganan', [
            'langganan' => LanggananNotifikasi::where('id_pengguna', Auth::id())->first(),
            'jadwal'    => JadwalPanen::whereDate('jadwal_panen', '>=', now())
                                ->orderBy('jadwal_panen')
                                ->get(),
        ]);
    }

    public function toggle()
    {
        $langganan = LanggananNotifikasi::firstOrNew(['id_pengguna' => Auth::id()]);

        if (!$langganan->exists || $langganan->status_langganan === 'nonaktif') {
            $langganan->status_langganan = 'aktif';
            $langganan->tanggal_langganan = now()->toDateString();
            $pesan = 'Langganan notifikasi panen diaktifkan.';
        } else {
            $langganan->status_langganan = 'nonaktif';
            $pesan = 'Langganan notifikasi panen dinonaktifkan.';
        }
        $langganan->save();

        return back()->with('success', $pesan);
    }
}