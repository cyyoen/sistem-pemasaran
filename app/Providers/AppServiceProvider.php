<?php

namespace App\Providers;

use App\Models\JadwalPanen;
use App\Models\PreOrder;
use App\Models\Produk;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mencari gambar di public/images (jpg, jpeg, png, webp). Hasilnya null jika belum ada.
        View::share('fotoPublik', function (string $nama) {
            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                if (file_exists(public_path("images/{$nama}.{$ext}"))) {
                    return asset("images/{$nama}.{$ext}");
                }
            }
            return null;
        });

        // Badge status kebun di navbar
        View::composer('layouts.app', function ($view) {
            $adaJadwal = JadwalPanen::whereDate('jadwal_panen', '>=', now())->exists();
            $adaStok   = Produk::where('stok_jenis', '>', 0)->exists();

            if (!$adaJadwal) {
                $status = ['Belum ada jadwal panen', 'secondary'];
            } elseif (!$adaStok) {
                $status = ['Kuota booking penuh', 'danger'];
            } else {
                $status = ['Pre-order dibuka', 'success'];
            }

            $view->with('statusKebun', $status);
        });

        // Jumlah pesanan berstatus menunggu, untuk menu samping admin
        View::composer('layouts.admin', function ($view) {
            $view->with('jmlPesananBaru', PreOrder::where('status_pesanan', 'menunggu')->count());
        });
    }
}