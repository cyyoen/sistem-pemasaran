<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPanen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalPanenController extends Controller
{
    public function index()
    {
        return view('admin.jadwal.index', [
            'jadwal' => JadwalPanen::orderBy('jadwal_panen', 'desc')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.jadwal.form', ['jadwal' => new JadwalPanen]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jadwal_panen' => 'required|date|unique:jadwal_panen,jadwal_panen',
        ]);
        JadwalPanen::create($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal panen berhasil ditambahkan.');
    }

    public function edit(JadwalPanen $jadwal)
    {
        return view('admin.jadwal.form', compact('jadwal'));
    }

    public function update(Request $request, JadwalPanen $jadwal)
    {
        $data = $request->validate([
            'jadwal_panen' => [
                'required', 'date',
                Rule::unique('jadwal_panen', 'jadwal_panen')->ignore($jadwal->id_panen, 'id_panen'),
            ],
        ]);
        $jadwal->update($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal panen berhasil diperbarui.');
    }

    public function destroy(JadwalPanen $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal panen berhasil dihapus.');
    }
}