<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
   private function rules(): array
    {
        return [
            'jenis_melon'      => 'required|string|max:50',
            'harga_produk'     => 'required|numeric|min:0',
            'stok_jenis'       => 'required|integer|min:0',
            'gambar_produk'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi_produk' => 'nullable|string|max:500',
        ];
    }

    // Simpan file gambar baru (jika ada) dan hapus gambar lama saat diganti
    private function olahGambar(Request $request, array $data, ?Produk $produk = null): array
    {
        if ($request->hasFile('gambar_produk')) {
            if ($produk && $produk->gambar_produk) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }
            $data['gambar_produk'] = $request->file('gambar_produk')->store('produk', 'public');
        } else {
            unset($data['gambar_produk']); // tidak mengubah gambar yang sudah ada
        }

        return $data;
    }

    public function index()
    {
        return view('admin.produk.index', ['produk' => Produk::orderBy('jenis_melon')->get()]);
    }

    public function create()
    {
        return view('admin.produk.form', ['produk' => new Produk]);
    }

    public function store(Request $request)
    {
        $data = $this->olahGambar($request, $request->validate($this->rules()));
        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.form', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $this->olahGambar($request, $request->validate($this->rules()), $produk);
        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        try {
            $produk->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sudah tercatat pada data pre-order.');
        }

        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}