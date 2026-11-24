<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LanggananController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\JadwalPanenController;
use App\Http\Controllers\Admin\LanggananAdminController;
use App\Http\Controllers\Admin\PreOrderAdminController;

// ===== Publik (Pengunjung, tanpa login) =====
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/produk', fn () => redirect(route('beranda') . '#katalog'))->name('produk.publik');
Route::redirect('/jadwal-panen', '/');
// ===== Login dan registrasi (hanya untuk yang belum login) =====
Route::middleware('guest:web,admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== Pengguna Terdaftar =====
Route::middleware('auth:web')->group(function () {
    Route::get('/langganan', [LanggananController::class, 'index'])->name('langganan.index');
    Route::post('/langganan/toggle', [LanggananController::class, 'toggle'])->name('langganan.toggle');

    Route::get('/preorder', [PreOrderController::class, 'index'])->name('preorder.index');
    Route::get('/preorder/buat', [PreOrderController::class, 'create'])->name('preorder.create');
    Route::post('/preorder', [PreOrderController::class, 'store'])->name('preorder.store');
    Route::post('/preorder/{id}/bukti', [PreOrderController::class, 'uploadBukti'])->name('preorder.bukti');
});

// ===== Admin =====
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produk', ProdukController::class)->except(['show']);
    Route::resource('jadwal', JadwalPanenController::class)->except(['show']);

    Route::get('/langganan', [LanggananAdminController::class, 'index'])->name('langganan.index');

    Route::get('/preorder', [PreOrderAdminController::class, 'index'])->name('preorder.index');
    Route::get('/preorder/laporan', [PreOrderAdminController::class, 'laporan'])->name('preorder.laporan');
    Route::patch('/preorder/{id}/status', [PreOrderAdminController::class, 'updateStatus'])->name('preorder.status');
});