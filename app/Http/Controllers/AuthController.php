<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->query('kembali') === 'produk') {
            $request->session()->put('url.intended', route('produk.publik'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Coba sebagai Admin dulu
        if (Auth::guard('admin')->attempt($cred)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Lalu sebagai Pengguna Terdaftar
        if (Auth::guard('web')->attempt($cred)) {
            $request->session()->regenerate();
            return redirect()->intended(route('beranda'));
        }

        return back()
            ->withErrors(['username' => 'Username atau password salah.'])
            ->onlyInput('username');
    }

    public function showRegister(Request $request)
    {
        if ($request->query('kembali') === 'produk') {
            $request->session()->put('url.intended', route('produk.publik'));
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'email'         => 'required|email|max:100|unique:pengguna_terdaftar,email',
            'username'      => 'required|alpha_dash|max:50|unique:pengguna_terdaftar,username',
            'no_telepon'    => 'required|digits_between:10,15',
            'password'      => 'required|min:8|confirmed',
        ]);

        $pengguna = Pengguna::create($data);
        Auth::guard('web')->login($pengguna);
        $request->session()->regenerate();

        return redirect()->intended(route('beranda'))->with('success', 'Registrasi berhasil. Selamat datang!');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}