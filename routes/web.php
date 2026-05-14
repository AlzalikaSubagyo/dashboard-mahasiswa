<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\PklController;
use App\Http\Controllers\QrAbsensiController;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// QR Scan - bisa diakses tanpa login
Route::get('/qr/scan/{token}', [QrAbsensiController::class, 'scan'])->name('qr.scan');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== ADMIN =====
    Route::middleware(['admin'])->group(function () {
        Route::get('/mahasiswa/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export');
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::get('/admin/kehadiran', [KehadiranController::class, 'adminIndex'])->name('admin.kehadiran');
        Route::get('/admin/nilai', [NilaiController::class, 'adminIndex'])->name('admin.nilai');
        Route::get('/admin/aktivitas', [AktivitasController::class, 'adminIndex'])->name('admin.aktivitas');
        Route::get('/admin/pkl', [PklController::class, 'adminIndex'])->name('admin.pkl');
        Route::post('/admin/pkl/{pkl}/validasi', [PklController::class, 'validasi'])->name('admin.pkl.validasi');
        Route::get('/admin/monitoring', [DashboardController::class, 'monitoring'])->name('admin.monitoring');
    });

    // ===== MAHASISWA =====
    Route::middleware(['mahasiswa'])->group(function () {
        Route::resource('kehadiran', KehadiranController::class)->except(['show']);
        Route::resource('nilai', NilaiController::class)->except(['show']);
        Route::resource('pkl', PklController::class)->except(['show']);
        Route::get('/qr-absensi', [QrAbsensiController::class, 'show'])->name('qr.show');
    });

    Route::get('/api/matkul/{semester}', function ($semester) {
        return \App\Models\MataKuliah::where('semester', $semester)->get();
    })->name('api.matkul');
});