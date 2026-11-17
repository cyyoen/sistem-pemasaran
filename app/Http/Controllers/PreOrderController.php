<?php

namespace App\Http\Controllers;

use App\Models\DetailPreOrder;
use App\Models\PreOrder;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PreOrderController extends Controller
{
    public function index()
    {
        $orders = PreOrder::with('detail.produk')
            ->where('id_pengguna', Auth::id())
            ->orderByDesc('tanggal_pesanan')
            ->get();

        return view('preorder.index', compact('orders'));
    }

    public function create()
    {
        return redirect()->route('produk.publik');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah'   => 'required|array',
            'jumlah.*' => 'nullable|integer|min:0|max:100000',
        ]);

        $items = collect($request->jumlah)->filter(fn ($j) => (int) $j > 0);

        if ($items->isEmpty()) {
            return back()->withErrors(['jumlah' => 'Pilih minimal satu produk dengan jumlah lebih dari 0.']);
        }

        DB::transaction(function () use ($items) {
            $rows = [];
            $totalQty = 0;
            $totalHarga = 0;

            foreach ($items as $idProduk => $jml) {
                $jml = (int) $jml;
                $produk = Produk::lockForUpdate()->findOrFail($idProduk);

                if ($produk->stok_jenis < $jml) {
                    throw ValidationException::withMessages([
                        'jumlah' => "Stok {$produk->jenis_melon} tidak mencukupi (tersisa {$produk->stok_jenis}).",
                    ]);
                }

                $subtotal = $produk->harga_produk * $jml;
                $rows[] = ['produk' => $produk, 'jml' => $jml, 'subtotal' => $subtotal];
                $totalQty += $jml;
                $totalHarga += $subtotal;
            }

            // Data pre-order: id_produk dan jumlah_produk diisi dari item pertama
            $order = PreOrder::create([
                'id_pengguna'         => Auth::id(),
                'id_produk'           => $rows[0]['produk']->id_produk,
                'jumlah_produk'       => $rows[0]['jml'],
                'total_jumlah_produk' => $totalQty,
                'tanggal_pesanan'     => now(),
                'status_pesanan'      => 'menunggu',
                'total_harga'         => $totalHarga,
            ]);

            // Detail pre-order: semua item, lalu stok berkurang
            foreach ($rows as $r) {
                DetailPreOrder::create([
                    'id_preorder'   => $order->id_preorder,
                    'id_produk'     => $r['produk']->id_produk,
                    'jumlah_produk' => $r['jml'],
                    'harga_satuan'  => $r['produk']->harga_produk,
                    'subtotal'      => $r['subtotal'],
                ]);
                $r['produk']->decrement('stok_jenis', $r['jml']);
            }
        });

        return redirect()->route('preorder.index')
            ->with('success', 'Pre-order berhasil dibuat. Silakan unggah bukti pembayaran.');
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'bukti_pembayaran.required' => 'Pilih file bukti pembayaran terlebih dahulu.',
            'bukti_pembayaran.image'    => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes'    => 'Format gambar harus JPG, PNG, atau WEBP.',
            'bukti_pembayaran.max'      => 'Ukuran gambar maksimal 5 MB.',
            'bukti_pembayaran.uploaded' => 'Gambar gagal diunggah. Coba file yang lebih kecil.',
        ]);

        $order = PreOrder::where('id_pengguna', Auth::id())->findOrFail($id);

        if ($order->status_pesanan !== 'menunggu') {
            return back()->with('error', 'Bukti pembayaran hanya dapat diunggah untuk pesanan yang masih menunggu.');
        }

        if ($order->bukti_pembayaran) {
            Storage::disk('public')->delete($order->bukti_pembayaran);
        }

        $order->update([
            'bukti_pembayaran' => $request->file('bukti_pembayaran')->store('bukti', 'public'),
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
    }
}