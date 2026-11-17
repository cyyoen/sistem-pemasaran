<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreOrder;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class PreOrderAdminController extends Controller
{
    public function index()
    {
        $orders = PreOrder::with(['pengguna', 'detail.produk'])
            ->orderByDesc('tanggal_pesanan')
            ->get();

        return view('admin.preorder.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan',
        ]);

        $order = PreOrder::with('detail')->findOrFail($id);

        if ($order->status_pesanan === 'dibatalkan') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diubah.');
        }

        DB::transaction(function () use ($request, $order) {
            // Jika dibatalkan, kembalikan stok produk
            if ($request->status_pesanan === 'dibatalkan') {
                foreach ($order->detail as $d) {
                    Produk::where('id_produk', $d->id_produk)->increment('stok_jenis', $d->jumlah_produk);
                }
            }
            $order->update(['status_pesanan' => $request->status_pesanan]);
        });

        return back()->with('success', 'Status pesanan #' . $order->id_preorder . ' diperbarui.');
    }

    public function laporan(Request $request)
{
    $request->validate([
        'dari'   => 'nullable|date_format:Y-m-d',
        'sampai' => ['nullable', 'date_format:Y-m-d', Rule::when($request->filled('dari'), ['after_or_equal:dari'])],
        'status' => 'nullable|in:menunggu,dikonfirmasi,selesai,dibatalkan',
    ], [
        'dari.date_format'      => 'Format tanggal awal tidak valid.',
        'sampai.date_format'    => 'Format tanggal akhir tidak valid.',
        'sampai.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
    ]);

    $orders = PreOrder::with(['pengguna', 'detail.produk'])
        ->when($request->dari, fn ($q, $v) => $q->whereDate('tanggal_pesanan', '>=', $v))
        ->when($request->sampai, fn ($q, $v) => $q->whereDate('tanggal_pesanan', '<=', $v))
        ->when($request->status, fn ($q, $v) => $q->where('status_pesanan', $v))
        ->orderBy('tanggal_pesanan')
        ->get();

    // Pesanan yang dibatalkan tidak dihitung pada total
    $aktif = $orders->where('status_pesanan', '!=', 'dibatalkan');

    $pdf = Pdf::loadView('admin.preorder.laporan', [
        'orders'    => $orders,
        'ringkasan' => [
            'jumlah_pesanan' => $orders->count(),
            'total_item'     => $aktif->sum('total_jumlah_produk'),
            'total_harga'    => $aktif->sum('total_harga'),
        ],
        'dari'    => $request->dari,
        'sampai'  => $request->sampai,
        'status'  => $request->status,
        'dicetak' => now(),
    ])->setPaper('a4', 'landscape');

    return $pdf->download('laporan-preorder-' . now()->format('Ymd-His') . '.pdf');
}
}