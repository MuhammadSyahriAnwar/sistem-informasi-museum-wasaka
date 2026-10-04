<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KoleksiController;
use App\Http\Controllers\Api\KegiatanController;
use App\Http\Controllers\Api\PengunjungController;
use App\Http\Controllers\KelolaLaporanController; 
use App\Http\Middleware\AdminMiddleware;


// =========================================================
// 1. RUTE PUBLIK (Bisa diakses Pengunjung tanpa login)
// =========================================================
Route::post('/login', [AuthController::class, 'login']);
Route::get('/koleksi', [KoleksiController::class, 'index']);
Route::get('/kategori', [KoleksiController::class, 'getKategori']);
Route::get('/kegiatan', [KegiatanController::class, 'index']);
Route::post('/pengunjung', [PengunjungController::class, 'store']); 

// 🌟 RUTE POST LAPORAN DIPINDAH KE SINI 🌟
// Supaya pengunjung (tanpa login) dan Petugas bisa sama-sama mengirim laporan
Route::post('/lapor_kendala', [KelolaLaporanController::class, 'store']);


// =========================================================
// 2. RUTE DIKUNCI (Wajib Login / Pakai Bearer Token)
// =========================================================
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rute Pengunjung 
    Route::get('/pengunjung', [PengunjungController::class, 'index']);
    Route::get('/pengunjung/statistik', [PengunjungController::class, 'statistik']);
    Route::delete('/pengunjung/{id}', [PengunjungController::class, 'destroy']); 

    // Rute GET Laporan Internal (Melihat tabel laporan - Wajib Login)
    Route::get('/laporan-internal', [KelolaLaporanController::class, 'index']);


    // 🔒 KHUSUS KASTA ADMIN (Gembok Lapis Dua)
    Route::middleware(AdminMiddleware::class)->group(function () {
        
        // Manipulasi Data Koleksi
        Route::post('/koleksi', [KoleksiController::class, 'store']);
        Route::post('/koleksi/{id}', [KoleksiController::class, 'update']);
        Route::delete('/koleksi/{id}', [KoleksiController::class, 'destroy']);

        // Manipulasi Data Kegiatan
        Route::post('/kegiatan', [KegiatanController::class, 'store']);
        Route::post('/kegiatan/{id}', [KegiatanController::class, 'update']);
        Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy']);

        // Mengubah status laporan
        Route::put('/laporan-internal/{id}/status', [KelolaLaporanController::class, 'updateStatus']);
        // Pastikan sudah ada route index, store, dan updateStatus di sini. Tambahkan ini:
        Route::delete('/laporan-internal/{id}', [KelolaLaporanController::class, 'destroy']);
    });
});