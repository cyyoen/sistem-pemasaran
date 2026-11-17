<?php

namespace App\Console\Commands;

use App\Mail\PanenMail;
use App\Models\JadwalPanen;
use App\Models\LanggananNotifikasi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KirimNotifikasiPanen extends Command
{
    protected $signature = 'panen:notifikasi {--hari=3 : Kirim pengingat untuk panen N hari lagi}';

    protected $description = 'Kirim email pengingat jadwal panen kepada pengguna yang berlangganan';

    public function handle(): int
    {
        $hari = (int) $this->option('hari');
        $tanggal = now()->addDays($hari)->toDateString();

        $jadwal = JadwalPanen::whereDate('jadwal_panen', $tanggal)->first();

        if (!$jadwal) {
            $this->info("Tidak ada jadwal panen pada {$tanggal}. Tidak ada notifikasi yang dikirim.");
            return self::SUCCESS;
        }

        $pelanggan = LanggananNotifikasi::with('pengguna')
            ->where('status_langganan', 'aktif')
            ->get();

        $terkirim = 0;
        $gagal = 0;

        foreach ($pelanggan as $l) {
            if (!$l->pengguna) {
                continue;
            }

            try {
                Mail::to($l->pengguna->email)->send(new PanenMail($l->pengguna, $jadwal, $hari));
                $terkirim++;
            } catch (\Throwable $e) {
                $gagal++;
                Log::error('Notifikasi panen gagal untuk ' . $l->pengguna->email . ': ' . $e->getMessage());
            }
        }

        $this->info("Panen {$tanggal}: {$terkirim} notifikasi terkirim, {$gagal} gagal.");

        return self::SUCCESS;
    }
}